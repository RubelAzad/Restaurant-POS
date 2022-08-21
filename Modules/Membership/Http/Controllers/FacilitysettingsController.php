<?php

namespace Modules\Membership\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\UploadAble;
use Modules\Membership\Entities\Facility;
use Modules\Membership\Entities\Facilitysetting;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Membership\Http\Requests\FacilitySettingsFormRequest;

class FacilitysettingsController extends BaseController
{
    use UploadAble;
    public function __construct(Facilitysetting $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (permission('facilitysettings-access')) {
            $this->setPageData('Facility Settings', 'Facility Settings', 'fas fa-box');
            $data = [
                'facilities' => Facility::all(),
            ];
            return view('membership::facilitiesindex', $data);
        } else {
            return $this->unauthorized_access_blocked();
        }
    }




    public function get_datatable_data(Request $request)
    {
        if (permission('facilitysettings-access')) {
            if ($request->ajax()) {
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

                    if (permission('facilitysettings-edit')) {
                        $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '"><i class="fas fa-edit text-primary"></i> Edit</a>';
                    }
                    if (permission('facilitysettings-view')) {
                        $action .= ' <a class="dropdown-item view_data" data-id="' . $value->id . '"><i class="fas fa-eye text-success"></i> View</a>';
                    }
                    if (permission('facilitysettings-delete')) {
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->name . '"><i class="fas fa-trash text-danger"></i> Delete</a>';
                    }

                    $row = [];

                    if (permission('facilitysettings-bulk-delete')) {
                        $row[] = table_checkbox($value->id);
                    }
                    $row[] = $no;
                    $row[] = $value->facilityiesall->facilitytypetitle;
                    $row[] = $value->facilities_price;
                    $row[] = $value->facilities_status;
                    $row[] = permission('facilitysettings-edit') ? change_status($value->id, $value->status) : STATUS_LABEL[$value->status];
                    $row[] = action_button($action);
                    $data[] = $row;
                }
                return $this->datatable_draw(
                    $request->input('draw'),
                    $this->model->count_all(),
                    $this->model->count_filtered(),
                    $data
                );
            } else {
                $output = $this->access_blocked();
            }

            return response()->json($output);
        }
    }


    public function store_or_update_data(FacilitySettingsFormRequest $request)
    {
        if ($request->ajax()) {
            if (permission('facilitysettings-add') || permission('facilitysettings-edit')) {
                $collection = collect($request->validated());
                $collection = $this->track_data($request->update_id, $collection);
                $result = $this->model->updateOrCreate(['id' => $request->update_id], $collection->all());
                $output = $this->store_message($result, $request->update_id);
            } else {
                $output = $this->access_blocked();
            }
            return response()->json($output);
        } else {
            return response()->json($this->access_blocked());
        }
    }
    public function edit(Request $request)
    {
        if ($request->ajax()) {
            if (permission('facilitysettings-edit')) {
                $data = $this->model->findOrFail($request->id);
                $output = $this->data_message($data);
            } else {
                $output = $this->access_blocked();
            }
            return response()->json($output);
        } else {
            return response()->json($this->access_blocked());
        }
    }

    public function delete(Request $request)
    {
        if ($request->ajax()) {
            if (permission('facilitysettings-delete')) {
                $facilitysettings = $this->model->find($request->id);
                $result = $facilitysettings->delete();
                $output = $this->delete_message($result);
            } else {
                $output = $this->access_blocked();
            }
            return response()->json($output);
        } else {
            return response()->json($this->access_blocked());
        }
    }

    public function bulk_delete(Request $request)
    {
        if ($request->ajax()) {
            if (permission('facilitysettings-bulk-delete')) {
                $result = $this->model->destroy($request->ids);
                $output = $this->bulk_delete_message($result);
            } else {
                $output = $this->access_blocked();
            }
            return response()->json($output);
        } else {
            return response()->json($this->access_blocked());
        }
    }

    public function change_status(Request $request)
    {
        if ($request->ajax()) {
            if (permission('facilitysettings-edit')) {
                $result = $this->model->find($request->id)->update(['status' => $request->status]);
                $output = $result ? ['status' => 'success', 'message' => 'Status has been changed successfully']
                    : ['status' => 'error', 'message' => 'Failed to change status'];
            } else {
                $output = $this->access_blocked();
            }
            return response()->json($output);
        } else {
            return response()->json($this->access_blocked());
        }
    }
}
