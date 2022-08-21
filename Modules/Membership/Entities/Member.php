<?php

namespace Modules\Membership\Entities;
use Modules\Base\Entities\BaseModel;

class Member extends BaseModel
{
    protected $connection = 'mysql2';
    protected $table = 'customerinfo';

    protected $teamOrder = ['customerid'=>'desc'];
    private function get_datatable_query()
    {
        if(permission('team-bulk-delete')){
            $this->column_order = [null,'customerid','firstname','lastname','email','cust_phone','status',null];
        }else{
            $this->column_order = ['customerid','firstname','lastname','email','cust_phone','status',null];
        }

        $query = self::toBase();

        /*****************
         * *Search Data **
         ******************/
        if (isset($this->orderValue) && isset($this->dirValue)) {
            $query->orderBy($this->column_order[$this->orderValue], $this->dirValue);
        } else if (isset($teamOrder)) {
            $query->orderBy(key($teamOrder), $this->order[key($teamOrder)]);
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
