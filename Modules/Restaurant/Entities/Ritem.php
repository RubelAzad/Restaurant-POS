<?php

namespace Modules\Restaurant\Entities;
use Modules\Restaurant\Entities\Rcategory;
use Modules\Restaurant\Entities\Rvariant;
use Modules\Base\Entities\BaseModel;
//use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ritem extends BaseModel
{
    protected $table = 'ritems';
    //use HasFactory;
    protected $fillable = ['name', 'rcat_id','components','notes','description','image','tax','qty','alert_qty','offer','special','price','op_rate','os_date','oe_date','oc_time','ri_menu','status', 'created_by', 'updated_by'];


    public function rcategory()
    {
        return $this->belongsTo(Rcategory::class,'rcat_id','id');
    }
   


    protected $name;
    protected $_rcat_id;
    protected $_special;
    protected $_offer;

    public function setName($name)
    {
        $this->_name = $name;
    }
    
    public function setSpecial($special)
    {
        $this->_special = $special;
    }
    public function setOffer($offer)
    {
        $this->_offer = $offer;
    }

    private function get_datatable_query()
    {
        if(permission('rtable-bulk-delete')){
            $this->column_order = [null,'id','name', 'rcat_id','components','notes','description','image','tax','qty','alert_qty','offer','special','price','op_rate','os_date','oe_date','oc_time','ri_menu','status',null];
        }else{
            $this->column_order = ['id','name', 'rcat_id','components','notes','description','image','tax','qty','alert_qty','offer','special','price','op_rate','os_date','oe_date','oc_time','ri_menu','status',null];
        }

        $query = self::with('rcategory');

        /*****************
         * *Search Data **
         ******************/
        if (!empty($this->_rcat_id)) {
            $query->where('rcat_id', $this->_rcat_id);
        }
        if (!empty($this->_name)) {
            $query->where('name', 'like', '%' . $this->_name . '%');
        }
        if (!empty($this->_special)) {
            $query->where('special', 'like', '%' . $this->_special . '%');
        }
        if (!empty($this->_offer)) {
            $query->where('offer', 'like', '%' . $this->_offer . '%');
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
