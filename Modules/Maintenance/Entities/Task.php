<?php

namespace Modules\Maintenance\Entities;
use Modules\Base\Entities\BaseModel;
use Modules\Maintenance\Entities\Tasktype;
use Modules\Maintenance\Entities\Team;

class Task extends BaseModel
{
    protected $table = 'tasks';

    protected $fillable = ['name','employee_id','type_id','task_floor','task_room','description','assign_dt','schedule_dt','assign_hours','before_image','after_image','assign_by','reported_by','completed_dt','command','completed_hours','status','created_by','updated_by'];

    public function tasktype()
    {
        return $this->belongsTo(Tasktype::class,'type_id','id');
    }
    public function taskteam()
    {
        return $this->belongsTo(Team::class,'employee_id','emp_his_id');
    }
    
    protected $name;

    public function setName($name)
    {
        $this->name = $name;
    }

    private function get_datatable_query()
    {
        if(permission('task-bulk-delete')){
            $this->column_order = [null,'id','name','employee_id','type_id','task_floor','task_room','description','assign_dt','schedule_dt','assign_hours','before_image','after_image','assign_by','reported_by','completed_dt','command','completed_hours','status',null];
        }else{
            $this->column_order = ['id','name','employee_id','type_id','task_floor','task_room','description','assign_dt','schedule_dt','assign_hours','before_image','after_image','assign_by','reported_by','completed_dt','command','completed_hours','status',null];
        }

 
        $query = self::with('tasktype','taskteam');

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
