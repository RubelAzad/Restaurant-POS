<?php

namespace Modules\Membership\Entities;

use Modules\Membership\Entities\Member;
use Modules\Membership\Entities\Card;
use Modules\Base\Entities\BaseModel;

class Membercard extends BaseModel
{
    protected $fillable = ['card_number','customer_id','card_id','status', 'created_by', 'updated_by'];

    public function member()
    {
        return $this->belongsTo(Member::class,'customer_id','customerid');
    }
    public function card()
    {
        return $this->belongsTo(Card::class,'card_id','id');
    }


    private function get_datatable_query()
    {
        if(permission('expense-bulk-delete')){
            $this->column_order = [null,'id','card_number','customer_id','card_id','status',null];
        }else{
            $this->column_order = ['id','card_number','customer_id','card_id','status',null];
        }

        $query = self::with('member:customerid','card:id,name');

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
