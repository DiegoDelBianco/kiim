<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reason_finishes', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->integer('order')->default(0);

            $table->boolean('avaliable_to_basic')->default(false);
            $table->boolean('avaliable_to_team_manager')->default(false);
            $table->boolean('avaliable_to_manager')->default(false);
            $table->boolean('avaliable_to_admin')->default(false);

            $table->foreignId('customer_stage_id')->nullable()->constrained('stages');
            $table->foreignId('customer_service_stage_id')->nullable()->constrained('stages');

            $table->foreignId('tenancy_id')->constrained('tenancies');

            $table->boolean('confim_buy_date')->default(false); // Se esta disponivel para atendimento
            $table->boolean('confim_signature_date')->default(false); // Se esta disponivel para atendimento
            $table->boolean('confim_delivery_keys_date')->default(false); // Se esta disponivel para atendimento
            $table->boolean('confim_next_contact_date')->default(false); // Se esta disponivel para atendimento
            $table->boolean('confim_paid_date')->default(false); // Se esta disponivel para atendimento

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->renameColumn('stage_id', 'stage_id_old');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->foreignId('stage_id')->nullable()->constrained('stages', 'id');
        });

        $tenancies = \App\Models\Tenancy::all();



        foreach($tenancies as $tenancy){

            $novo = $tenancy->stages()->create([
                'name' => 'Novo',
                'icon' => NULL,
                'color' => NULL,
                'order' => 1,
                'funnel_order' => 0,
                'is_customer_default' => true,
                'is_customer_service_default' => false,
                'is_new' => true,
                'can_init' => true,
                'is_buy_pending' => false,
                'is_buy' => false,
                'is_deleted' => false,
                'is_paid' => false,
                'is_avaliable_to_cs' => true,
                'is_delivery_keys' => false,
                'is_rearranged_default' => false,
                'is_buy_cancel_default' => false,
            ]);

            $em_atendimento = $tenancy->stages()->create([
                'name' => 'Em atendimento',
                'icon' => NULL,
                'color' => NULL,
                'order' => 2,
                'funnel_order' => 1,
                'is_customer_default' => false,
                'is_customer_service_default' => true,
                'is_new' => false,
                'is_buy_pending' => false,
                'is_buy' => false,
                'is_deleted' => false,
                'is_paid' => false,
                'is_avaliable_to_cs' => false,
                'is_delivery_keys' => false,
                'is_rearranged_default' => false,
                'is_buy_cancel_default' => false,
            ]);

            $negociando = $tenancy->stages()->create([
                'name' => 'Negociando',
                'icon' => NULL,
                'color' => NULL,
                'order' => 3,
                'funnel_order' => 2,
                'is_customer_default' => false,
                'is_customer_service_default' => false,
                'is_new' => false,
                'is_buy_pending' => false,
                'is_buy' => false,
                'is_deleted' => false,
                'is_paid' => false,
                'is_avaliable_to_cs' => false,
                'is_delivery_keys' => false,
                'is_rearranged_default' => false,
                'is_buy_cancel_default' => false,
            ]);

            $aguardando = $tenancy->stages()->create([
                'name' => 'Aguardando',
                'icon' => NULL,
                'color' => NULL,
                'order' => 3,
                'funnel_order' => 0,
                'is_customer_default' => false,
                'is_customer_service_default' => false,
                'is_new' => false,
                'is_buy_pending' => false,
                'is_waiting' => true,
                'is_buy' => false,
                'is_deleted' => false,
                'is_paid' => false,
                'is_avaliable_to_cs' => false,
                'is_delivery_keys' => false,
                'is_rearranged_default' => false,
                'is_buy_cancel_default' => false,
            ]);

            $doc = $tenancy->stages()->create([
                'name' => 'Documentação',
                'icon' => NULL,
                'color' => NULL,
                'order' => 4,
                'funnel_order' => 3,
                'is_customer_default' => false,
                'is_customer_service_default' => false,
                'is_new' => false,
                'is_buy_pending' => false,
                'is_buy' => false,
                'is_deleted' => false,
                'is_paid' => false,
                'is_avaliable_to_cs' => false,
                'is_delivery_keys' => false,
                'is_rearranged_default' => false,
                'is_buy_cancel_default' => false,
            ]);

            $vendido_aguar = $tenancy->stages()->create([
                'name' => 'Vendido (Aguardando confirmação)',
                'icon' => NULL,
                'color' => NULL,
                'order' => 5,
                'funnel_order' => 0,
                'is_customer_default' => false,
                'is_customer_service_default' => false,
                'is_new' => false,
                'is_buy_pending' => true,
                'is_buy' => false,
                'is_deleted' => false,
                'is_paid' => false,
                'is_avaliable_to_cs' => false,
                'is_delivery_keys' => false,
                'is_rearranged_default' => false,
                'is_buy_cancel_default' => false,
            ]);

            $vendido = $tenancy->stages()->create([
                'name' => 'Vendido',
                'icon' => NULL,
                'color' => NULL,
                'order' => 5,
                'funnel_order' => 4,
                'is_customer_default' => false,
                'is_customer_service_default' => false,
                'is_new' => false,
                'is_buy_pending' => false,
                'is_buy' => true,
                'is_deleted' => false,
                'is_paid' => false,
                'is_avaliable_to_cs' => false,
                'is_delivery_keys' => false,
                'is_rearranged_default' => false,
                'is_buy_cancel_default' => false,
            ]);

            $key_delivery = $tenancy->stages()->create([
                'name' => 'Entrega das chaves',
                'icon' => NULL,
                'color' => NULL,
                'order' => 6,
                'funnel_order' => 0,
                'is_customer_default' => false,
                'is_customer_service_default' => false,
                'is_new' => false,
                'is_buy_pending' => false,
                'is_buy' => true,
                'is_deleted' => false,
                'is_paid' => false,
                'is_avaliable_to_cs' => false,
                'is_delivery_keys' => true,
                'is_rearranged_default' => false,
                'is_buy_cancel_default' => false,
            ]);

            $cob = $tenancy->stages()->create([
                'name' => 'Cobrança',
                'icon' => NULL,
                'color' => NULL,
                'order' => 7,
                'funnel_order' => 0,
                'is_customer_default' => false,
                'is_customer_service_default' => false,
                'is_new' => false,
                'is_buy_pending' => true,
                'is_buy' => true,
                'is_deleted' => false,
                'is_paid' => false,
                'is_avaliable_to_cs' => false,
                'is_delivery_keys' => false,
                'is_rearranged_default' => false,
                'is_buy_cancel_default' => false,
            ]);

            $remarketing = $tenancy->stages()->create([
                'name' => 'Remarketing',
                'icon' => NULL,
                'color' => NULL,
                'order' => 8,
                'funnel_order' => 0,
                'is_customer_default' => false,
                'is_customer_service_default' => false,
                'is_new' => false,
                'is_buy_pending' => false,
                'is_buy' => false,
                'is_deleted' => false,
                'is_paid' => false,
                'can_init' => true,
                'is_avaliable_to_cs' => false,
                'is_delivery_keys' => false,
                'is_rearranged_default' => false,
                'is_buy_cancel_default' => true,
                'rel_basic_view' => false,
            ]);

            $remanejado = $tenancy->stages()->create([
                'name' => 'Remanejado',
                'icon' => NULL,
                'color' => NULL,
                'order' => 9,
                'funnel_order' => 0,
                'is_customer_default' => false,
                'is_customer_service_default' => false,
                'is_new' => false,
                'is_buy_pending' => false,
                'is_buy' => false,
                'is_deleted' => false,
                'is_paid' => false,
                'is_avaliable_to_cs' => true,
                'is_delivery_keys' => false,
                'is_rearranged_default' => true,
                'is_buy_cancel_default' => false,
            ]);

            $lixeira = $tenancy->stages()->create([
                'name' => 'Lixeira',
                'icon' => NULL,
                'color' => NULL,
                'order' => 10,
                'funnel_order' => 0,
                'is_customer_default' => false,
                'is_customer_service_default' => false,
                'is_new' => false,
                'is_buy_pending' => false,
                'is_buy' => false,
                'is_deleted' => true,
                'is_paid' => false,
                'is_avaliable_to_cs' => false,
                'is_delivery_keys' => false,
                'is_rearranged_default' => false,
                'is_buy_cancel_default' => false,
            ]);

            \App\Models\Customer::where('stage_id_old', 1)->where('tenancy_id', $tenancy->id)->update(['stage_id' => $novo->id]);

            \App\Models\Customer::where('stage_id_old', 2)->where('tenancy_id', $tenancy->id)->update(['stage_id' => $em_atendimento->id]);

            \App\Models\Customer::where('stage_id_old', 3)->where('tenancy_id', $tenancy->id)->update(['stage_id' => $negociando->id]);

            \App\Models\Customer::where('stage_id_old', 4)->where('tenancy_id', $tenancy->id)->update(['stage_id' => $remarketing->id]);

            \App\Models\Customer::where('stage_id_old', 5)->where('tenancy_id', $tenancy->id)->update(['stage_id' => $remanejado->id]);

            \App\Models\Customer::where('stage_id_old', 6)->where('tenancy_id', $tenancy->id)->update(['stage_id' => $cob->id]);

            \App\Models\Customer::where('stage_id_old', 7)->where('tenancy_id', $tenancy->id)->update(['stage_id' => $vendido_aguar->id]);

            \App\Models\Customer::where('stage_id_old', 8)->where('tenancy_id', $tenancy->id)->update(['stage_id' => $vendido->id]);

            \App\Models\Customer::where('stage_id_old', 9)->where('tenancy_id', $tenancy->id)->update(['stage_id' => $vendido->id]);

            \App\Models\Customer::where('stage_id_old', 10)->where('tenancy_id', $tenancy->id)->update(['stage_id' => $lixeira->id]);


            $tenancy->reasonFinishes()->create([
                'name' => 'Em Negociação',
                'description' => null,
                'icon' => null,
                'color' => null,
                'order' => 1,

                'avaliable_to_basic' => true,
                'avaliable_to_team_manager' => true,
                'avaliable_to_manager' => true,
                'avaliable_to_admin' => true,

                'customer_stage_id' => $negociando->id,
                'customer_service_stage_id' => $negociando->id,

                'confim_buy_date' => false,
                'confim_signature_date' => false,
                'confim_delivery_keys_date' => false,
                'confim_next_contact_date' => false,
            ]);

            $tenancy->reasonFinishes()->create([
                'name' => 'Agendado contato futuro',
                'description' => null,
                'icon' => null,
                'color' => null,
                'order' => 2,

                'avaliable_to_basic' => true,
                'avaliable_to_team_manager' => true,
                'avaliable_to_manager' => true,
                'avaliable_to_admin' => true,

                'customer_stage_id' => $aguardando->id,
                'customer_service_stage_id' => $aguardando->id,

                'confim_buy_date' => false,
                'confim_signature_date' => false,
                'confim_delivery_keys_date' => false,
                'confim_next_contact_date' => true,
            ]);

            $tenancy->reasonFinishes()->create([
                'name' => 'Preparando documentação',
                'description' => null,
                'icon' => null,
                'color' => null,
                'order' => 3,

                'avaliable_to_basic' => true,
                'avaliable_to_team_manager' => true,
                'avaliable_to_manager' => true,
                'avaliable_to_admin' => true,

                'customer_stage_id' => $doc->id,
                'customer_service_stage_id' => $doc->id,

                'confim_buy_date' => false,
                'confim_signature_date' => false,
                'confim_delivery_keys_date' => false,
                'confim_next_contact_date' => false,
            ]);



            $tenancy->reasonFinishes()->create([
                'name' => 'Vendido',
                'description' => 'Vendido para corretor (Vai para aguardando confirmação)',
                'icon' => null,
                'color' => null,
                'order' => 4,

                'avaliable_to_basic' => true,
                'avaliable_to_team_manager' => false,
                'avaliable_to_manager' => false,
                'avaliable_to_admin' => false,

                'customer_stage_id' => $vendido_aguar->id,
                'customer_service_stage_id' => $vendido_aguar->id,

                'confim_buy_date' => true,
                'confim_signature_date' => false,
                'confim_delivery_keys_date' => false,
                'confim_next_contact_date' => false,
            ]);

            $tenancy->reasonFinishes()->create([
                'name' => 'Vendido',
                'description' => 'Vendido e confirmado',
                'icon' => null,
                'color' => null,
                'order' => 5,

                'avaliable_to_basic' => false,
                'avaliable_to_team_manager' => true,
                'avaliable_to_manager' => true,
                'avaliable_to_admin' => true,

                'customer_stage_id' => $vendido->id,
                'customer_service_stage_id' => $vendido->id,

                'confim_buy_date' => true,
                'confim_signature_date' => false,
                'confim_delivery_keys_date' => false,
                'confim_next_contact_date' => false,
            ]);

            $tenancy->reasonFinishes()->create([
                'name' => 'Confirmar venda',
                'description' => null,
                'icon' => null,
                'color' => null,
                'order' => 6,

                'avaliable_to_basic' => false,
                'avaliable_to_team_manager' => true,
                'avaliable_to_manager' => true,
                'avaliable_to_admin' => true,

                'customer_stage_id' => $vendido->id,
                'customer_service_stage_id' => $vendido->id,

                'confim_buy_date' => false,
                'confim_signature_date' => false,
                'confim_delivery_keys_date' => false,
                'confim_next_contact_date' => false,
            ]);

            $tenancy->reasonFinishes()->create([
                'name' => 'Não atende',
                'description' => null,
                'icon' => null,
                'color' => null,
                'order' => 7,

                'avaliable_to_basic' => true,
                'avaliable_to_team_manager' => true,
                'avaliable_to_manager' => true,
                'avaliable_to_admin' => true,

                'customer_stage_id' => $remarketing->id,
                'customer_service_stage_id' => null,

                'confim_buy_date' => false,
                'confim_signature_date' => false,
                'confim_delivery_keys_date' => false,
                'confim_next_contact_date' => false,
            ]);

            $tenancy->reasonFinishes()->create([
                'name' => 'Dados de contato Inválido',
                'description' => null,
                'icon' => null,
                'color' => null,
                'order' => 8,

                'avaliable_to_basic' => true,
                'avaliable_to_team_manager' => true,
                'avaliable_to_manager' => true,
                'avaliable_to_admin' => true,

                'customer_stage_id' => $lixeira->id,
                'customer_service_stage_id' => null,

                'confim_buy_date' => false,
                'confim_signature_date' => false,
                'confim_delivery_keys_date' => false,
                'confim_next_contact_date' => false,
            ]);

            $tenancy->reasonFinishes()->create([
                'name' => 'Cliente solicitou remoção',
                'description' => null,
                'icon' => null,
                'color' => null,
                'order' => 9,

                'avaliable_to_basic' => true,
                'avaliable_to_team_manager' => true,
                'avaliable_to_manager' => true,
                'avaliable_to_admin' => true,

                'customer_stage_id' => $lixeira->id,
                'customer_service_stage_id' => null,

                'confim_buy_date' => false,
                'confim_signature_date' => false,
                'confim_delivery_keys_date' => false,
                'confim_next_contact_date' => false,
            ]);

            $tenancy->reasonFinishes()->create([
                'name' => 'Outros',
                'description' => null,
                'icon' => null,
                'color' => null,
                'order' => 10,

                'avaliable_to_basic' => true,
                'avaliable_to_team_manager' => true,
                'avaliable_to_manager' => true,
                'avaliable_to_admin' => true,

                'customer_stage_id' => $remarketing->id,
                'customer_service_stage_id' => null,

                'confim_buy_date' => false,
                'confim_signature_date' => false,
                'confim_delivery_keys_date' => false,
                'confim_next_contact_date' => false,
            ]);







        }
/*
        1 => "Novo",                                // Antigo 1
        2 => "Em atendimento",                      // Antigo 6
        3 => "Negociando",                          // Antigo 2
        4 => "Remarketing",                         // Antigo 9
        5 => "Remanejado",                          // Antigo 10
        6 => "Cobrança",                            // Antigo 8
        7 => "Vendido (Aguardando confirmação)",    // Antigo 3
        8 => "Vendido",                             // Antigo 4
        9 => "Vendido",                             // Antigo 5
        10 => "Lixeira",                            // Antigo 7
    ];*/

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reason_finishes');
    }
};
