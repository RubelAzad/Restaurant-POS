<?php

namespace Modules\Membership\Http\Controllers;

namespace Modules\Membership\Http\Controllers;
use Modules\Membership\Entities\Member;

use Modules\Membership\Entities\Membercard;
use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Membership\Entities\Card;
use Modules\Membership\Http\Requests\MembercardFormRequest;

class MembercardsController extends BaseController
{
    
    public function __construct(Membercard $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('membercard-access')){
            $this->setPageData('Member Card Assign List','Member Card Assign List','fas fa-credit-card');
            $data = [
                'members' => Member::all(),
                'cards' => Card::where('status',1)->get(),
            ];
            return view('membership::membercardindex',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if(permission('membercard-access')){
            if($request->ajax()){
                if (!empty($request->fooditem_id)) {
                    $this->model->setFoodID($request->fooditem_id);
                }
                if (!empty($request->addon_id)) {
                    $this->model->setaddonID($request->addon_id);
                }

                $this->set_datatable_default_property($request);
                $list = $this->model->getDatatableList();
    
                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
                    $action = '';
                    
                    if(permission('membercard-edit')){
                        $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '"><i class="fas fa-edit text-primary"></i> Edit</a>';
                    }
                    if(permission('membercard-delete')){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name=""><i class="fas fa-trash text-danger"></i> Delete</a>';
                    }
                    
    
                    $row = [];
                    
                    if(permission('membercard-bulk-delete')){
                        $row[] = table_checkbox($value->id);
                    }
                    $row[] = $no;
                    $row[] = $value->card_number;
                    $row[] = $value->customer_id;
                    $row[] = $value->card->name;
                    $row[] = permission('membercard-edit') ? change_status($value->id,$value->status) : STATUS_LABEL[$value->status];;
                    $row[] = action_button($action);
                    $data[] = $row;
                }
                return $this->datatable_draw($request->input('draw'),$this->model->count_all(),
                 $this->model->count_filtered(), $data);
            }else{
                $output = $this->access_blocked();
            }

            return response()->json($output);
        }
    }

    public function store_or_update_data(MembercardFormRequest $request)
    {
        if($request->ajax()){
            if(permission('membercard-add') || permission('membercard-edit')){
                $collection = collect($request->validated())->except(['card_number']);
                $card_number = 'INS'.now()->year.''.now()->month.''.random_int(10000000, 99999999);
                $collection = $collection->merge(compact('card_number'));
                $collection = $this->track_data($request->update_id,$collection);
                $result = $this->model->updateOrCreate(['id'=>$request->update_id],$collection->all());
                $output = $this->store_message($result,$request->update_id);
                
                
            }else{
                $output = $this->access_blocked();
            }
            return response()->json($output);
        }else{
           return response()->json($this->access_blocked());
        }
    }

    public function edit(Request $request)
    {
        if($request->ajax()){
            if(permission('membercard-edit')){
                $data = $this->model->findOrFail($request->id);
                $output = $this->data_message($data);
            }else{
                $output = $this->access_blocked();
            }
            return response()->json($output);
        }else{
            return response()->json($this->access_blocked());
        }
    }

    public function delete(Request $request)
    {
        if($request->ajax()){
            if(permission('membercard-delete')){
                $result = $this->model->find($request->id)->delete();
                $output = $this->delete_message($result);
            }else{
                $output = $this->access_blocked();
            }
            return response()->json($output);
        }else{
            return response()->json($this->access_blocked());
        }
    }

    public function bulk_delete(Request $request)
    {
        if($request->ajax()){
            if(permission('membercard-bulk-delete')){
                $result = $this->model->destroy($request->ids);
                $output = $this->bulk_delete_message($result);
            }else{
                $output = $this->access_blocked();
            }
            return response()->json($output);
        }else{
            return response()->json($this->access_blocked());
        }
    }

    public function change_status(Request $request)
    {
        if($request->ajax()){
            if (permission('membercard-edit')) {
                $result = $this->model->find($request->id)->update(['status'=>$request->status]);
                $output = $result ? ['status'=>'success','message'=>'Status has been changed successfully']
                : ['status'=>'error','message'=>'Failed to change status'];
            }else{
                $output = $this->access_blocked();
            }
            return response()->json($output);
        }else{
            return response()->json($this->access_blocked());
        }
    }
}
