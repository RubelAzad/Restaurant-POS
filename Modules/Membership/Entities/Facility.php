<?php

namespace Modules\Membership\Entities;
use Modules\Base\Entities\BaseModel;
use Modules\Membership\Entities\Facilitysetting;

class Facility extends BaseModel
{
    protected $connection = 'mysql2';
    protected $table = 'roomfacilitytype';

    public function facilitysetting()
    {
      return $this->belongsTo(Facilitysetting::class, 'facilities_id','facilitytypeid');
    }

    
    
   
}
