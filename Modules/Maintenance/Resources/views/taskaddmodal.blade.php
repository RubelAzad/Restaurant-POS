<div class="modal fade" id="store_or_update_modal1" tabindex="-1" role="dialog" aria-labelledby="model-1"
    aria-hidden="true">
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
            <form id="store_or_update_form1" method="post">
                @csrf
                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row">

                        <input type="hidden" name="update_id" id="update_id" />

                        <div class="col-md-9">
                            <div class="row">
                                <input type="hidden" name="name" id="name">
                                <input type="hidden" name="employee_id" id="employee_id">
                                <input type="hidden" name="type_id" id="type_id">
                                <input type="hidden" name="description" id="description">
                                <input type="hidden" name="assign_dt" id="assign_dt">
                                <input type="hidden" name="assign_hours" id="assign_hours">
                                <input type="hidden" name="old_before_image" id="before_image">
                                <input type="hidden" name="assign_by" id="assign_by">

                                <x-form.textbox labelName="Complated Date & Time" name="completed_dt" required="required" col="col-md-6" placeholder="Enter Complated Date & Time" />
                                <x-form.textbox labelName="Complated Hours" name="completed_hours" required="required" col="col-md-6" placeholder="Enter Complated Hours" />
                                <x-form.textbox labelName="Command" name="command" required="required" col="col-md-12" placeholder="Enter Task name" />
                            </div>
                        </div>
                        <div class="col-md-3">

                            <div class="form-group col-md-12">
                                <label for="after_image">Task After Image</label>
                                <div class="col-md-12 px-0 text-center">
                                    <div id="after_image">

                                    </div>
                                </div>
                                <input type="hidden" name="old_after_image" id="old_after_image">
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
