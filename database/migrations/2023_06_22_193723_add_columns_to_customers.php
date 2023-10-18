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
        Schema::table('customers', function (Blueprint $table) {
            $table->foreignId('customer_csv_import_id')->nullable()->constrained();
            $table->decimal('value', 10, 2)->nullable();
            $table->boolean('rent')->default(false);
            $table->string('rent_adjustment')->nullable(); // indice de reajuste (igpm ipca)
            $table->date('rent_adjustment_last')->nullable();
            $table->date('rent_adjustment_next')->nullable();
            $table->string('rent_guarantee')->nullable(); // tipo de garantia (fiador, seguro fiança, caução)
            $table->string('rent_guarantee_value')->nullable(); // valor da garantia (Caução)
            $table->string('product_type')->nullable(); // tipo de produto (imovel, terreno, lote, sala comercial)
            $table->timestamp('acquisition_date')->nullable(); // data de aquisição do lead, em caso de leads migrados, ou vindos do facebook, será a data que ele realmente se inscreveu
            $table->timestamp('first_contact_date')->nullable(); // data do primeiro contato
            $table->timestamp('last_contact_date')->nullable(); // data do ultimo contato
            $table->timestamp('next_contact_date')->nullable(); // data do proximo contato
            $table->string('source')->nullable(); // fonte do lead (facebook, instagram, google, site, chat, whatsapp, indicação, outros)
            $table->string('source_other')->nullable(); // outra fonte do lead
            $table->string('source_campaign_id')->nullable(); // id da campanha do lead
            $table->string('source_campaign')->nullable(); // nome da campanha do lead
            $table->string('source_ads_account')->nullable(); // campanha do lead
            $table->string('source_business_account')->nullable(); // campanha do lead
            $table->string('source_ad')->nullable(); // anuncio do lead
            $table->string('source_id')->nullable(); // id de geração do lead na fonte
            $table->string('source_form')->nullable(); // id do formulário de geração do lead
            $table->string('marital_status')->nullable(); // estado civil
            $table->string('cpf')->nullable(); // cpf
            $table->string('familiar_income')->nullable(); // renda familiar
            $table->string('income')->nullable(); // renda
            $table->string('job')->nullable(); // cargo
            $table->boolean('restriction')->nullable(); // restrição no nome
            $table->string('entry')->nullable(); // entrada da compra
            $table->integer('installments')->nullable(); // numero de parcelas
            $table->decimal('installment_value', 10, 2)->nullable(); // valor da parcela
            $table->string('region')->nullable(); // região do lead
            $table->decimal('fgts', 10, 2)->nullable(); // fgts
            $table->string('best_time')->nullable(); // melhor horario para ligação (Manha tarde ou noite)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // remove all columns added in this migration
            $table->dropColumn('customer_csv_import_id');
            $table->dropColumn('value');
            $table->dropColumn('rent');
            $table->dropColumn('rent_adjustment');
            $table->dropColumn('rent_adjustment_last');
            $table->dropColumn('rent_adjustment_next');
            $table->dropColumn('rent_guarantee');
            $table->dropColumn('rent_guarantee_value');
            $table->dropColumn('product_type');
            $table->dropColumn('acquisition_date');
            $table->dropColumn('first_contact_date');
            $table->dropColumn('last_contact_date');
            $table->dropColumn('next_contact_date');
            $table->dropColumn('source');
            $table->dropColumn('source_other');
            $table->dropColumn('source_campaign_id');
            $table->dropColumn('source_campaign');
            $table->dropColumn('source_ads_account');
            $table->dropColumn('source_business_account');
            $table->dropColumn('source_ad');
            $table->dropColumn('source_id');
            $table->dropColumn('source_form');
            $table->dropColumn('marital_status');
            $table->dropColumn('cpf');
            $table->dropColumn('familiar_income');
            $table->dropColumn('income');
            $table->dropColumn('job');
            $table->dropColumn('restriction');
            $table->dropColumn('entry');
            $table->dropColumn('installments');
            $table->dropColumn('installment_value');
            $table->dropColumn('region');
            $table->dropColumn('fgts');
            $table->dropColumn('best_time');
        });
    }
};
