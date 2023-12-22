<?php
setlocale(LC_TIME, 'pt_BR.utf8');
$tenancy   = \App\Models\Tenancy::find($extension['tenancy_id']);
$goals     = \App\Models\Extensions\Thermometer::where('tenancy_id', $extension['tenancy_id'])->orderBy('goal', 'desc')->get();
$count_sell = \App\Models\Customer::where('tenancy_id', $extension['tenancy_id'])
                    ->where('user_id', Auth::user()->id)
                    ->where([['buy_date', '>',  date('Y-m-01 00:00:00')]])
                    ->count();
$awards = \App\Models\Extensions\ThermometerAwards::where('tenancy_id', $extension['tenancy_id'])
                    ->where('user_id', Auth::user()->id)
                    ->limit(6)
                    ->orderBy('id', 'desc')
                    ->get();

$max_goal = 0;
$percentage = 0;
$goal_percentage = [];

foreach ($goals as $goal) {
    if($goal->goal > $max_goal){
        $max_goal = $goal->goal;
    }
}

foreach ($goals as $goal) {
    if($goal->goal == 0 || $max_goal == 0){
        $goal_percentage[$goal->id] = 0;
        continue;
    }
    $goal_percentage[$goal->id] = number_format((float)(($goal->goal * 100) / $max_goal), 2, '.', '');
}

if($count_sell > $max_goal){
    $percentage = 100;
}else{
    $percentage = $count_sell != 0 ? ($count_sell * 100) / $max_goal : 0;
}

//format percentage to 2 decimal places
$percentage = number_format((float)$percentage, 2, '.', '');
?>
<div class="col-md-8">
    <!-- A boostrap card to call tenancies route -->
    <div class="card" style="width: 100%;">
        <div class="card-body">
            <div class="buttons" style="position: absolute; top: 15px; right: 15px">
                <button class="btn btn-dark" data-toggle="modal" data-target="#modal-thermometer-rules-{{$tenancy->id}}"> Regras </button>
                <button class="btn btn-info" data-toggle="modal" data-target="#modal-thermometer-awards-{{$tenancy->id}}"> Ver Prêmios </button>
            </div>
            <h5 class="card-title float-none pb-2"> <i class="fas fa-thermometer-quarter"></i> Termometro de vendas {{ $tenancy->name }} </h5>
            <h6 class="card-subtitle mb-2 text-muted"></h6>
            <p class="card-text mb-2">Ganhe prêmios batendo metas de vendas.</p>


            <br>
            <div class="row list-goals">
                <div class="col-md-12" style="display: flex;   align-items: center;justify-content: center;text-align: center;">
                    <div id="wrapperTermometer{{$extension['tenancy_id']}}">
                        <div id="termometer{{$extension['tenancy_id']}}">
                            <div id="temperature{{$extension['tenancy_id']}}" style="height: {{$percentage}}%;" data-value="{{$count_sell}} Venda{{$count_sell == 1 ? NULL:'s'}}"></div>

                            @foreach($goals as $goal)
                                <div class="goal" style="height: {{$goal_percentage[$goal->id]}}%;" data-value="{{$goal->title}}"></div>
                            @endforeach

                            <div id="graduations{{$extension['tenancy_id']}}"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3 text-center" style='border-top: 1px solid #ccc'>
                <div class="col-md-12 pt-2">
                    <h3>Últimas conquistas</h3>
                    @if(count($awards) >= 1)
                        <div class="row">
                            @foreach($awards as $award)
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header" style="font-size: 12px">
                                            {{strftime('%B', strtotime('-1 month',strtotime($award->created_at)))}}
                                        </div>
                                        <div class="card-body">
                                            @if($award->trophy_svg)
                                                <img src="{{asset(\App\Models\Extensions\Thermometer::getImagePath($award->trophy_svg))}}" style="width: 100px;">
                                            @endif
                                            <p style="font-size: 12px;">
                                                <span style="font-size: 13px; font-weight:bold"> {{$award->title}}</span>
                                                <br>
                                                {{intval($award->goal)}} Venda{{$award->goal == 1 ? null: 's'}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="font-size: 12px">Nenhuma consquista por enquanto</p>
                    @endif
                </div>
            </div>



        </div>
    </div>
</div>



<div class="modal fade" id="modal-thermometer-rules-{{$tenancy->id}}" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Regras da campanha</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            <?php echo \App\Models\ExtensionConfig::getValue('thermometer', 'rules', $tenancy->id); ?>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">fechar</button>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="modal-thermometer-awards-{{$tenancy->id}}" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Metas</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">

                @foreach($goals as $goal)
                    <div class="goal-details">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img src="{{asset(\App\Models\Extensions\Thermometer::getImagePath($goal->trophy_svg))}}" style="width: 100%; max-width:80px; display: inline">
                            </div>
                            <div class="col-md-8 text-left">
                                <h5><b>{{$goal->title}}</b></h5>
                                <p>Meta: {{intval($goal->goal)}} Venda{{$goal->goal == 1 ? null: 's'}}</p>
                                <p>Recompensa: {{$goal->set_limit_lead? $goal->set_limit_lead." Leads por dia " : NULL}}  {{$goal->set_limit_lead && ($goal->award_value > 1 ) ? ' e ' : null}} {{ $goal->award_value > 1 ? "R$" . number_format($goal->award_value, 2, ',', '.') : null }} {{ !$goal->set_limit_lead && !($goal->award_value > 1)? 'Surpresa' : null; }} </p>

                            </div>
                        </div>


                    </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">fechar</button>
            </div>
        </div>

    </div>
</div>


<style>
#wrapperTermometer{{$extension['tenancy_id']}}{
    margin: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    font-size: 12px;
}

#termometer{{$extension['tenancy_id']}}{
    width: 25px;
    background: #38383f;
    height: 170px;
    position: relative;
    border: 6px solid #2a2a2e;
    border-radius: 20px;
    z-index: 1;
    margin-bottom: 50px;
}
#termometer{{$extension['tenancy_id']}}:before {
    width: 100%;
    height: 34px;
    bottom: 9px;
    background: #38383f;
    z-index: -1;
}
#termometer{{$extension['tenancy_id']}}:after {
    transform: translateX(-50%);
    width: 50px;
    height: 50px;
    background-color: #3dcadf;
    bottom: -41px;
    border: 6px solid #2a2a2e;
    z-index: -3;
    left: 50%;
}
#termometer{{$extension['tenancy_id']}}:before,
#termometer{{$extension['tenancy_id']}}:after {
    position: absolute;
    content: "";
    border-radius: 50%;
}

#temperature{{$extension['tenancy_id']}}{
    bottom: 0;
    background: linear-gradient(#f17a65, #3dcadf) no-repeat bottom;
    width: 100%;
    border-radius: 20px;
    background-size: 100% 240px;
    transition: all 0.2s ease-in-out;
}
#temperature{{$extension['tenancy_id']}}:before {
    content: attr(data-value);
    background: rgba(0, 0, 0, 0.7);
    color: white;
    z-index: 2;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 1em;
    line-height: 1;
    transform: translateY(50%);
    left: calc(100% + 1em / 1.5);
    top: calc(-1em + 5px - 5px * 2);
    min-width: 85px;
}
#temperature{{$extension['tenancy_id']}}:after {
    content: "";
    border-top: 0.4545454545em solid transparent;
    border-bottom: 0.4545454545em solid transparent;
    border-right: 0.6666666667em solid rgba(0, 0, 0, 0.7);
    left: 100%;
    top: calc(-1em / 2.2 + 5px);
}
#temperature{{$extension['tenancy_id']}},
#temperature{{$extension['tenancy_id']}}:before,
#temperature{{$extension['tenancy_id']}}:after {
    position: absolute;
}

#graduations{{$extension['tenancy_id']}}{
    height: 59%;
    top: 20%;
    width: 50%;
}





.goal{
    bottom: 0;
    width: 100%;
    border-radius: 20px;
    background-size: 100% 240px;
    transition: all 0.2s ease-in-out;
}
.goal:before {
    content: attr(data-value);
    background: rgba(0, 0, 0, 0.7);
    color: white;
    z-index: 2;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 1em;
    line-height: 1;
    transform: translateY(50%);
    right: calc(100% + 1em / 1.5);
    top: calc(-1em + 5px - 5px * 2);
}
.goal:after {
    content: "";
    border-top: 0.4545454545em solid transparent;
    border-bottom: 0.4545454545em solid transparent;
    border-left: 0.6666666667em solid rgba(0, 0, 0, 0.7);
    right: 100%;
    top: calc(-1em / 2.2 + 5px);
}
.goal,
.goal:before,
.goal:after {
    position: absolute;
    text-align: right;
}


.goal-details{
    margin-bottom: 10px;
    padding-bottom: 10px;
    border-bottom: 1px solid #ccc;
}

.show-goals{
    font-size: 12px;
    background: #efefef;
    /* color: #fff; */
    padding-top: 10px;
    padding-bottom: 10px;
    border-radius: 10px;
    /* border: 1px solid #aaa;*/
}
</style>
