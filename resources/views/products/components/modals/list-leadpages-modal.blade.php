<div class="modal fade" id="modal-list-leadpages-{{ $product->id }}">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">leadpages deste imóvel</h4>
                <a type="button" class="close" data-dismiss="modal">&times;</a>
            </div>
            <div class="modal-body">
                <center>
                    <a href="{{route('websites.create', $product)}}" class="btn btn-primary mb-3">Nova leadpage</a>
                </center>
                @if(count($product->websites) == 0)
                    <p>Este produto ainda não tem nenhuma leadpage</p>
                @endif

                @foreach($product->websites as $website)
                    <table>
                        <tbody>
                            <tr>
                                <td>{{$website->name}}</td>
                                <td><button class="btn btn-primary">Editar</button><button class="btn btn-danger">Excluir</button></td>
                            </tr>
                        </tbody>
                    </table>
                @endforeach
            </div>
            <div class="modal-footer">
                <a type="button" class="btn btn-default" data-dismiss="modal">Fechar</a>
            </div>
        </div>
    </div>
</div>