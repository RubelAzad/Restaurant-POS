<?php

namespace Modules\Membership\Entities;
use Modules\Base\Entities\BaseModel;
use Modules\Membership\Entities\Facility;
use Modules\Membership\Entities\Member;

class Facilitydiscount extends BaseModel
{
    protected $fillable = ['facilities_member_id','facilities_discount_id','facilities_discount_price','facilities_discount_type','facilities_discount_percentage','facilities_discount_fixed','facilities_discount_offer_price','facilities_discount_start_date','facilities_discount_end_date','status', 'created_by', 'updated_by'];

    public function facilitiesName()
    {
        return $this->belongsTo(Facility::class,'facilities_discount_id','facilitytypeid');
    }
    public function memberName()
    {
        return $this->belongsTo(Member::class,'facilities_member_id','customerid');
    }

    

    


    private function get_datatable_query()
    {
        if(permission('facilitysettings-bulk-delete')){
            $this->column_order = [null,'id','facilities_member_id','facilities_discount_id','facilities_discount_price','facilities_discount_type','facilities_discount_percentage','facilities_discount_fixed','facilities_discount_offer_price','facilities_discount_start_date','facilities_discount_end_date','status',null];
        }else{
            $this->column_order = ['id','facilities_member_id','facilities_discount_id','facilities_discount_price','facilities_discount_type','facilities_discount_percentage','facilities_discount_fixed','facilities_discount_offer_price','facilities_discount_start_date','facilities_discount_end_date','status',null];
        }

        $query = self::with('facilitiesName');

        /*****************
         * *Search Data **
         ******************/
        

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
