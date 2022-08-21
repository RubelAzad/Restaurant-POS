<?php

namespace Modules\Membership\Entities;
use Modules\Base\Entities\BaseModel;
use Modules\Membership\Entities\Facility;
use Modules\Membership\Entities\Member;
use Modules\Membership\Entities\Cardtype;

class Card extends BaseModel
{
    protected $table = 'cards';

    protected $fillable = ['id','name','card_type','card_id','card_member_id','card_facilities_id','card_min_value','card_trash_hold','room_access','image','status','created_by','updated_by'];

    public function facilities()
    {
        return $this->belongsTo(Facility::class,'card_facilities_id','facilitytypeid');
    }
    public function allmembers()
    {
        return $this->belongsTo(Member::class,'card_member_id','customerid');
    }
    public function cardtype()
    {
        return $this->belongsTo(Cardtype::class,'card_type','id');
    }
    
    protected $name;

    public function setName($name)
    {
        $this->name = $name;
    }

    private function get_datatable_query()
    {
        if(permission('card-bulk-delete')){
            $this->column_order = [null,'id','name','card_type','card_id','card_member_id','card_facilities_id','card_min_value','card_trash_hold','room_access','image','status',null];
        }else{
            $this->column_order = ['id','name','card_type','card_id','card_member_id','card_facilities_id','card_min_value','card_trash_hold','room_access','image','status',null];
        }

 
        $query = self::with('facilities','allmembers','cardtype');

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
