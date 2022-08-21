<?php
namespace Modules\Roomservice\Entities;
use Illuminate\Support\Facades\Config;
use Modules\Base\Entities\BaseModel;

class Roomsetting extends BaseModel
{
    protected $fillable = ['name','value','status', 'created_by', 'updated_by'];

    public static function get($name){
        $roomsetting = new self();
        $entry = $roomsetting->where('name',$name)->first();
        if(!$entry){
            return;
        }
        return $entry->value;
    }

    public static function set($name, $value=null)
    {
        self::updateOrInsert(['name'=>$name],['name'=>$name,'value'=>$value]);
        Config::set('name',$value);
        if(Config::get($name) == $value){
            return true;
        }
        return false;
    }
}
