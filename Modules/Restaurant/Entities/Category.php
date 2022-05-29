<?php

namespace Modules\Restaurant\Entities;
use Modules\Base\Entities\BaseModel;

class Category extends BaseModel
{

    protected $fillable = ['name','status','created_by','updated_by'];
    
    
}
