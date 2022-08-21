<?php

namespace Modules\Roomservice\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Modules\Base\Entities\BaseModel;
use Modules\Restaurant\Entities\Ritem;

class RoomServiceManage extends BaseModel
{
    protected $table = 'roomitems';
    protected $fillable = ['room_service_item_id','room_service_extra_price','status','created_by', 'updated_by'];
    public function items()
    {
        return $this->belongsTo(Ritem::class, 'room_service_item_id', 'id');
    }

    protected $name;

    public function setName($name)
    {
        $this->name = $name;
    }

    private function get_datatable_query()
    {
        if (permission('roommanage-bulk-delete')) {
            $this->column_order = [null, 'id', 'room_service_item_id', 'room_service_extra_price','status', null];
        } else {
            $this->column_order = ['id', 'room_service_item_id', 'room_service_extra_price', 'status', null];
        }


        $query = self::with('items');

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
