<?php

namespace Modules\Restaurant\Entities;
use Modules\Restaurant\Entities\Ritem;
use Modules\Base\Entities\BaseModel;

class Category extends BaseModel
{
    protected $table = 'rcategories';

    protected $fillable = ['name','status','created_by','updated_by'];
    
    
}
