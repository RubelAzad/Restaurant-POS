<?php

namespace Modules\Membership\Entities;
use Modules\Base\Entities\BaseModel;
use Modules\Membership\Entities\Facility;

class Facilitysetting extends BaseModel
{
    protected $fillable = ['facilities_id','facilities_price','facilities_status','status', 'created_by', 'updated_by'];

    public function facilityiesall()
    {
        return $this->belongsTo(Facility::class,'facilities_id','facilitytypeid');
    }
    public function getFacilties()
    {
        return $this->hasOne(Facility::class, "facilitytypeid","facilities_id");
    }


    private function get_datatable_query()
    {
        if(permission('facilitysettings-bulk-delete')){
            $this->column_order = [null,'id','facilities_id','facilities_price','facilities_status','status',null];
        }else{
            $this->column_order = ['id','facilities_id','facilities_price','facilities_status','status',null];
        }

        $query = self::with('facilityiesall');

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
