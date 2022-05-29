<div class="modal fade" id="store_or_update_modal" tabindex="-1" role="dialog" aria-labelledby="model-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

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
                  <div class="col-md-9">
                    <div class="row">
                      <input type="hidden" name="update_id" id="update_id"/>
                     
                      <x-form.textbox labelName="Name" name="name" required="required" col="col-md-6" placeholder="Enter name"/>
                      <x-form.textbox labelName="Capacity" name="capacity" col="col-md-6" required="required" placeholder="Enter Capacity"/>
                      <x-form.selectbox labelName="floor" name="floor_id" required="required" col="col-md-6" class="selectpicker">
                        @if (!$floors->isEmpty())
                            @foreach ($floors as $floor)
                            <option value="{{ $floor->id }}">{{ $floor->name }}</option>
                            @endforeach
                        @endif
                      </x-form.selectbox>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group col-md-12">
                            <label for="image">Table Image</label>
                            <div class="col-md-12 px-0 text-center">
                                <div id="image">
  
                                </div>
                            </div>
                            <input type="hidden" name="old_image" id="old_image">
                        </div>
                    </div>
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