<?php

namespace Modules\Restaurant\Entities;
use Modules\Restaurant\Entities\Ritem;
use Modules\Base\Entities\BaseModel;

class Rvariant extends BaseModel
{
    protected $fillable = ['name','item_id','price','status', 'created_by', 'updated_by'];

    public function ritem()
    {
        return $this->belongsTo(Ritem::class,'item_id','id');
    }


    protected $_name;
    protected $_item_id;

    public function setName($name)
    {
        $this->_name = $name;
    }
    public function setItem($item_id)
    {
        $this->_item_id = $item_id;
    }

    private function get_datatable_query()
    {
        if(permission('rtable-bulk-delete')){
            $this->column_order = [null,'id','name','item_id','price','status',null];
        }else{
            $this->column_order = ['id','name','item_id','price','status',null];
        }

        $query = self::with('ritem:id,name');

        /*****************
         * *Search Data **
         ******************/
        if (!empty($this->_item_id)) {
            $query->where('item_id', $this->_item_id);
        }
        if (!empty($this->_name)) {
            $query->where('name', 'like', '%' . $this->_name . '%');
        }
        if (!empty($this->_capacity)) {
            $query->where('capacity', 'like', '%' . $this->_capacity . '%');
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
