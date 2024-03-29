<?php

namespace Modules\Restaurant\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Traits\UploadAble;
use Modules\Restaurant\Entities\Rcategory;
use Modules\Restaurant\Entities\Ritem;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Restaurant\Http\Requests\RitemFormRequest;


class RitemsController extends BaseController
{
    use UploadAble;
    public function __construct(Ritem $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('ritem-access')){
            $this->setPageData('Item','Item','fas fa-box');
            $data = [
                'rcategories' => Rcategory::all(),
                'allpnames' => Rcategory::where('p_id', 1)->get(),
            ];
            return view('restaurant::itemindex',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if(permission('ritem-access')){
            if($request->ajax()){
                if (!empty($request->name)) {
                    $this->model->setName($request->name);
                }
                if (!empty($request->rcat_id)) {
                    $this->model->setRcatID($request->rcat_id);
                }
                if (!empty($request->special)) {
                    $this->model->setSpecial($request->special);
                }
                if (!empty($request->offer)) {
                    $this->model->setOffer($request->offer);
                }

                $this->set_datatable_default_property($request);
                $list = $this->model->getDatatableList();

                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    
                   
                    $no++;
                    $action = '';

                    if(permission('ritem-edit')){
                        $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '"><i class="fas fa-edit text-primary"></i> Edit</a>';
                    }
                    if(permission('ritem-view')){
                        $action .= ' <a class="dropdown-item view_data" data-id="' . $value->id . '"><i class="fas fa-eye text-success"></i> View</a>';
                    }
                    if(permission('ritem-delete')){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->name . '"><i class="fas fa-trash text-danger"></i> Delete</a>';
                    }

                    $row = [];

                    if(permission('ritem-bulk-delete')){
                        $row[] = table_checkbox($value->id);
                    }
                    $row[] = $no;
                    $row[] = table_image($value->image,ITEM_IMAGE_PATH,$value->name);
                    $row[] = $value->name;
                    $row[] = $value->rcategory->name;
                    $row[] = number_format($value->price,2);
                    $row[] = number_format($value->qty,2);
                    $row[] = $value->alert_qty ? number_format($value->alert_qty,2) : 0;
                    $row[] = $value->offer;
                    $row[] = $value->special;
                    $row[] = $value->op_rate;
                    $row[] = permission('ritem-edit') ? change_status($value->id,$value->status,$value->name) : STATUS_LABEL[$value->status];;
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

    public function store_or_update_data(RitemFormRequest $request)
    {
        if($request->ajax()){
            if(permission('ritem-add') || permission('ritem-edit')){
                $collection = collect($request->validated())->except(['image','qty','alert_qty']);
                $qty = $request->qty ? $request->qty : null;
                $alert_qty = $request->alert_qty ? $request->alert_qty : null;
                $special = $request->special;
                $ri_menu = implode(',', $request->ri_menu);
                $collection = $this->track_data($request->update_id,$collection);
                $image = $request->old_image;
                if($request->hasFile('image')){
                    $image = $this->upload_file($request->file('image'),ITEM_IMAGE_PATH);

                    if(!empty($request->old_image)){
                        $this->delete_file($request->old_image,ITEM_IMAGE_PATH);
                    }
                }
                $collection = $collection->merge(compact('image','qty','alert_qty','ri_menu','special'));
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
            if(permission('ritem-edit')){
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
            if(permission('ritem-delete')){
                $ritem = $this->model->find($request->id);
                $image = $ritem->image;
                $result = $ritem->delete();
                if($result){
                    if(!empty($image)){
                        $this->delete_file($image,ITEM_IMAGE_PATH);
                    }
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
            if(permission('ritem-bulk-delete')){
                $ritems = $this->model->toBase()->select('image')->whereIn('id',$request->ids)->get();
                $result = $this->model->destroy($request->ids);
                if($result){
                    if(!empty($ritems)){
                        foreach ($ritems as $ritem) {
                            if($ritem->image){
                                $this->delete_file($ritem->image,ITEM_IMAGE_PATH);
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
            if (permission('ritem-edit')) {
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
