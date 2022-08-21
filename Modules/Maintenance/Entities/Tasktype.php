<?php
namespace Modules\Maintenance\Entities;
use Modules\Base\Entities\BaseModel;

class Tasktype extends BaseModel
{
    protected $table = 'tasktypes';

    protected $fillable = ['type_name','status','created_by','updated_by'];
    
    protected $type_name;

  

    public function setName($type_name)
    {
        $this->type_name = $type_name;
    }

    private function get_datatable_query()
    {
        if(permission('tasktype-bulk-delete')){
            $this->column_order = [null,'id','type_name','status',null];
        }else{
            $this->column_order = ['id','type_name','status',null];
        }

        $query = self::toBase();

        /*****************
         * *Search Data **
         ******************/
        if (!empty($this->type_name)) {
            $query->where('type_name', 'like', '%' . $this->type_name . '%');
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
