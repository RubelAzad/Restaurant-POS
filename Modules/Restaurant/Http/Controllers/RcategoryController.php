<?php

namespace Modules\Restaurant\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Restaurant\Entities\Rcategory;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Restaurant\Http\Requests\RcategoryFormRequest;

class RcategoryController extends BaseController
{
    public function __construct(Rcategory $model)
    {
        $this->model = $model;
    }
    
    public function index()
    {
        if(permission('rcategory-access')){
            $this->setPageData('Category','Category','fas fa-th-list');
            $data = [
                'rcategories' => Rcategory::all(),
                'allpnames' => Rcategory::where('p_id', 1)->get(),
            ];
            return view('restaurant::index',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
        
    }

    public function get_datatable_data(Request $request)
    {
        if(permission('rcategory-access')){
            if($request->ajax()){
                if (!empty($request->name)) {
                    $this->model->setName($request->name);
                }

                $this->set_datatable_default_property($request);
                $list = $this->model->getDatatableList();


                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
                    $action = '';

                    if(permission('rcategory-edit')){
                        $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '"><i class="fas fa-edit text-primary"></i> Edit</a>';
                    }
                    if(permission('rcategory-delete')){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->name . '"><i class="fas fa-trash text-danger"></i> Delete</a>';
                    }


                    $row = [];

                    if(permission('rcategory-bulk-delete')){
                        $row[] = table_checkbox($value->id);
                    }
                    $row[] = $no;
                    $row[] = $value->name;
                    $row[] = $value->p_name;
                    $row[] = permission('rcategory-edit') ? change_status($value->id,$value->status,$value->name) : STATUS_LABEL[$value->status];;
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

    public function store_or_update_data(RcategoryFormRequest $request)
    {
        if($request->ajax()){
            if(permission('rcategory-add') || permission('rcategory-edit')){
                
                $collection = collect($request->validated());
                
                $p_name = $request->p_name ? $request->p_name : null;
                if($p_name){
                    $p_id = 1;
                }else{
                    $p_id = 0;
                }
                //$p_id = $request->p_id ? $request->p_id : 0;
                $collection = $this->track_data($request->update_id,$collection);
                $collection = $collection->merge(compact('p_name','p_id'));
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
            if(permission('rcategory-edit')){
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
            if(permission('rcategory-delete')){
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
            if(permission('rcategory-bulk-delete')){
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
            if (permission('rcategory-edit')) {
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
