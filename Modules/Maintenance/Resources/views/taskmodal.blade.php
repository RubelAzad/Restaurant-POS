<div class="modal fade" id="store_or_update_modal" tabindex="-1" role="dialog" aria-labelledby="model-1"
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
            <form id="store_or_update_form" method="post">
                @csrf
                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row">

                        <input type="hidden" name="update_id" id="update_id" />

                        <div class="col-md-9">
                            <div class="row">
                                <x-form.textbox labelName="Name" name="name" required="required" col="col-md-4" placeholder="Enter Task name" />
                                <x-form.selectbox labelName="Employee Name" name="employee_id" col="col-md-4" class="selectpicker" required="required">
                                @if (!$teams->isEmpty())
                                @foreach ($teams as $team)
                                <option value="{{ $team->emp_his_id }}">{{ $team->first_name.' '.$team->middle_name.' '.$team->last_name}}</option>
                                @endforeach
                                @endif
                                </x-form.selectbox>
                                <x-form.selectbox labelName="Task Type" name="type_id" col="col-md-4" class="selectpicker" required="required">
                                    @if (!$taskTypes->isEmpty())
                                    @foreach ($taskTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->type_name}}</option>
                                    @endforeach
                                    @endif
                                </x-form.selectbox>
                                <x-form.selectbox col="col-md-4 task_floor d-none" class="selectpicker" name="task_floor" id="task_floor" labelName="Room No" required="required">
                                    @if (!$rooms->isEmpty())
                                    @foreach ($rooms as $room)
                                    <option value="{{ $room->roomno }}">{{ $room->roomno}}</option>
                                    @endforeach
                                    @endif
                                </x-form.selectbox>
                                <x-form.textbox labelName="Assign Date" name="assign_dt" col="col-md-4 dependentOnOffer" class="date"/>
                                <x-form.textbox labelName="Schedule date" name="schedule_dt" col="col-md-4 dependentOnOffer" class="date"/>
                            
                                <x-form.textbox labelName="Assign Hours" name="assign_hours" required="required" col="col-md-4" placeholder="Enter Assign Hours" />
                                
                                <x-form.textbox labelName="Assign By" name="assign_by" required="required" col="col-md-4" placeholder="Enter Assign By" />
                                <x-form.textbox labelName="Reported By" name="reported_by" required="required" col="col-md-4" placeholder="Enter Reported By" />
                                <x-form.textarea labelName="Description" name="description" col="col-md-12" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group col-md-12">
                                <label for="before_image">Task Before Image</label>
                                <div class="col-md-12 px-0 text-center">
                                    <div id="before_image">

                                    </div>
                                </div>
                                <input type="hidden" name="old_before_image" id="old_before_image">
                            </div>

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
