<div class="modal fade" id="store_or_update_modal" tabindex="-1" role="dialog" aria-labelledby="model-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">

        <!-- Modal Content -->
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary">
                <h3 class="modal-title text-white" id="model-1"></h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <!-- /modal header -->
            <form id="store_or_update_form" method="post">
                @csrf
                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row">

                        <input type="hidden" name="update_id" id="update_id" />

                        <div class="col-md-8">
                            <div class="row">


                                <input type="hidden" name="name" id="name" value="cards" />
                                <x-form.selectbox labelName="Card Type" name="card_type" required="required"
                                    col="col-md-6" class="selectpicker">
                                    @if (!$cardtypes->isEmpty())
                                        @foreach ($cardtypes as $cardtype)
                                            <option value="{{ $cardtype->id }}">
                                                {{ $cardtype->name }}</option>
                                        @endforeach
                                    @endif
                                </x-form.selectbox>
                                <x-form.selectbox labelName="Member Name" name="card_member_id" required="required"
                                    col="col-md-6" class="selectpicker">

                                    @if (!$members->isEmpty())
                                        @foreach ($members as $member)
                                            <option value="{{ $member->customerid }}">
                                                {{ $member->firstname . ' ' . $member->lastname }}</option>
                                        @endforeach
                                    @endif
                                </x-form.selectbox>
                                @if (config('cardsettings.card_number') === 'random')
                                    {{-- {{$randomNumber = random_int(config('cardsettings.card_random_format'), config('cardsettings.card_random_generate'))}}
                                {{dd($randomNumber)}} --}}
                                    <x-form.textbox labelName="Card Number" name="card_id" required="required"
                                        col="col-md-6" placeholder="Enter name"
                                        value="{{ config('cardsettings.card_prefix') . '' . random_int(config('cardsettings.card_random_format'), config('cardsettings.card_random_generate')) }}"
                                        readonly />
                                @endif
                                <?php if(config('cardsettings.card_number') === 'number'){

                                    if(config('cardsettings.card_prefix') != null){
                                        $cardLastNumber1 = 1;
                                        if($cards == null){
                                            $cardPrefix = config('cardsettings.card_prefix');
                                            $cardNumber = config('cardsettings.card_number_format');
                                            $cardGenerateId=$cardPrefix.''.$cardNumber;
                                        }else if($cards->card_id != null){
                                            $cardLastNumber=$cards->card_id;
                                            $cardPrefix = config('cardsettings.card_prefix');
                                            $cardNumber = config('cardsettings.card_number_format');
                                            $numbers = preg_replace('/[^0-9]/', '', $cardLastNumber);
                                            $letters = preg_replace('/[^a-zA-Z]/', '', $cardLastNumber);
                                            if($cardLastNumber == null){
                                                $cardGenerateId = $cardPrefix.''.$cardNumber;
                                            }elseif($letters != $cardPrefix){
                                                $cardGenerateId=$cardPrefix.''.$cardNumber;
                                            }elseif($letters == $cardPrefix){
                                                $cardIncreateId = (int)$numbers + (int)$cardLastNumber1;
                                                $cardGenerateId = $letters.''.$cardIncreateId;
                                            }else{
                                                $cardGenerateId = (int)$cardLastNumber + (int)$cardLastNumber1;
                                            }
                                            
                                        }else{
                                            
                                            $cardGenerateId = (int)$cardLastNumber + (int)$cardLastNumber1;
                                        }

                                        
                                    }
                                   /**
                                    * @method_name :- method_name
                                    * -------------------------------------------------------- 
                                    * @param  :-  {{}|any}
                                    * ?return :-  {{}|any}
                                    * author :-  {{}|null}
                                    * created_by:- Abul Kalam Azad
                                    * created_at:- 26/07/2022 11:16:30
                                    * description :- A method is simply a “chunk” of code.
                                    */
                                    
                                    if(config('cardsettings.card_prefix') == null){

                                        $cardLastNumber1 = 1;
                                        $cardLastNumber=$cards->card_id;
                                        $numbers = preg_replace('/[^0-9]/', '', $cardLastNumber);
                                        $letters = preg_replace('/[^a-zA-Z]/', '', $cardLastNumber);
                                        if($cardLastNumber == null){
                                            $cardNumber = config('cardsettings.card_number_format');
                                            $cardGenerateId = $cardNumber;
                                        }

                                        
                                        if($numbers != null){
                                            $cardGenerateId = (int)$numbers + (int)$cardLastNumber1;
                                        }
                                    }
                                
                                




                                $card_prefix = config('cardsettings.card_prefix');
                                $is_true = 'readonly';
                                $card_number_format = config('cardsettings.card_number_format');?>
                                <x-form.textbox labelName="Card Number" name="card_id" required="required"
                                    col="col-md-6" placeholder="Enter name" value="{{ $cardGenerateId }}"
                                    readonly="readonly" />

                                <?php } ?>
                                <x-form.textbox labelName="Minmum Value" name="card_min_value" required="required"
                                    col="col-md-6" placeholder="0.00" />
                                <x-form.textbox labelName="Trash Hold" name="card_trash_hold" required="required"
                                    col="col-md-6" placeholder="0.00" />
                                <x-form.textbox labelName="Room Access" name="room_access" col="col-md-6"
                                    placeholder="Enter Room Access" />
                                <div class="col-md-12 riMenuInputs">
                                    <div class="ant-card ant-card-bordered gx-card">
                                        <div class="ant-card-head">
                                            <div class="ant-card-head-wrapper">
                                                <div class="ant-card-head-title">Facilities List</div>
                                            </div>
                                        </div><br>
                                        <div class="ant-card-body">
                                            <div class="ant-checkbox-group" id="ri_menu">
                                                @foreach ($facilities as $facilitie)
                                                    <label class="ant-checkbox-wrapper ant-checkbox-group-item">
                                                        <span class="ant-checkbox">
                                                            <input type="checkbox" name="card_facilities_id[]"
                                                                class="ant-checkbox-input"
                                                                value="{{ $facilitie->facilitytypetitle }}">
                                                            <span class="ant-checkbox-inner"></span>
                                                        </span>
                                                        <span>{{ $facilitie->facilitytypetitle }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group col-md-12">
                                <label for="image">Member Image</label>
                                <div class="col-md-12 px-0 text-center">
                                    <div id="image">

                                    </div>
                                </div>
                                <input type="hidden" name="old_image" id="old_image">
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /modal body -->

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-sm" id="save-btn"></button>
                </div>
                <!-- /modal footer -->
            </form>
        </div>
        <!-- /modal content -->

    </div>
</div>
