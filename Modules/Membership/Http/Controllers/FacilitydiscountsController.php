<?php

namespace Modules\Membership\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\UploadAble;
use Illuminate\Support\Facades\DB;
use Modules\Membership\Entities\Facility;
use Modules\Membership\Entities\Facilitysetting;
use Modules\Membership\Entities\Facilitydiscount;
use Modules\Membership\Entities\Member;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Membership\Http\Requests\FacilityDiscountFormRequest;

class FacilitydiscountsController extends BaseController
{
    use UploadAble;
    public function __construct(Facilitydiscount $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (permission('facilitydiscount-access')) {
            $this->setPageData('Facility Settings', 'Facility Settings', 'fas fa-box');
            $data = [
                'members' => Member::all(),
                'facilities' => Facilitysetting::with('getFacilties')->where('status', 1)->get(),
                'facilityDiscounts' => Facilitydiscount::where('status', 1)->get(),

            ];
            return view('membership::facilitydiscountindex', $data);
        } else {
            return $this->unauthorized_access_blocked();
        }
    }
    public function get_datatable_data(Request $request)
    {
        if (permission('facilitydiscount-access')) {
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

                    if (permission('facilitydiscount-edit')) {
                        $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '"><i class="fas fa-edit text-primary"></i> Edit</a>';
                    }
                    if (permission('facilitydiscount-view')) {
                        $action .= ' <a class="dropdown-item view_data" data-id="' . $value->id . '"><i class="fas fa-eye text-success"></i> View</a>';
                    }
                    if (permission('facilitydiscount-delete')) {
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->name . '"><i class="fas fa-trash text-danger"></i> Delete</a>';
                    }

                    $row = [];

                    if (permission('facilitydiscount-bulk-delete')) {
                        $row[] = table_checkbox($value->id);
                    }
                    $row[] = $no;
                    $row[] = $value->memberName->firstname;
                    $row[] = $value->facilitiesName->facilitytypetitle;
                    $row[] = $value->facilities_discount_price;
                    $row[] = $value->facilities_discount_type;
                    $row[] = $value->facilities_discount_percentage;
                    $row[] = $value->facilities_discount_fixed;
                    $row[] = $value->facilities_discount_offer_price;
                    $row[] = $value->facilities_discount_start_date;
                    $row[] = $value->facilities_discount_end_date;
                    $row[] = permission('facilitydiscount-edit') ? change_status($value->id, $value->status) : STATUS_LABEL[$value->status];
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


    public function store_or_update_data(FacilityDiscountFormRequest $request)
    {
        if ($request->ajax()) {


            
            if (permission('facilitydiscount-add') || permission('facilitydiscount-edit')) {
                $collection = collect($request->validated());
                $memberId=$request->facilities_member_id;
                $facilities_discount_offer_price ="5";
                foreach($memberId as $memberName) {
                    $facilities_member_id=$memberName;
                    $collection = $collection->merge(compact('facilities_member_id','facilities_discount_offer_price'));
                    $collection = $this->track_data($request->update_id, $collection);
                    $result = $this->model->updateOrCreate(['id' => $request->update_id], $collection->all());
                    
                   
                }
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
            if (permission('facilitydiscount-edit')) {
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
            if (permission('facilitydiscount-delete')) {
                $facilitydiscount = $this->model->find($request->id);
                $result = $facilitydiscount->delete();
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
            if (permission('facilitydiscount-bulk-delete')) {
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
            if (permission('facilitydiscount-edit')) {
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
    public function facilityPrice(Request $request)
    {
        if ($request->ajax()) {
            if (permission('facilitydiscount-price')) {
                $data = Facilitysetting::where("facilities_id", $request->facilities_id)
                    ->get();
                $output = $this->data_message($data);
            } else {
                $output = $this->access_blocked();
            }
            return response()->json($output);
        } else {
            return response()->json($this->access_blocked());
        }
    }
}
