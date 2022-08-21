<?php

namespace Modules\Restaurant\Entities;
use Modules\Restaurant\Entities\Ritem;
use Modules\Base\Entities\BaseModel;

class Rdiscount extends BaseModel
{
    protected $table = 'ritemdiscounts';
    //use HasFactory;
    protected $fillable = ['food_id','df_date','dt_date','df_time','dt_time','price','status','created_by','updated_by'];


    public function rname()
     {
         return $this->belongsTo(Ritem::class,'food_id','id');
     }

    protected $food_id;

    public function setName($food_id)
    {
        $this->food_id = $food_id;
    }
    


    private function get_datatable_query()
    {
        if(permission('rtable-bulk-delete')){
            $this->column_order = [null,'id','food_id','df_date','dt_date','df_time','dt_time','price','status',null];
        }else{
            $this->column_order = ['id','food_id','df_date','dt_date','df_time','dt_time','price','status',null];
        }

        $query = self::with('rname');
        

        /*****************
         * *Search Data **
         ******************/
        if (!empty($this->food_id)) {
            $query->where('food_id', 'like', '%' . $this->food_id . '%');
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
