<?php

namespace Modules\Membership\Http\Controllers;

use App\Traits\UploadAble;
use Illuminate\Http\Request;
use Modules\Membership\Entities\Card;
use Modules\Membership\Entities\Cardtype;
use Modules\Membership\Entities\Facility;
use Modules\Membership\Entities\Member;
use Modules\CardSettings\Entities\Cardsetting;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Membership\Http\Requests\CardFormRequest;

class CardsController extends BaseController
{
    use UploadAble;
    public function __construct(Card $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        if (permission('card-access')) {
            $this->setPageData('Card', 'Card', 'fas fa-box');
            $data = [
                'cards' => Card::orderBy('card_id', 'desc')->first(),
                'facilities' => Facility::all(),
                'members' => Member::all(),
                'cardsettings' => Cardsetting::all(),
                'cardtypes' => Cardtype::where('status', 1)->get(),
            ];
            return view('membership::cardindex', $data);
        } else {
            return $this->unauthorized_access_blocked();
        }
    }




    public function get_datatable_data(Request $request)
    {
        if (permission('card-access')) {
            if ($request->ajax()) {
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

                    if (permission('card-edit')) {
                        $action .= ' <a class="dropdown-item edit_data" data-id="' . $value->id . '"><i class="fas fa-edit text-primary"></i> Edit</a>';
                    }
                    if (permission('card-view')) {
                        $action .= ' <a class="dropdown-item view_data" data-id="' . $value->id . '"><i class="fas fa-eye text-success"></i> View</a>';
                    }
                    if (permission('card-delete')) {
                        $action .= ' <a class="dropdown-item delete_data"  data-id="' . $value->id . '" data-name="' . $value->name . '"><i class="fas fa-trash text-danger"></i> Delete</a>';
                    }

                    $row = [];

                    if (permission('card-bulk-delete')) {
                        $row[] = table_checkbox($value->id);
                    }
                    $row[] = $no;
                    $row[] = $value->cardtype->name;
                    $row[] = $value->card_id;
                    $row[] = $value->allmembers->firstname . '' . $value->allmembers->lastname;
                    $row[] = $value->card_min_value;
                    $row[] = $value->card_trash_hold;
                    $row[] = $value->room_access;
                    $row[] = $value->card_facilities_id;
                    $row[] = table_image($value->image, CARD_IMAGE_PATH, $value->name);
                    $row[] = permission('card-edit') ? change_status($value->id, $value->status, $value->name) : STATUS_LABEL[$value->status];;
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


    public function store_or_update_data(cardFormRequest $request)
    {
        if ($request->ajax()) {
            if (permission('card-add') || permission('card-edit')) {
                $collection = collect($request->validated())->except(['image']);
                $card_facilities_id = implode(',', $request->card_facilities_id);

                $image = $request->old_image;
                if ($request->hasFile('image')) {
                    $image = $this->upload_file($request->file('image'), CARD_IMAGE_PATH);

                    if (!empty($request->old_image)) {
                        $this->delete_file($request->old_image, CARD_IMAGE_PATH);
                    }
                }
                $collection = $collection->merge(compact('image', 'card_facilities_id'));
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
            if (permission('card-edit')) {
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
            if (permission('card-delete')) {
                $card = $this->model->find($request->id);
                $image = $card->image;
                $result = $card->delete();
                if ($result) {
                    if (!empty($image)) {
                        $this->delete_file($image, ITEM_IMAGE_PATH);
                    }
                }
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
            if (permission('card-bulk-delete')) {
                $cards = $this->model->toBase()->select('image')->whereIn('id', $request->ids)->get();
                $result = $this->model->destroy($request->ids);
                if ($result) {
                    if (!empty($cards)) {
                        foreach ($cards as $card) {
                            if ($card->image) {
                                $this->delete_file($card->image, ITEM_IMAGE_PATH);
                            }
                        }
                    }
                }
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
            if (permission('card-edit')) {
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
