<?php

namespace Modules\Maintenance\Entities;
use Modules\Base\Entities\BaseModel;

class Floor extends BaseModel
{
    protected $connection = 'mysql2';
    protected $table = 'tbl_floor';
    
}
