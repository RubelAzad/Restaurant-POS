<?php

namespace Modules\Restaurant\Entities;
use Modules\Restaurant\Entities\Ritem;
use Modules\Base\Entities\BaseModel;
//use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rvariant extends BaseModel
{
    protected $table = 'rfvariants';
    //use HasFactory;
    protected $fillable = ['name','item_id','price','status', 'created_by', 'updated_by'];


    public function ritem()
     {
         return $this->belongsTo(Ritem::class,'item_id','id');
     }

    protected $name;

    public function setName($name)
    {
        $this->name = $name;
    }
    


    private function get_datatable_query()
    {
        if(permission('rtable-bulk-delete')){
            $this->column_order = [null,'id','name','item_id','price','status',null];
        }else{
            $this->column_order = ['id','name','item_id','price','status',null];
        }

        $query = self::with('ritem');
        

        /*****************
         * *Search Data **
         ******************/
        if (!empty($this->name)) {
            $query->where('name', 'like', '%' . $this->name . '%');
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
