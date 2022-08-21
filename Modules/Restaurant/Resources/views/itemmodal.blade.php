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

                        <div class="col-md-9">
                            <div class="row">
                                <x-form.textbox labelName="Food Name" name="name" required="required" col="col-md-4"
                                    placeholder="Enter name" />

                                <x-form.selectbox labelName="Category" name="rcat_id" required="required" col="col-md-4"
                                    class="selectpicker">
                                    @if (!$allpnames->isEmpty())
                                        @foreach ($allpnames as $catgory)
                                            <optgroup label="{{ $catgory->p_name }}" style="color:red;">
                                                <option value="{{ $catgory->id }}"> &nbsp;&nbsp;&nbsp; -
                                                    {{ $catgory->name }}</option>
                                            </optgroup>
                                        @endforeach
                                    @endif
                                    @foreach ($rcategories as $subcate)
                                        @if ($subcate->p_id == null)
                                            {
                                            <option value="{{ $subcate->id }}">{{ $subcate->name }}</option>
                                            }
                                        @endif
                                    @endforeach
                                </x-form.selectbox>
                                <x-form.textbox labelName="Components" name="components" col="col-md-4"
                                    placeholder="Enter Components" />
                                <x-form.textbox labelName="Notes" name="notes" col="col-md-4"
                                    placeholder="Enter Notes" />
                                <x-form.textarea labelName="Description" name="description" col="col-md-4" />
                                <x-form.textbox labelName="Tax" name="tax" col="col-md-4" placeholder="0.00" />
                                <x-form.textbox labelName="Price" name="price" required="required" col="col-md-4"
                                    placeholder="0.00" />

                                <x-form.textbox labelName="Quantity" name="qty" col="col-md-4" placeholder="0.00" />

                                <x-form.textbox labelName="Alert Quantity" name="alert_qty" col="col-md-4"
                                    placeholder="0.00" />

                                <div class="col-md-4">
                                    <div class="form-group col-md-6">

                                        <input class="form-check-input" type="checkbox" name="offer" id="offer"
                                            value="Offer">
                                        <label class="form-check-label" for="offer">Offer</label>
                                    </div>
                                </div>
                                <div class="col-md-4 special">
                                    <div class="form-group col-md-6">
                                        <input class="form-check-input" type="checkbox" name="special" id="special"
                                            value="Featured">
                                        <label class="form-check-label">Featured</label>
                                    </div>
                                </div>
                                <x-form.textbox labelName="Cooking Time" name="oc_time" required="required"
                                    col="col-md-4" class="time" />

                                <x-form.textbox labelName="Offer Price" name="op_rate" col="col-md-4 dependentOnOffer"
                                    placeholder="0.00" />
                                <x-form.textbox labelName="Offer Start Date" name="os_date"
                                    col="col-md-4 dependentOnOffer" class="date" />
                                <x-form.textbox labelName="Offer End Date" name="oe_date"
                                    col="col-md-4 dependentOnOffer" class="date" />
                                <div class="col-md-12 riMenuInputs">
                                    <div class="ant-card ant-card-bordered gx-card">
                                        <div class="ant-card-head">
                                            <div class="ant-card-head-wrapper">
                                                <div class="ant-card-head-title">Menu Type</div>
                                            </div>
                                        </div><br>
                                        <div class="ant-card-body">
                                            <div class="ant-checkbox-group" id="ri_menu">
                                                <label class="ant-checkbox-wrapper ant-checkbox-group-item">
                                                    <span class="ant-checkbox">
                                                        <input type="checkbox" name="ri_menu[]"
                                                            class="ant-checkbox-input" value="Launch">
                                                        <span class="ant-checkbox-inner"></span>
                                                    </span>
                                                    <span>Launch</span>
                                                </label>
                                                <label class="ant-checkbox-wrapper ant-checkbox-group-item">
                                                    <span class="ant-checkbox">
                                                        <input type="checkbox" name="ri_menu[]"
                                                            class="ant-checkbox-input" value="Party">
                                                        <span class="ant-checkbox-inner"></span>
                                                    </span><span>Party</span>
                                                </label>
                                                <label class="ant-checkbox-wrapper ant-checkbox-group-item">
                                                    <span class="ant-checkbox">
                                                        <input type="checkbox" name="ri_menu[]"
                                                            class="ant-checkbox-input" value="Coffee">
                                                        <span class="ant-checkbox-inner"></span>
                                                    </span>
                                                    <span>Coffee</span>
                                                </label>
                                                <label class="ant-checkbox-wrapper ant-checkbox-group-item">
                                                    <span class="ant-checkbox">
                                                        <input type="checkbox" name="ri_menu[]"
                                                            class="ant-checkbox-input" value="Breakfast">
                                                        <span class="ant-checkbox-inner"></span>
                                                    </span>
                                                    <span>Breakfast</span>
                                                </label>
                                                <label class="ant-checkbox-wrapper ant-checkbox-group-item">
                                                    <span class="ant-checkbox">
                                                        <input type="checkbox" name="ri_menu[]"
                                                            class="ant-checkbox-input" value="Dinner">
                                                        <span class="ant-checkbox-inner"></span>
                                                    </span>
                                                    <span>Dinner</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group col-md-12 required">
                                <label for="image">Item Image</label>
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
