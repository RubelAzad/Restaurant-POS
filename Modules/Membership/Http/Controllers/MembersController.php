<?php

namespace Modules\Membership\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Membership\Entities\Member;
use Modules\Base\Http\Controllers\BaseController;

class MembersController extends BaseController
{
    public function __construct(Member $model)
    {
        $this->model = $model;
    }
    
    public function index()
    {
        if(permission('team-access')){
            $this->setPageData('Team','Team','fas fa-th-list');
            $members = Member::all();
            return view('membership::memberindex')->with(compact('members'));
        }else{
            return $this->unauthorized_access_blocked();
        }
        
    }
}
