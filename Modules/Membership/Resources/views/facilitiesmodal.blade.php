<div class="modal fade" id="store_or_update_modal" tabindex="-1" role="dialog" aria-labelledby="model-1" aria-hidden="true">
    <div class="modal-dialog" role="document">

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
                        <x-form.selectbox labelName="Facilities Name" name="facilities_id" required="required"
                            col="col-md-12" class="selectpicker">
                            @if (!$facilities->isEmpty())
                                @foreach ($facilities as $facilitie)
                                    <option value="{{ $facilitie->facilitytypeid }}">
                                        {{ $facilitie->facilitytypetitle }}</option>
                                @endforeach
                            @endif
                        </x-form.selectbox>
                        <x-form.textbox labelName="Facilities Wise Price" name="facilities_price" required="required"
                            col="col-md-12" placeholder="Enter Facilities Price" />
                        <div class="form-group col-md-8">
                            <label for="">Chosse Your Number Format</label><br>
                            <div class="custom-control custom-radio custom-control-inline ">
                                <input type="radio" id="hours" name="facilities_status" value="hours"
                                    class="custom-control-input facilitiesRadio">
                                <label class="custom-control-label" for="hours">Hours</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline ">
                                <input type="radio" id="minutes" name="facilities_status" value="minutes"
                                    class="custom-control-input facilitiesRadio">
                                <label class="custom-control-label" for="minutes">Minutes</label>
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
