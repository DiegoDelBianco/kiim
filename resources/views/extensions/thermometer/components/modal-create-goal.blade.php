

        <!-- Modal -->
        <div class="modal fade" id="modal-create-goal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <form id="addGoalFrom" method="POST" action="{{route('extensions.thermometer.new-goal')}}">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">Adicionar Meta</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group row">
                                <label for="titleGoal"  class="col-md-4 col-form-label text-md-right">{{ __('Titulo da meta: ') }}</label>
                                <div class="col-md-6">
                                    <input id="titleGoal" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title">
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="award_valueGoal"  class="col-md-4 col-form-label text-md-right">{{ __('Valor do premio: ') }}</label>
                                <div class="col-md-6 input-group">
                                    <span class="input-group-text" style="border-top-right-radius: 0;border-bottom-right-radius: 0;" id="basic-addon1">R$</span>
                                    <input id="award_valueGoal" type="text" class="form-control mask-money @error('award_value') is-invalid @enderror" name="award_value" value="{{ old('award_value') }}" autocomplete="award_value">
                                    @error('award_value')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="set_limit_leadGoal"  class="col-md-4 col-form-label text-md-right">{{ __('Limite de lead diário após meta batida: ') }}</label>
                                <div class="col-md-6">
                                    <input id="set_limit_leadGoal" type="number" class="form-control @error('set_limit_lead') is-invalid @enderror" name="set_limit_lead" value="{{ old('set_limit_lead') }}" autocomplete="set_limit_lead">
                                    @error('set_limit_lead')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="goalGoal"  class="col-md-4 col-form-label text-md-right">{{ __('Meta em vendas: (Qtd)') }}</label>
                                <div class="col-md-6">
                                    <input id="goalGoal" type="number" class="form-control @error('goal') is-invalid @enderror" name="goal" value="{{ old('goal') }}" autocomplete="goal">
                                    @error('goal')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="trophy_svgGoal"  class="col-md-4 col-form-label text-md-right">{{ __('Imagem') }}</label>
                                <div class="col-md-6">
                                <select id="trophy_svgGoal" name="trophy_svg" class="form-control @error('trophy_svg') is-invalid @enderror" onchange="exibirImagemSelecionada()">
                                    <option value="">Selecione</option>
                                    @foreach($images as $image)
                                        <option data-image="{{asset($image['file'])}}" value="{{$image['image']}}">{{$image['title']}}</option>
                                    @endforeach
                                </select>
                                @error('trophy_svgGoal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>

                            <center>
                            <img id="imagemSelecionada" src="" class="d-none" style="width: 100px; height: 100px;">
                            </center>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Adicionar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
        function exibirImagemSelecionada() {
            var select = document.getElementById("trophy_svgGoal");
            var imagemSelecionada = document.getElementById("imagemSelecionada");
            var imagem = select.options[select.selectedIndex].getAttribute("data-image");

            if (imagem === null) {
                imagemSelecionada.classList.add("d-none");
            } else {
                imagemSelecionada.classList.remove("d-none");
                imagemSelecionada.src = imagem;
            }
        }
        </script>
