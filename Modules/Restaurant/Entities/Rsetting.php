<?php
namespace Modules\Restaurant\Entities;
use Modules\Restaurant\Entities\Reservation;
use Modules\Base\Entities\BaseModel;

class Rsetting extends BaseModel
{
    protected $fillable = ['menu_type','sc_time','ec_time','status','created_by','updated_by'];

    public function reservationLInk()
     {
         return $this->belongsTo(Reservation::class,'mil_id','id');
     }
    
    protected $menu_type;

    public function setName($menu_type)
    {
        $this->menu_type = $menu_type;
    }

    private function get_datatable_query()
    {
        if(permission('rfloor-bulk-delete')){
            $this->column_order = [null,'id','menu_type','sc_time','ec_time','status',null];
        }else{
            $this->column_order = ['id','menu_type','sc_time','ec_time','status',null];
        }

        $query = self::toBase();

        /*****************
         * *Search Data **
         ******************/
        if (!empty($this->menu_type)) {
            $query->where('menu_type', 'like', '%' . $this->menu_type . '%');
        }

        if (isset($this->orderValue) && isset($this->dirValue)) {
            $query->orderBy($this->column_order[$this->orderValue], $this->dirValue);
        } else if (isset($this->order)) {
            $query->orderBy(key($this->order), $this->order[key($this->order)]);
        }
        return $query;
    }

    public function getDatatableList()
    {
        $query = $this->get_datatable_query();
        if ($this->lengthVlaue != -1) {
            $query->offset($this->startVlaue)->limit($this->lengthVlaue);
        }
        return $query->get();
    }

    public function count_filtered()
    {
        $query = $this->get_datatable_query();
        return $query->get()->count();
    }

    public function count_all()
    {
        return self::toBase()->get()->count();
    }
}
