<?php

namespace Modules\Roomservice\Entities;
use Modules\Base\Entities\BaseModel;

class Roomitem extends BaseModel
{
    protected $table = 'roomitems';
    protected $fillable = ['room_service_item_id','room_service_extra_price','status','created_by', 'updated_by'];
    
}
