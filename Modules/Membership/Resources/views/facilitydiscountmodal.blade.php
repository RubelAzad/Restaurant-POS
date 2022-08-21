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

                        <div class="col-md-12">
                            <div class="row">
                                {{-- <x-form.selectbox labelName="Member Name" name="facilities_member_id[]"
                                    required="required" col="col-md-4" class="selectpicker multipleMemebr" multiple>
                                    @if (!$members->isEmpty())
                                        @foreach ($members as $member)
                                            <option value="{{ $member->customerid }}">
                                                {{ $member->firstname }}</option>
                                        @endforeach
                                    @endif
                                </x-form.selectbox> --}}

                                <div class="col-md-4 member">
                                    <label for="multi">Member Name</label>
                                    <div class="form-group">

                                        <select name="facilities_member_id[]" id="multi" class="selectpicker"
                                            multiple>
                                            @if (!$members->isEmpty())
                                                @foreach ($members as $member)
                                                    <option value="{{ $member->customerid }}"
                                                        ${`{{ $member->customerid }}`== i.customerid ? 'selected' : '' }>
                                                        {{ $member->firstname }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <x-form.selectbox labelName="Facilities Name" name="facilities_discount_id"
                                    required="required" col="col-md-4" class="selectpicker facilities_data">
                                    @if (!$facilities->isEmpty())
                                        @foreach ($facilities as $facilitie)
                                            <option value="{{ $facilitie->facilities_id }}">
                                                {{ $facilitie->getFacilties->facilitytypetitle }}</option>
                                        @endforeach

                                    @endif
                                </x-form.selectbox>
                                <x-form.textbox labelName="Price" name="facilities_discount_price" col="col-md-4"
                                    readonly="readonly" />
                                <div class="form-group col-md-4">
                                    
                                        
                                    <label for="">Chosse Your Facility Discount Type</label><br>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="percentage" name="facilities_discount_type"
                                            value="percentage" class="custom-control-input card_numberInput">
                                        <label class="custom-control-label" for="percentage">Percentage</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">

                                        <input type="radio" id="fixed" name="facilities_discount_type"
                                            value="fixed" class="custom-control-input card_numberInput">
                                        <label class="custom-control-label" for="fixed">Fixed</label>
                                    </div>
                                </div>
                                <x-form.textbox labelName="( % ) Percentage Discount"
                                    name="facilities_discount_percentage" col="col-md-4 percentageDiscount d-none"
                                    placeholder="Enter Card Number Format" />

                                <x-form.textbox labelName="Fixed Discount" name="facilities_discount_fixed"
                                    col="col-md-4 d-none fixedDiscount"
                                    placeholder="Enter Random Number Start Length" />

                                <x-form.textbox labelName="Discount Start Date" name="facilities_discount_start_date"
                                    col="col-md-4" class="date" />
                                <x-form.textbox labelName="Discount End Date" name="facilities_discount_end_date"
                                    col="col-md-4" class="date" />

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
