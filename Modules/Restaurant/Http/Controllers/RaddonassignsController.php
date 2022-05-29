<?php

namespace Modules\Restaurant\Http\Controllers;
use Modules\Restaurant\Entities\Ritem;
use Modules\Restaurant\Entities\Raddon;
use Modules\Restaurant\Entities\Raddonassign;
use Illuminate\Http\Request;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Restaurant\Http\Requests\RaddonassignFormRequest;

class RaddonassignsController extends BaseController
{
    public function __construct(Raddonassign $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('raddonassign-access')){
            $this->setPageData('Add-ons Assign List','Add-ons Assign List','fas fa-credit-card');
            $data = [
                'fooditems' => Ritem::where('status',1)->get(),
                'addons' => Raddon::where('status',1)->get(),
            ];
            return view('restaurant::aassignindex',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if(permission('raddonassign-access')){
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
                    
                    if(permission('raddonassign-edit')){
                        $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '"><i class="fas fa-edit text-primary"></i> Edit</a>';
                    }
                    if(permission('raddonassign-delete')){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name=""><i class="fas fa-trash text-danger"></i> Delete</a>';
                    }
                    
    
                    $row = [];
                    
                    if(permission('raddonassign-bulk-delete')){
                        $row[] = table_checkbox($value->id);
                    }
                    $row[] = $no;
                    $row[] = $value->addon->name;
                    $row[] = $value->fooditem->name;
                    $row[] = permission('raddonassign-edit') ? change_status($value->id,$value->status,$value->name) : STATUS_LABEL[$value->status];;
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

    public function store_or_update_data(RaddonassignFormRequest $request)
    {
        if($request->ajax()){
            if(permission('raddonassign-add') || permission('raddonassign-edit')){
                $collection = collect($request->validated());
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
            if(permission('raddonassign-edit')){
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
            if(permission('raddonassign-delete')){
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
            if(permission('raddonassign-bulk-delete')){
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
            if (permission('raddonassign-edit')) {
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
