<?php

namespace Modules\CardSettings\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Modules\CardSettings\Http\Requests\GeneralCardSettingsFormRequest;
use Modules\CardSettings\Entities\Cardsetting;

class CardSettingsController extends BaseController
{

    public function index(){
        if(permission('cardsetting-access')){
            $this->setPageData('Card','Card','fas fa-users');
            return view('cardsettings::cardsetting.index');
        }else{
            return $this->unauthorized_access_blocked();
        }
        
    }

    public function general_cardsetting(GeneralCardSettingsFormRequest $request){
        if($request->ajax())
        {
            try {
                $collection = collect($request->validated());
                foreach ($collection->all() as $key => $value) {
                    Cardsetting::set($key,$value);
                }

                $output = ['status'=>'success','message'=>'Data Has Been Saved Successfully'];
                return response()->json($output);
            } catch (\Exception $e) {
                $output = ['status'=>'error','message'=> $e->getMessage()];
                return response()->json($output);
            }
            
        }

    }


    protected function changeEnvData(array $data)
    {
        if(count($data) > 0){
            $env = file_get_contents(base_path().'/.env');
            $env = preg_split('/\s+/',$env);

            foreach ($data as $key => $value) {
                foreach ($env as $env_key => $env_value) {
                    $entry = explode("=",$env_value,2);
                    if($entry[0] == $key){
                        $env[$env_key] = $key."=".$value;
                    }else{
                        $env[$env_key] = $env_value;
                    }
                }
            }
            $env = implode("\n",$env);

            file_put_contents(base_path().'/.env',$env);
            return true;
        }else {
            return false;
        }
    }
}
