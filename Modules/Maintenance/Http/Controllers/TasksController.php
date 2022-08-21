<?php

namespace Modules\Maintenance\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Traits\UploadAble;
use Modules\Maintenance\Entities\Task;
use Modules\Maintenance\Entities\Team;
use Modules\Maintenance\Entities\Tasktype;
use Modules\Maintenance\Entities\Floor;
use Modules\Maintenance\Entities\Room;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Maintenance\Http\Requests\TaskFormRequest;

class TasksController extends BaseController
{
    use UploadAble;
    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('task-access')){
            $this->setPageData('Task','Task','fas fa-box');
            $data = [
                'tasks' => Task::all(),
                'teams' => Team::select('emp_his_id','first_name','middle_name','last_name')->get(),
                'taskTypes' => Tasktype::all(),
                'rooms' => Room::all(),
            ];
            return view('maintenance::taskindex',$data);
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if(permission('task-access')){
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

                    if(permission('task-edit')){
                        $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '"><i class="fas fa-edit text-primary"></i> Edit</a>';
                    }
                    if(permission('task-view')){
                        $action .= ' <a class="dropdown-item view_data" data-id="' . $value->id . '"><i class="fas fa-eye text-success"></i> View</a>';
                    }
                    if(permission('task-delete')){
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->name . '"><i class="fas fa-trash text-danger"></i> Delete</a>';
                    }

                    $row = [];

                    if(permission('task-bulk-delete')){
                        $row[] = table_checkbox($value->id);
                    }
                    $row[] = $no;
                    $row[] = $value->name;
                    $row[] = table_image($value->before_image,TASK_BEFORE_IMAGE_PATH,$value->name);
                    $row[] = $value->tasktype->type_name;
                    $row[] = $value->taskteam->first_name;
                    $row[] = $value->assign_dt;
                    $row[] = $value->schedule_dt;
                    $row[] = $value->assign_hours;
                    $row[] = $value->assign_by;
                    $row[] = $value->reported_by;
                    $row[] = permission('task-edit') ? change_status($value->id,$value->status,$value->name) : STATUS_LABEL[$value->status];
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

    public function store_or_update_data(TaskFormRequest $request)
    {
        if($request->ajax()){
            if(permission('task-add') || permission('task-edit')){
                $collection = collect($request->validated())->except(['before_image','after_image']);
                $collection = $this->track_data($request->update_id,$collection);
                $before_image = $request->old_before_image;
                if($request->hasFile('before_image')){
                    $before_image = $this->upload_file($request->file('before_image'),TASK_BEFORE_IMAGE_PATH);

                    if(!empty($request->old_before_image)){
                        $this->delete_file($request->old_before_image,TASK_BEFORE_IMAGE_PATH);
                    }
                }
                $after_image = $request->old_after_image;
                if($request->hasFile('after_image')){
                    $after_image = $this->upload_file($request->file('after_image'),TASK_AFTER_IMAGE_PATH);

                    if(!empty($request->old_after_image)){
                        $this->delete_file($request->old_after_image,TASK_AFTER_IMAGE_PATH);
                    }
                }
                $collection = $collection->merge(compact('before_image','after_image'));
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
            if(permission('task-edit')){
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
            if(permission('task-delete')){
                $task = $this->model->find($request->id);
                $before_image = $task->before_image;
                $result = $task->delete();
                if($result){
                    if(!empty($before_image)){
                        $this->delete_file($before_image,TASK_BEFORE_IMAGE_PATH);
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
            if(permission('task-bulk-delete')){
                $tasks = $this->model->toBase()->select('before_image')->whereIn('id',$request->ids)->get();
                $result = $this->model->destroy($request->ids);
                if($result){
                    if(!empty($tasks)){
                        foreach ($tasks as $task) {
                            if($task->before_image){
                                $this->delete_file($task->before_image,TASK_BEFORE_IMAGE_PATH);
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
            if (permission('task-edit')) {
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
