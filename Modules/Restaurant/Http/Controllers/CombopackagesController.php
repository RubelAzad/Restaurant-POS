<?php
namespace Modules\Restaurant\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\UploadAble;
use Modules\Restaurant\Entities\ComboPackage;
use Modules\Restaurant\Entities\Ritem;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Restaurant\Http\Requests\FoodComboPackageFormRequest;

class CombopackagesController extends BaseController
{
    use UploadAble;
    public function __construct(ComboPackage $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('fcpackage-access')){
            $this->setPageData('Event Package','Event Package','fas fa-box');
            $data = [
                'comboPackages' => ComboPackage::where('status',1)->get(),
                'foodItems' => Ritem::where('status',1)->get(),
            ];
            return view('restaurant::combo.index',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if(permission('fcpackage-access')){
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

                    if(permission('fcpackage-edit')){
                        $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '"><i class="fas fa-edit text-primary"></i> Edit</a>';
                    }
                    if(permission('fcpackage-view')){
                        $action .= ' <a class="dropdown-item view_data" data-id="' . $value->id . '"><i class="fas fa-eye text-success"></i> View</a>';
                    }
                    if(permission('fcpackage-delete')){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->name . '"><i class="fas fa-trash text-danger"></i> Delete</a>';
                    }

                    $row = [];

                    if(permission('fcpackage-bulk-delete')){
                        $row[] = table_checkbox($value->id);
                    }
                    $row[] = $no;
                    $row[] = $value->name;
                    $row[] = $value->event_type;
                    $row[] = $value->item_name;
                    $row[] = number_format($value->price,2);
                    $row[] = table_image($value->image,ITEM_COMBO_IMAGE_PATH,$value->id);
                    $row[] = permission('fcpackage-edit') ? change_status($value->id,$value->status,$value->name) : STATUS_LABEL[$value->status];;
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

    public function store_or_update_data(FoodComboPackageFormRequest $request)
    {
        if($request->ajax()){
            if(permission('fcpackage-add') || permission('fcpackage-edit')){
                $collection = collect($request->validated())->except(['image']);
                $item_name = implode(',', $request->item_name);
                $collection = $this->track_data($request->update_id,$collection);
                $image = $request->old_image;
                if($request->hasFile('image')){
                    $image = $this->upload_file($request->file('image'),ITEM_COMBO_IMAGE_PATH);

                    if(!empty($request->old_image)){
                        $this->delete_file($request->old_image,ITEM_COMBO_IMAGE_PATH);
                    }
                }
                $collection = $collection->merge(compact('image','item_name'));
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
            if(permission('fcpackage-edit')){
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
            if(permission('fcpackage-delete')){
                $fcpackage = $this->model->find($request->id);
                $image = $fcpackage->image;
                $result = $fcpackage->delete();
                if($result){
                    if(!empty($image)){
                        $this->delete_file($image,ITEM_COMBO_IMAGE_PATH);
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
            if(permission('fcpackage-bulk-delete')){
                $fcpackages = $this->model->toBase()->select('image')->whereIn('id',$request->ids)->get();
                $result = $this->model->destroy($request->ids);
                if($result){
                    if(!empty($fcpackages)){
                        foreach ($fcpackages as $fcpackage) {
                            if($fcpackage->image){
                                $this->delete_file($fcpackage->image,ITEM_COMBO_IMAGE_PATH);
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
            if (permission('fcpackage-edit')) {
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
