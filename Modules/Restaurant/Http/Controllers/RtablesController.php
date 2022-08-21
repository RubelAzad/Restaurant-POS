<?php

namespace Modules\Restaurant\Http\Controllers;
use App\Traits\UploadAble;
use Illuminate\Http\Request;
use Modules\Restaurant\Entities\Rfloor;
use Modules\Restaurant\Entities\Rtable;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Restaurant\Http\Requests\RtableFormRequest;

class RtablesController extends BaseController
{
    use UploadAble;
    public function __construct(Rtable $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('rtable-access')){
            $this->setPageData('Table','Table','fas fa-users');
            $floors = Rfloor::where('status',1)->get();
            return view('restaurant::tindex',compact('floors'));
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if(permission('rtable-access')){
            if($request->ajax()){
                if (!empty($request->floor_id)) {
                    $this->model->setfloorID($request->floor_id);
                }
                if (!empty($request->name)) {
                    $this->model->setName($request->name);
                }
                if (!empty($request->capacity)) {
                    $this->model->setCapacity($request->capacity);
                }

                $this->set_datatable_default_property($request);
                $list = $this->model->getDatatableList();
    
                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    $no++;
                    $action = '';
                    
                    if(permission('rtable-edit')){
                        $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '"><i class="fas fa-edit text-primary"></i> Edit</a>';
                    }
                    if(permission('rtable-view')){
                        $action .= ' <a class="dropdown-item view_data" data-id="' . $value->id . '"><i class="fas fa-eye text-success"></i> View</a>';
                    }
                    if(permission('rtable-delete')){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->name . '"><i class="fas fa-trash text-danger"></i> Delete</a>';
                    }
                    
    
                    $row = [];
                    
                    if(permission('rtable-bulk-delete')){
                        $row[] = table_checkbox($value->id);
                    }
                    $row[] = $no;
                    $row[] = $value->name;
                    $row[] = $value->capacity;
                    $row[] = $value->min_capacity;
                    $row[] = $this->avatar($value);
                    $row[] = $value->floor->name;
                    $row[] = permission('rtable-edit') ? change_status($value->id,$value->status,$value->name) : STATUS_LABEL[$value->status];
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

    protected function avatar($request){
        if($request->image){
            return "<img src='storage/".TABLE_IMAGE_PATH.$request->image."' style='width:50px;'/>";
        }else{
            return "<img src='images/male.svg' style='width:50px;'/>";
        }
    }

    public function store_or_update_data(RtableFormRequest $request)
    {
        if($request->ajax()){
            if(permission('rtable-add') || permission('rtable-edit')){
                $booking_status = 'available';
                $collection = collect($request->validated())->except(['image']);
                $image = $request->old_image;
                if($request->hasFile('image')){
                    $image = $this->upload_file($request->file('image'),TABLE_IMAGE_PATH);
                    
                    if(!empty($request->old_image)){
                        $this->delete_file($request->old_image,TABLE_IMAGE_PATH);
                    }
                }
                $collection = $collection->merge(compact('image','booking_status'));
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
            if(permission('rtable-edit')){
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
            if(permission('rtable-delete')){
                $rtable = $this->model->find($request->id);
                $image = $rtable->image;
                $result = $rtable->delete();
                if($result && !empty($image)){
                    $this->delete_file($image,TABLE_IMAGE_PATH);
                }
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
            if(permission('rtable-bulk-delete')){
                $rtables = $this->model->toBase()->select('image')->whereIn('id',$request->ids)->get();
                $result = $this->model->destroy($request->ids);
                if($result){
                    if(!empty($rtables)){
                        foreach ($rtables as $rtable) {
                            if($rtable->image){
                                $this->delete_file($rtable->image,TABLE_IMAGE_PATH);
                            }
                        }
                    }
                }
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
            if (permission('rtable-edit')) {
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