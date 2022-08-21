<?php

namespace Modules\Roomservice\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Traits\UploadAble;
use Mockery\Undefined;
use Modules\Roomservice\Http\Requests\RoomServiceItemRequest;
use Modules\Restaurant\Entities\Ritem;
use Modules\Roomservice\Entities\Roomitem;
use Illuminate\Support\Facades\DB;

class RoomitemsController extends BaseController
{
    public function __construct(Roomitem $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (permission('roomitem-access')) {
            $this->setPageData('Room Service Item', 'Room Service Item', 'fas fa-box');
            $data = [
                'items' => DB::table('ritems')
                    ->select('ritems.name', 'ritems.id', 'ritems.price', 'roomitems.room_service_item_id')
                    ->leftJoin('roomitems', 'ritems.id', '=', 'roomitems.room_service_item_id')
                    ->whereNull('roomitems.room_service_item_id')
                    ->where('ritems.id', '!=', 'roomitems.room_service_item_id')
                    ->get()

                //Ritem::leftJoin('roomitems','roomitems.room_service_item_id')->where('roomitems.room_service_item_id','=', NULL)->get()
                /*  ->join('roomitems','ritems.id', '=', 'roomitems.room_service_item_id')
                ->select('ritems.id,ritems.name','roomitems.room_service_extra_price')
                ->get() */


            ];
            return view('roomservice::index', $data);
        } else {
            return $this->unauthorized_access_blocked();
        }
    }

    public function store_or_update_data(Request $request)
    {
        if ($request->ajax()) {
            if (permission('roomitem-add')) {
                $ids = $request->room_service_item_id;
                $prices = $request->room_service_extra_price;
                $filteredPrice = array_values(array_filter($prices, static function ($element) {
                    return $element !== NULL;
                }));


                foreach ($ids as $key => $product) {
                    $roomItem = new Roomitem();
                    if ($ids[$key] && $product > 0) {
                        $roomItem->room_service_item_id = $product;
                        $roomItem->room_service_extra_price = $filteredPrice[$key];
                        $output=$roomItem->save();
                    }
                }
            } else {
                $output = $this->access_blocked();
            }  
            return response()->json($output);
        } else {
            return response()->json($this->access_blocked());
        }



        //$count = count($request->room_service_item_id);

        /* for ($i = 0; $i < $count; $i++) {
            $prices=$request->room_service_extra_price[$i];
                if ($prices > 0) {
                    $task = new Roomitem();
                    $task->room_service_item_id = $request->room_service_item_id[$i];
                    $task->room_service_extra_price = $request->room_service_extra_price[$i];
                    $task->save();
                }else{
                    $task1 = new Roomitem();
                    $task1->room_service_item_id = $request->room_service_item_id[$i];
                    $task1->room_service_extra_price = "NULL";
                    $task1->save();
                }
            
        } */

        //$room_service_item_ids = $request->room_service_item_id;
        //$room_service_extra_price = $request->room_service_extra_price;

        //foreach ($room_service_item_ids as $room_service_item_id) {


        /* Roomitem::create([
                'room_service_item_id' => $room_service_item_id,
                'room_service_extra_price' => $room_service_extra_price
            ]); */
        //}
    }
}
