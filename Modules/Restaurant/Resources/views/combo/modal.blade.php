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


                        <div class="col-md-8 foodComboInputs">
                            <div class="row">
                                <input type="hidden" name="update_id" id="update_id" />
                                <x-form.textbox labelName="Package Name" name="name" required="required"
                                    col="col-md-6" placeholder="Enter Floor name" />
                                <div class="col-md-6">
                                    <label>Event Type</label>
                                    <div class="form-group food-box">
                                        <select name="event_type" id="event_type" class="form-group food-box">
                                            <option >Select Your Option</option>
                                            <option value="wedding">wedding</option>
                                            <option value="conference">Conference</option>
                                            <option value="seminar">Seminar</option>
                                            <option value="banquet">Banquet</option>
                                            <option value="restaurant">Restaurant</option>
                                            <option value="room">Room Service</option>
                                          </select>
                                    </div>
                                </div>
                                <div class="col-md-12 member">
                                    <label for="multi">Food Name</label>
                                    <div class="form-group food-box">

                                        <select name="item_name[]" id="multi" class="selectpicker" multiple>
                                            @if (!$foodItems->isEmpty())
                                                @foreach ($foodItems as $foodItem)
                                                    <option value="{{ $foodItem->name }}"
                                                        ${`{{ $foodItem->id }}`==data.id ? 'selected' : '' }>
                                                        {{ $foodItem->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <x-form.textbox labelName="Combo Price" name="price" required="required"
                                    col="col-md-6" placeholder="0.00" />

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group col-md-12 required">
                                <label for="image">Food Combo Image</label>
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
