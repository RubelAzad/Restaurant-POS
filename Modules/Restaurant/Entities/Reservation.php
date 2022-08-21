<?php

namespace Modules\Restaurant\Entities;
use Modules\Restaurant\Entities\Rfloor;
use Modules\Restaurant\Entities\Rsetting;
use Modules\Restaurant\Entities\Rtable;
use Modules\Base\Entities\BaseModel;

class Reservation extends BaseModel
{
    protected $table = 'bookings';
    protected $fillable =['reserved_id','floor_id','table_id','mil_id','full_name','contact','email','address','reserved_date','reserved_time','person_adult','person_children','reserved_type','created_by'];
    
    
    public function reservationFloor()
    {
        return $this->belongsTo(Rfloor::class,'floor_id','id');
    }
    public function reservationTable()
    {
        return $this->belongsTo(Rtable::class,'table_id','id');
    }
    public function reservationMenu()
    {
        return $this->belongsTo(Rsetting::class,'mil_id','id');
    }
   
    protected $reserved_id;
    protected $floor_id;
    protected $table_id;
    protected $mil_id;
    protected $contact;
    protected $email;

    public function setReservationFloor($reserved_id)
    {
        $this->reserved_id = $reserved_id;
    }
    
    public function  setReservationTable($floor_id)
    {
        $this->floor_id = $floor_id;
    }
    public function  setReservation($table_id)
    {
        $this->table_id = $table_id;
    }
    public function  setReservationMenu($mil_id)
    {
        $this->mil_id = $mil_id;
    }
    public function  setReservationContact($contact)
    {
        $this->contact = $contact;
    }
    public function  setReservationEmail($email)
    {
        $this->email = $email;
    }

    private function get_datatable_query()
    {
        if(permission('reservation-bulk-delete')){
            $this->column_order = [null,'id','reserved_id','floor_id','table_id','mil_id','full_name','contact','email','address','reserved_date','reserved_time','person_adult','person_children','reserved_type','status',null];
        }else{
            $this->column_order = ['id','reserved_id','floor_id','table_id','mil_id','full_name','contact','email','address','reserved_date','reserved_time','person_adult','person_children','reserved_type','status',null];
        }

        $query = self::with('reservationFloor','reservationTable','reservationMenu');

        /*****************
         * *Search Data **
         ******************/
        if (!empty($this->reserved_id)) {
            $query->where('reserved_id', $this->reserved_id);
        }
        if (!empty($this->floor_id)) {
            $query->where('floor_id', 'like', '%' . $this->floor_id . '%');
        }
        if (!empty($this->table_id)) {
            $query->where('table_id', 'like', '%' . $this->table_id . '%');
        }
        if (!empty($this->mil_id)) {
            $query->where('mil_id', 'like', '%' . $this->mil_id . '%');
        }
        if (!empty($this->contact)) {
            $query->where('contact', 'like', '%' . $this->contact . '%');
        }
        if (!empty($this->email)) {
            $query->where('email', 'like', '%' . $this->email . '%');
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
