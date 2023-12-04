<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class Tenancy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'subdomain',
        'name',
        'active',
        'logo',
        'max_users',
        'max_websites',
        'max_customers',
        'user_id',
        'doc',
        'email',
        'phone',
        'cep',
        'address',
        'address_number',
        'complement',
        'province',
        'city',
        'uf',
        'assas_id',
    ];

    public static function newTenancyWithUser($business_name, $name, $email, $password)
    {

        $tenancy = Tenancy::create([
            'name' => $business_name,
        ]);

        // create roles
        /*$role_master = Role::create([
            'name' => 'Master',
            'description' => 'Administrador',
            'tenancy_id' => $tenancy->id,
        ]);
        $role_gerente = Role::create([
            'name' => 'Gerente',
            'description' => 'Gerente de Equipe',
            'tenancy_id' => $tenancy->id,
        ]);
        $role_basico = Role::create([
            'name' => 'Básico',
            'description' => 'Acesso básico para atendimento',
            'tenancy_id' => $tenancy->id,
        ]);*/

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'tenancy_id' => $tenancy->id,
        ]);

        $tenancy->user_id = $user->id;
        $tenancy->save();

        // assign roles to user
        RoleUser::create([
            'user_id' => $user->id,
            'name' => 'admin',
            'tenancy_id' => $tenancy->id,
        ]);



        // stages
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
            'can_init' => true,
            'is_buy_pending' => false,
            'is_buy' => false,
            'is_deleted' => false,
            'is_paid' => false,
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



        // finish reasons



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


        event(new Registered($user));

        return $user;
    }

    /******         Relacionamentos do DB         ******/

    /*belongsToMany*/
    public function sysProducts()
    {
        return $this->belongsToMany('App\Models\SysProduct', 'sys_product_tenancies');
    }
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'role_user');
        // return $this->hasMany('App\Models\User');
    }

    /*belongsTo*/
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /*hasMany*/
    public function sysProductTenancy()
    {
        return $this->hasMany('App\Models\SysProductTenancy');
    }
    public function customers()
    {
        return $this->hasMany('App\Models\Customer');
    }
    public function customerServices()
    {
        return $this->hasMany('App\Models\CustomerService');
    }
    public function customerTimelines()
    {
        return $this->hasMany('App\Models\CustomerTimeline');
    }
    public function notifyUsers()
    {
        return $this->hasMany('App\Models\NotifyUser');
    }
    public function notifyUserViews()
    {
        return $this->hasMany('App\Models\NotifyUserView');
    }
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
    public function roles()
    {
        return $this->hasMany('App\Models\Role');
    }
    public function roleUsers()
    {
        return $this->hasMany('App\Models\RoleUser');
    }
    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule');
    }
    public function sectors()
    {
        return $this->hasMany('App\Models\Sector');
    }
    public function teams()
    {
        return $this->hasMany('App\Models\Team');
    }
    public function websites()
    {
        return $this->hasMany('App\Models\Website');
    }
    public function websiteDatas()
    {
        return $this->hasMany('App\Models\WebsiteData');
    }
    public function stages()
    {
        return $this->hasMany('App\Models\Stage');
    }
    public function reasonFinishes()
    {
        return $this->hasMany('App\Models\ReasonFinish');
    }




}
