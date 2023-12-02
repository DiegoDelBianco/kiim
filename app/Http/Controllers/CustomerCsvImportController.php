<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerCsvImport;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenancy;

class CustomerCsvImportController extends Controller
{
    public function index()
    {

        $tenancies = [];
        $imports_by_tenancy = [];
        foreach(Auth::user()->roles as $tenancy){
            $current_tenancy = Tenancy::find($tenancy->tenancy_id);
            $tenancies[$tenancy->tenancy_id] = $current_tenancy;
            if(Auth::user()->can('manage-users', $tenancy->tenancy_id)){
                $imports_by_tenancy[$tenancy->tenancy_id] = CustomerCsvImport::where('tenancy_id', $current_tenancy->id)->get();
            }
        }


        $import_list = $imports_by_tenancy; // CustomerCsvImport::where('tenancy_id', Auth::user()->tenancy_id);

        return view('customers-import-csv/index-customers-import-csv', compact('import_list', "tenancies"));
    }

    //store function
    public function store(Request $request)
    {
        $request->validate([
            'tenancy_id' => 'required',
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        $tenancy = Tenancy::find($request->tenancy_id);
        if(!$tenancy){
            return redirect()->route('customers.importCsv')->with('error', 'Empresa não encontrada');
        }

        $rel = $tenancy->users()->where('user_id', Auth::user()->id)->first();

        if(!$rel)
            return redirect()->back()->with('error', 'Você não tem permissão para adicionar leads nesta empresa');


        $file = $request->file('csv_file');
        $file_name = time().Auth::user()->id.'-'.$file->getClientOriginalName();
        $file->storeAs('csv-import', $file_name, 'public');

        $import = new CustomerCsvImport();
        $import->file = $file_name;
        $import->user_id = Auth::user()->id;
        $import->tenancy_id = $tenancy->id;
        $import->count_leads = 0;
        $import->status = 'Processando';
        $import->save();

        return redirect()->route('customers.importCsv.selectHead', $import->id);
    }

    //selectHead function
    public function selectHead(customerCsvImport $customerCsvImport)
    {
        //$this->authorize('view', $customerCsvImport);

        $tenancy = $customerCsvImport->tenancy;

        $rel = $tenancy->users()->where('user_id', Auth::user()->id)->first();

        if(!$rel)
            return redirect()->back()->with('error', 'Você não tem permissão para adicionar leads nesta empresa');


        $import = $customerCsvImport;
        $file = storage_path('app/public/csv-import/' . $import->file);
        $file = fopen($file, 'r');
        $head = fgetcsv($file, 0, ';');
        fclose($file);
        $fields_to_save = CustomerCsvImport::getFieldsToSave();
        return view('customers-import-csv/select-head', compact('import', 'head', 'fields_to_save'));
    }

    //finalize function
    public function finalize(Request $request, CustomerCsvImport $customerCsvImport)
    {
        $this->authorize('view', $customerCsvImport);

        // loop, we will create a new customer for each row in the CSV file.
        $import = $customerCsvImport;
        $file = storage_path('app/public/csv-import/' . $import->file);
        $file = fopen($file, 'r');
        $head = fgetcsv($file, 0, ';');
        $count = 0;
        $list_fields = CustomerCsvImport::getFieldsToSave();
        $novo = $request->importas == 'novo' ? true : false;
        while (($row = fgetcsv($file, 0, ';')) !== false) {
            $count++;
            $fields = $request->except(['_token', 'importas']);
            $customer = new Customer();

            foreach ($fields as $key => $column_name) {

                if($column_name == '') continue;

                // use the $value as column name from customer table, and $value as column name from CSV file.
                // remove prefix 'opt-' from $key to get the offet option in row.
                $value = $row[str_replace('opt-', '', $key)];
                $callfunc = 'prepare_'.$list_fields[$column_name]['func'];
                $customer = CustomerCsvImport::$callfunc($value, $column_name, $customer);
            }

            $customer->opened = $novo ? 2 : 1;
            $customer->stage_id = $novo ? 1 : 4;
            $customer->new = $novo;

            $customer->source = 'CSV';
            $customer->customer_csv_import_id = $import->id;
            //$customer->team_id = $row[$request->team_id];
            $customer->tenancy_id = $import->tenancy_id;
            $customer->save();
        }
        fclose($file);




        $import->status = 'Concluído';
        $import->count_leads = $count;
        $import->save();
        return redirect()->route('customers.importCsv');
    }
}
