<?php

namespace Modules\Restaurant\Entities;

use Modules\Base\Entities\BaseModel;

class ComboPackage extends BaseModel
{
    protected $table = 'combopackages';
    //use HasFactory;
    protected $fillable = ['name','event_type','item_name','image','price','status', 'created_by', 'updated_by'];

    protected $name;

    public function setName($name)
    {
        $this->_name = $name;
    }

    private function get_datatable_query()
    {
        if(permission('rtable-bulk-delete')){
            $this->column_order = [null,'id','name','event_type','item_name','image','price','status',null];
        }else{
            $this->column_order = ['id','name','event_type','item_name','image','price','status',null];
        }

        $query = self::toBase();

        /*****************
         * *Search Data **
         ******************/
        if (!empty($this->_name)) {
            $query->where('name', 'like', '%' . $this->_name . '%');
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
