<?php
namespace Modules\Restaurant\Entities;
use Modules\Restaurant\Entities\Rfloor;
use Modules\Base\Entities\BaseModel;

class Rtable extends BaseModel
{
    protected $fillable = ['name', 'capacity','image','floor_id','status', 'created_by', 'updated_by'];

    public function floor()
    {
        return $this->belongsTo(Rfloor::class);
    }


    protected $_name;
    protected $_capacity;
    protected $_floor_id;

    public function setName($name)
    {
        $this->_name = $name;
    }
    public function setCapacity($capacity)
    {
        $this->_capacity = $capacity;
    }
    public function setfloorID($floor_id)
    {
        $this->_floor_id = $floor_id;
    }

    private function get_datatable_query()
    {
        if(permission('rtable-bulk-delete')){
            $this->column_order = [null,'id','name','capacity','image','floor_id','status',null];
        }else{
            $this->column_order = ['id','name','capacity','image','floor_id','status',null];
        }

        $query = self::with('floor');

        /*****************
         * *Search Data **
         ******************/
        if (!empty($this->_floor_id)) {
            $query->where('floor_id', $this->_floor_id);
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