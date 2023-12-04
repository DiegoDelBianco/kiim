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

        DB::statement("CREATE OR REPLACE VIEW `view_base_customers` AS
        select
        `ct`.`id` AS `id`,
        `ct`.`tenancy_id` AS `tenancy`,
        `ct`.`team_id` AS `team_id`,
        `ct`.`user_id` AS `user_id`,
        `ct`.`stage_id` AS `stage_id`,
        `st`.`is_customer_default` AS `is_customer_default`,
        `st`.`is_customer_service_default` AS `is_customer_service_default`,
        `st`.`is_new` AS `is_new`,
        `st`.`is_buy_pending` AS `is_buy_pending`,
        `st`.`is_buy` AS `is_buy`,
        `st`.`is_deleted` AS `is_deleted`,
        `st`.`is_paid` AS `is_paid`,
        `st`.`is_avaliable_to_cs` AS `is_avaliable_to_cs`,
        `st`.`is_delivery_keys` AS `is_delivery_keys`,
        `st`.`is_waiting` AS `is_waiting`,
        `st`.`name` AS `stage_name`,
        `ct`.`created_at` AS `created_at`,
        `ct`.`n_customer_service` AS `n_customer_service`,
        `ct`.`product_id` AS `product_id`,
        `ct`.`website_id` AS `website_id`,
        `ct`.`opened` AS `opened`,
        `ct`.`name` AS `name`,
        concat(`ct`.`ddi`,`ct`.`ddd`,`ct`.`phone`,`ct`.`ddi_2`,`ct`.`ddd_2`,`ct`.`phone_2`,`ct`.`whatsapp`) as concat_phone,
        `ct`.`ddd` AS `ddd`,
        `ct`.`phone` AS `phone`,
        `ct`.`whatsapp` AS `whatsapp`,
        `ct`.`email` AS `email`,
        `ct`.`updated_at` AS `updated_at`,
        `us`.`name` AS `user_name`,
        `tm`.`name` AS `team`,
        `lp`.`name` AS `website`,
        `at`.`id` AS `customer_service_id`,
        `at`.`status` AS `customer_service_status`,
        `at`.`remarketing` AS `customer_service_remarketing`,
        `at`.`reason_finish` AS `customer_service_reason_finish` ,
        `at`.`created_at` AS `customer_service_created_at` ,
        `at`.`updated_at` AS `customer_service_updated_at` from
            `customers` `ct`
            left join `stages` `st` on(`st`.`id` = `ct`.`stage_id`)
            left join `customer_services` `at` on(`at`.`id` = `ct`.`customer_service_id`)
            left join `users` `us` on(`us`.`id` = `ct`.`user_id`)
            left join `teams` `tm` on(`tm`.`id` = `ct`.`team_id`)
            left join `websites` `lp` on(`lp`.`id` = `ct`.`website_id`)
            left join `products` `pr` on(`pr`.`id` = `ct`.`product_id`)
        order by `ct`.`id` desc");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
