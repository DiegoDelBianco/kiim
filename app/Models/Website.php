<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Website extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'name',
        'slug',
        'picture',
        'api_token',
        'flow',
        'user_id',
        'team_id',
        'tenancy_id',
        'product_id',
        'template',
    ];
    public static function getData(User $user, $leadpage){

        $config = self::getTemplateConfig($leadpage);

        $return = [];

        // Loop nas configuração de opções da leadpage para coletar do DB
        foreach ($config['options'] as $key => $value) {

            // Caso a opção seja uma listagem
            if($value['list']){
                // Caso seja um lista de propriedades retorna uma lista de instancias de property
                if($value['type'] == "property"){
                    $return[$key] = Property::fromQuery('
                        SELECT properties.* FROM properties 
                            INNER JOIN config_lps ON config_lps.value = properties.id
                            WHERE 
                                config_lps.user_id = :user_id AND
                                config_lps.leadpage = :leadpage AND
                                config_lps.option = :option
                            ORDER BY config_lps.order',
                            ['user_id' => $user->id, 'leadpage' => $leadpage, 'option' => $key]);

                // Caso não seja uma lista de propriedades retorna apenas uma lista de valores
                }else{
                    // Obtem lista
                    $return[$key] = self::where([
                            ['user_id', '=', $user->id], 
                            ['leadpage', '=', $leadpage],
                            ['option', '=', $key]
                        ])->orderBy('order')->get();

                    // Organiza lista da na variavel de retorno
                    //foreach ($response as $value) {
                    //    $return[$key][] = $value->value;
                    //}
                }

            // Caso o valor de configuração não seja uma listagem
            }else{

                // Obtem o valor
                $return[$key] = self::where([
                        ['user_id', '=', $user->id], 
                        ['leadpage', '=', $leadpage],
                        ['option', '=', $key]
                    ])->orderBy('order')->first()->value;

                // Caso seja uma propriedade
                if($value['type'] == "property")
                    $return[$key] = Property::find($return[$key]);
            }
        }

        return $return;
    }

    public static function getConfigFile($leadpage){
        return self::getDir($leadpage)."/config.json";
    }

    /*
    * Retorna as configurações da lead page
    * $leadpage recebe o nome/slug da leadpage, o mesmo nome da pasta onde ela foi adicioanda
    * $get_values define se a função vai retornar os valores já configurados junto, get_values pode receber uma instancia de usuário para ser mais especifico
    * $admin define se a função vai adicionar ou remover as configurações visiveis ao admin
    * $user define se a função vai adicionar ou remover as configurações visiveis ao usuário
    */
    public static function getTemplateConfig($leadpage, $get_values = false, $admin = true, $user = true){
        $file_config = self::getConfigFile($leadpage);
        $content = file_get_contents($file_config);
        $content_array = json_decode( $content , true);

        if($get_values)
            $values = self::getData($get_values!==true?$get_values:Auth::user(),$leadpage);

        $return_options = [];
        foreach ($content_array['options'] as $key => $value) {
            if(!(($user and $value['user']) OR  ($admin and $value['admin']))) continue;

            $return_options[$key] = $value;
            $return_options[$key]['key'] = $key;

            if($get_values and $value['list'])
                $return_options[$key]['value'] = isset($values[$key]) ? $values[$key] : ($value['list']?[]:false) ;
        }

        $content_array['options'] = $return_options;

        return $content_array;
    }

    public static function getRootDir(){
        return resource_path("views/websites/templates");
    }

    public static function getDir($leadpage){
        return self::getRootDir()."/$leadpage";
    }

    public static function getObjetct($leadpage){
        $config = self::getTemplateConfig($leadpage);
        $data = [
            "slug"  =>   $leadpage,
            "name"  =>   isset($config['name'])?$config['name']:"N/A",
            "thumb" =>   isset($config['thumb'])?$config['thumb']:asset('images/leadpage.png')
            ];

        return (object) $data;
    }

    public static function exists($leadpage){
        return file_exists(self::getConfigFile($leadpage));
    }

    public static function getTemplateList(){

        $dir = scandir(self::getRootDir());
        $return = [];

        foreach ($dir as $folder) {
            if(self::exists($folder))
                $return[] = self::getObjetct($folder);
        }

        return $return;
    }




    /******         Relacionamentos do DB         ******/

    /*belongsToMany*/

    /*belongsTo*/
    public function tenancy()
    {
        return $this->belongsTo('App\Models\Tenancy');
    }
    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
    
    /*hasMany*/

}
