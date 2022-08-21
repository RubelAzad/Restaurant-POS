<?php

namespace Modules\Restaurant\Entities;
use Modules\Restaurant\Entities\reservation;
use Modules\Restaurant\Entities\Rfloor;
use Modules\Restaurant\Entities\Rsetting;
use Modules\Restaurant\Entities\Rtable;
use Modules\Base\Entities\BaseModel;

class Bookingcancel extends BaseModel
{
    protected $table = 'booking_cancels';
    
    
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
    
}
