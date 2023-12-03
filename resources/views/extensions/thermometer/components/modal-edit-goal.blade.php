<!-- Modal -->
<div class="modal fade" id="modal-edit-goal-{{$goal->id}}" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form id="editGoalFrom-{{$goal->id}}" method="POST" action="{{route('extensions.thermometer.up-goal', $goal)}}">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h4 class="modal-title">Editar Meta</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label for="titleGoal-{{$goal->id}}"  class="col-md-4 col-form-label text-md-right">{{ __('Titulo da meta: ') }}</label>
                        <div class="col-md-6">
                            <input id="titleGoal-{{$goal->id}}" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $goal->title) }}" required autocomplete="title">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>



                    <div class="form-group row">
                        <label for="award_valueGoal-{{$goal->id}}"  class="col-md-4 col-form-label text-md-right">{{ __('Valor do premio: ') }}</label>
                        <div class="col-md-6 input-group">
                            <span class="input-group-text" style="border-top-right-radius: 0;border-bottom-right-radius: 0;" id="basic-addon1">R$</span>
                            <input id="award_valueGoal-{{$goal->id}}" type="text" class="form-control mask-money @error('award_value') is-invalid @enderror" name="award_value" value="{{ old('award_value', number_format($goal->award_value, 2, ',', '.')) }}" autocomplete="award_value">
                            @error('award_value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="set_limit_leadGoal-{{$goal->id}}"  class="col-md-4 col-form-label text-md-right">{{ __('Limite de lead diário após meta batida: ') }}</label>
                        <div class="col-md-6">
                            <input id="set_limit_leadGoal-{{$goal->id}}" type="number" class="form-control @error('set_limit_lead') is-invalid @enderror" name="set_limit_lead" value="{{ old('set_limit_lead', $goal->set_limit_lead) }}" autocomplete="set_limit_lead">
                            @error('set_limit_lead')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="goalGoal-{{$goal->id}}"  class="col-md-4 col-form-label text-md-right">{{ __('Meta em vendas: (Qtd)') }}</label>
                        <div class="col-md-6">
                            <input id="goalGoal-{{$goal->id}}" type="number" class="form-control @error('goal') is-invalid @enderror" name="goal" value="{{ old('goal', intval($goal->goal)) }}" autocomplete="goal">
                            @error('goal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="trophy_svgGoal-{{$goal->id}}"  class="col-md-4 col-form-label text-md-right">{{ __('Imagem') }}</label>
                        <div class="col-md-6">
                        <select id="trophy_svgGoal-{{$goal->id}}" name="trophy_svg" class="form-control @error('trophy_svg') is-invalid @enderror" onchange="exibirImagemSelecionada{{$goal->id}}()">
                            <option value="">Selecione</option>
                            @foreach($images as $image)
                                <option {{$goal->trophy_svg == $image['image'] ? 'selected' : null}}  data-image="{{asset($image['file'])}}" value="{{$image['image']}}">{{$image['title']}}</option>
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
                        <img id="imagemSelecionada-{{$goal->id}}" src="{{\App\Models\Extensions\Thermometer::getImagePath($goal->trophy_svg)}}" class="{{$goal->trophy_svg ? null : 'd-none'}}" style="width: 100px; height: 100px;">
                    </center>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
        function exibirImagemSelecionada{{$goal->id}}() {
            var select = document.getElementById("trophy_svgGoal-{{$goal->id}}");
            var imagemSelecionada = document.getElementById("imagemSelecionada-{{$goal->id}}");
            var imagem = select.options[select.selectedIndex].getAttribute("data-image");

            if (imagem === null) {
                imagemSelecionada.classList.add("d-none");
            } else {
                imagemSelecionada.classList.remove("d-none");
                imagemSelecionada.src = imagem;
            }
        }
        </script>
