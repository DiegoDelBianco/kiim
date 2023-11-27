<div style="float:right; padding-right: 20px;" class="pr-3"><p><strong>Total: </strong><span id="total-clientes">{{$customers->total()}}</span> Leads</p></div>
<table  class="table customers" style="width: 100%;">
    <thead>
        <tr>
            <td></td>
            <td>#</td>
            <td>Cliente</td>
            <td>Atendente</td>
            <td>Empresa</td>
            <td>Equipe</td>
            <td>Estágio</td>
            <td>Criado</td>
            <td></td>
        </tr>
    </thead>

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
                <td>{{$customer->user_name}}</td>
                <td>{{\App\Models\Tenancy::find( $customer->tenancy)->name}}</td>
                <td>{{$customer->team}}</td>
                <td ><b>{{ \App\Models\Customer::stageTitle($customer->stage_id) }}</b></td>
                <td>{{ date( 'd/m/Y H:i' , strtotime($customer->created_at)) }}</td>
                <td>
                    <a class="btn btn-primary" style="font-size: 12px" href="{{route('customers.show', $customer->id)}}"><i class="fas fa-eye"></i></a>
                    @can('customer-redirect', $customer)
                    <button type="button" class="btn btn-info" style="font-size: 12px" data-toggle="modal" data-target="#modal-redirect-customer-{{ $customer->id }}"><i class="fas fa-recycle"></i></button>
                    @endcan
                    <button type="button" class="btn btn-danger" style="font-size: 12px" data-toggle="modal" data-target="#modal-delete-customer-{{ $customer->id }}"><i class="fas fa-trash"></i></button>
                    @include('customers.components.modals.delete-customer-modal')
                    @include('customers.components.modals.redirect-customer-modal')
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
<div class="paginacao">
    {{$customers->render()}}
</div>

