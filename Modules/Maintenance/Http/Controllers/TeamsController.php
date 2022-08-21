<?php

namespace Modules\Maintenance\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Maintenance\Entities\Team;
use Modules\Base\Http\Controllers\BaseController;

class TeamsController extends BaseController
{
    public function __construct(Team $model)
    {
        $this->model = $model;
    }
    
    public function index()
    {
        if(permission('team-access')){
            $this->setPageData('Team','Team','fas fa-th-list');
            $teams = Team::join('department', 'employee_history.dept_id', '=', 'department.dept_id')
               ->get(['employee_history.*', 'department.department_name']);
            return view('maintenance::teamindex')->with(compact('teams'));
        }else{
            return $this->unauthorized_access_blocked();
        }
        
    }


}
