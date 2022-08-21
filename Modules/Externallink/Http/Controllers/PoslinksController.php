<?php

namespace Modules\Externallink\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Externallink\Entities\Poslink;
use Illuminate\Http\RedirectResponse;
use Modules\Base\Http\Controllers\BaseController;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PoslinksController extends BaseController
{
    public function __construct(Poslink $model)
    {
        $this->model = $model;
    }
    public function index()
    {
        $APP_REACT_POS_URL= env('APP_REACT_POS_URL');
        $login_token = auth()->user()->login_token;
        if(permission('poslink-access')){

            return new RedirectResponse($APP_REACT_POS_URL.'insignia-pos?token='.$login_token); 
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('externallink::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('externallink::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('externallink::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
