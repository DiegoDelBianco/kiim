<table  class="table customers" style="width: 100%;">

    @if(isset($customers) && $customers->count() > 0 )
        <tbody>
            @foreach($customers as $customer)
            <tr>
                <td><input class="checkDesign" type="checkbox" name="_check[]" form="formulario" value='{{ $customer->id }}' data-id='{{ $customer->id }}'></td>
                <td>{{$customer->id}}</td>
                <td>
                    <strong style="display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{$customer->name}}</strong>
                    <br><span style="display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 13px;" class="event-text">Dado sobre o Lead</span>
                </td>
                <td>{{$customer->user->name}}</td>
                <td><b>Data da venda:</b> <br> {{date('d/m/Y', strtotime($customer->buy_date))}}</td>
                <td><b>Data do pagamento:</b> <br> {{date('d/m/Y', strtotime($customer->pay_date))}}</td>
                <td ><b>{{ \App\Models\Customer::stageTitle($customer->stage_id) }}</b></td>
                <td>{{ date( 'd/m/Y H:i' , strtotime($customer->created_at)) }}</td>
                <td>
                    <a class="btn btn-primary" style="font-size: 12px" href="{{route('customers.show', $customer->id)}}"><i class="fas fa-eye"></i></a>
                    @include('customers.components.modals.delete-customer-modal')
                </td>
            </tr>
            @endforeach
        </tbody>
    @else
       <tr>
           <td colspan="3">
               <div class="alert alert-warning" role="alert">
                   Nenhum lead encontrado
               </div>
            </td>
         <tr>
    @endif
</table>

