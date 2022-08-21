<?php

namespace Modules\Restaurant\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Traits\UploadAble;
use Modules\Restaurant\Entities\Reservation;
use Modules\Restaurant\Entities\Rfloor;
use Modules\Restaurant\Entities\Rtable;
use Modules\Restaurant\Entities\Rsetting;
use Modules\Restaurant\Entities\Bookingcancel;
use Modules\Base\Http\Controllers\BaseController;

class ReservationsController extends BaseController
{
    use UploadAble;
    public function __construct(Reservation $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if(permission('reservation-access')){
            $user = Auth::User();
    
            Reservation::where('reserved_date','<', date('Y-m-d'))
                    ->delete();
            $this->setPageData('Reservation List','Reservation','fas fa-box');
            return view('restaurant::reservationindex',compact('user'));
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function cancel_list()
    {
        if(permission('reservation-cancel')){
            Bookingcancel::where('booking_status','=','cancel')->get();
           $this->setPageData('Cancel Reservation List','Cancel Reservation List','fas fa-box');
            return view('restaurant::cancelindex');
        }else{
            return $this->unauthorized_access_blocked();
        }
    }

    public function get_datatable_data(Request $request)
    {
        if(permission('reservation-access')){
            if($request->ajax()){
                if (!empty($request->name)) {
                    $this->model->setReservationFloor($request->name);
                }

                $this->set_datatable_default_property($request);
                $list = $this->model->getDatatableList();

                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    
                   
                    $no++;
                    $action = '';

                    

                    $row = [];

                    if(permission('reservation-bulk-delete')){
                        $row[] = table_checkbox($value->id);
                    }
                    $row[] = $no;
                    $row[] = $value->reserved_id;
                    $row[] = $value->reservationFloor->name;
                    $row[] = $value->reservationTable->name;
                    $row[] = $value->reservationMenu->menu_type;
                    $row[] = $value->full_name;
                    $row[] = $value->contact;
                    $row[] = $value->reserved_date;

                    
                    if($value->reserved_date >= date('Y-m-d')){
                        $valueReserved='reserved';
                        $valueCancel='cancel';
                        if(permission('reservation-delete')){
                            $row[]= BOOKING_STATUS_LABEL[$valueReserved].' <a class="delete_data badge badge-danger"  data-id="' . $value->reserved_id . '" data-name="' . $valueCancel . '"> Cancel</a>';
                        }
                    }
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

    public function get_datatable_cancel_data(Request $request)
    {
        if(permission('reservation-access')){
            if($request->ajax()){
                


                $list = Bookingcancel::all();

                $data = [];
                $no = $request->input('start');
                foreach ($list as $value) {
                    
                   
                    $no++;
                    $action = '';

                    

                    $row = [];

                    
                    $row[] = $no;
                    $row[] = $value->reserved_id;
                    $row[] = $value->reservationFloor->name;
                    $row[] = $value->reservationTable->name;
                    $row[] = $value->reservationMenu->menu_type;
                    $row[] = $value->full_name;
                    $row[] = $value->contact;
                    $row[] = $value->reserved_date;
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

    
    public function delete(Request $request)
    {
        
        if($request->ajax()){
            if(permission('reservation-delete')){
                //dd($request->id);

                Bookingcancel::where('reserved_id','=' ,$request->id)->update(['booking_status' => "cancel"]);
                
                $result = Reservation::where('reserved_id','=', $request->id)
                    ->delete();
                //$result = $reservation->delete();
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
            if(permission('reservation-bulk-delete')){
                $reservations = $this->model->toBase()->select('image')->whereIn('id',$request->ids)->get();
                $result = $this->model->destroy($request->ids);
                if($result){
                    if(!empty($reservations)){
                        foreach ($reservations as $reservation) {
                            if($reservation->image){
                                $this->delete_file($reservation->image,ITEM_IMAGE_PATH);
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
            if (permission('reservation-edit')) {
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

    public function generate_code()
    {
        return Keygen::numeric(8)->generate();
    }

    
}
