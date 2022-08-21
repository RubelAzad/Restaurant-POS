<?php

namespace Modules\Maintenance\Entities;
use Modules\Base\Entities\BaseModel;

class Team extends BaseModel
{
    protected $connection = 'mysql2';
    protected $table = 'employee_history';

    protected $teamOrder = ['emp_his_id'=>'desc'];
    private function get_datatable_query()
    {
        if(permission('team-bulk-delete')){
            $this->column_order = [null,'emp_his_id','first_name','middle_name','last_name','email','phone','alter_phone','present_address','parmanent_address','dept_id','status',null];
        }else{
            $this->column_order = ['emp_his_id','first_name','middle_name','last_name','email','phone','alter_phone','present_address','parmanent_address','dept_id','status',null];
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
