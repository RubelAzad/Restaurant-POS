<?php

namespace Modules\Roomservice\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Roomservice\Entities\RoomServiceManage;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Roomservice\Http\Requests\RoomServiceItemRequest;

class RoomServiceManagesController extends BaseController
{
    public function __construct(RoomServiceManage $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('roommanage-access')){
            $this->setPageData('Room Servie Manage','Room Servie Manage','fas fa-th-list');
            $data = [
                'roomServiceManage' => RoomServiceManage::all(),
            ];
            return view('roomservice::roommanage.index',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if(permission('roommanage-access')){
            if($request->ajax()){
                if (!empty($request->type_name)) {
                    $this->model->setName($request->type_name);
                }

                $this->set_datatable_default_property($request);
                $list = $this->model->getDatatableList();

                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
                    $action = '';

                    if(permission('roommanage-edit')){
                        $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '"><i class="fas fa-edit text-primary"></i> Edit</a>';
                    }
                    if(permission('roommanage-delete')){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->type_name . '"><i class="fas fa-trash text-danger"></i> Delete</a>';
                    }


                    $row = [];

                    if(permission('roommanage-bulk-delete')){
                        $row[] = table_checkbox($value->id);
                    }
                    $row[] = $no;
                    $row[] = $value->items->name;
                    $row[] = $value->room_service_extra_price;
                    $row[] = permission('roommanage-edit') ? change_status($value->id,$value->status,$value->name) : STATUS_LABEL[$value->status];
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

    public function store_or_update_data(RoomServiceItemRequest $request)
    {
        if($request->ajax()){
            if(permission('roommanage-add') || permission('roommanage-edit')){
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
            if(permission('roommanage-edit')){
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
            if(permission('roommanage-delete')){
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
            if(permission('roommanage-bulk-delete')){
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
            if (permission('roommanage-edit')) {
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
