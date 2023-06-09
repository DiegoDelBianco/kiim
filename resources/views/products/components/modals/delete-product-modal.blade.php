                                    <div class="modal fade" id="modal-delete-product-{{ $product->id }}">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Excluir Imóvel</h4>
                                                    <a type="button" class="close" data-dismiss="modal">&times;</a>
                                                </div>
                                                <div class="modal-body">
                                                    <p>
                                                        <h4>Tem certeza que deseja deletar o imóvel</h4>
                                                        <span>{{ $product->title }}?</span>
                                                        <hr>
                                                        <form id="delete-product-{{ $product->id }}" action="{{ route('products.destroy', $product) }}" class="float-left" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <a type="button" class="btn btn-default" data-dismiss="modal">Cancelar</a>
                                                    <input type="submit" form="delete-product-{{ $product->id }}" class="btn btn-warning" value="Deletar">
                                                </div>
                                            </div>
                                        </div>
                                    </div>