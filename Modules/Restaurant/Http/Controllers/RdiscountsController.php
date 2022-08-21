<?php

namespace Modules\Restaurant\Http\Controllers;
use Illuminate\Http\Request;
use Modules\Restaurant\Entities\Ritem;
use Modules\Restaurant\Entities\Rdiscount;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Restaurant\Http\Requests\RdiscountFormRequest;

class RdiscountsController extends BaseController
{
    public function __construct(Rdiscount $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('rdiscount-access')){
            $this->setPageData('Discount Table','Discount Table','fas fa-users');
            $items = Ritem::where('status',1)->get();
            return view('restaurant::dindex',compact('items'));
        }else{
            return $this->unauthorized_access_blocked();
        }
    }


    public function get_datatable_data(Request $request)
    {
        if(permission('rdiscount-access')){
            if($request->ajax()){
                if (!empty($request->food_id)) {
                    $this->model->setName($request->food_id);
                }

                $this->set_datatable_default_property($request);
                $list = $this->model->getDatatableList();
            



                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
                    $action = '';

                    if(permission('rdiscount-edit')){
                        $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '"><i class="fas fa-edit text-primary"></i> Edit</a>';
                    }
                    if(permission('rdiscount-delete')){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->name . '"><i class="fas fa-trash text-danger"></i> Delete</a>';
                    }


                    $row = [];

                    if(permission('rdiscount-bulk-delete')){
                        $row[] = table_checkbox($value->id);
                    }
                    $row[] = $no;
                    $row[] = $value->rname->name;
                    $row[] = $value->df_date;
                    $row[] = $value->dt_date;
                    $row[] = $value->df_time;
                    $row[] = $value->dt_time;
                    $row[] = $value->price;
                    $row[] = permission('rdiscount-edit') ? change_status($value->id,$value->status,$value->name) : STATUS_LABEL[$value->status];;
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

   
    public function store_or_update_data(RdiscountFormRequest $request)
    {
        if($request->ajax()){
            if(permission('rdiscount-add') || permission('rdiscount-edit')){
                $collection = collect($request->validated());
                $collection = $this->track_data($request->update_id,$collection);
                $list = Rdiscount::all();
                foreach($list as $data){
                    dd($data->food_id);
                    /* if($request->food_id == $data->food_id){
                        if($request->food_id == $request->df_date){
                            dd('ok');
                        }

                    }else{
                        dd('not ok');
                    } */
                }
                
                //$result = $this->model->updateOrCreate(['id'=>$request->update_id],$collection->all());
                //$output = $this->store_message($result,$request->update_id);
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
            if(permission('rdiscount-edit')){
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
            if(permission('rdiscount-delete')){
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
            if(permission('rdiscount-bulk-delete')){
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
            if (permission('rdiscount-edit')) {
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
