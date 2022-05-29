<?php

namespace Modules\Restaurant\Entities;
use Modules\Restaurant\Entities\Ritem;
use Modules\Restaurant\Entities\Raddon;
use Modules\Base\Entities\BaseModel;

class Raddonassign extends BaseModel
{
    protected $fillable = [ 'fooditem_id','addon_id','status', 'created_by', 'updated_by'];

    public function fooditem()
    {
        return $this->belongsTo(Ritem::class,'fooditem_id','id');
    }
    public function addon()
    {
        return $this->belongsTo(Raddon::class,'addon_id','id');
    }

    protected $_fooditem_id;
    protected $_addon_id;

    public function setFoodID($fooditem_id)
    {
        $this->_fooditem_id = $fooditem_id;
    }
    public function setaddonID($addon_id)
    {
        $this->_addon_id = $addon_id;
    }

    private function get_datatable_query()
    {
        if(permission('expense-bulk-delete')){
            $this->column_order = [null,'id','fooditem_id','addon_id','status',null];
        }else{
            $this->column_order = ['id','fooditem_id','addon_id','status',null];
        }

        $query = self::with('fooditem:id,name','addon:id,name');

        /*****************
         * *Search Data **
         ******************/
        if (!empty($this->_fooditem_id)) {
            $query->where('fooditem_id', $this->_fooditem_id);
        }
        if (!empty($this->_addon_id)) {
            $query->where('addon_id', $this->_addon_id);
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
