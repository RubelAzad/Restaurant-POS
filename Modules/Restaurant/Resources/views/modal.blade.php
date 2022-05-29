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
                    <input type="hidden" name="update_id" id="update_id"/>
                    <x-form.textbox labelName="Category Name" name="name" required="required" col="col-md-12" placeholder="Enter category name"/>
                </div>
            </div>
            <x-form.selectbox labelName="Parent Category" name="p_name" col="col-md-12"
                class="selectpicker">
                @if (!$allpnames->isEmpty())
                @foreach ($allpnames as $catgory)
                <option value="{{ $catgory->p_name }}"> {{ $catgory->p_name }}</option>
                <option value="{{ $catgory->name }}"> &nbsp;&nbsp;&nbsp; - {{ $catgory->name }}</option>
                
                @endforeach
                @endif
                @foreach ($rcategories as $subcate)
                @if($subcate->p_id == NULL){
                  <option value="{{ $subcate->name }}">{{ $subcate->name }}</option>
                }
                @endif
                @endforeach
                
            </x-form.selectbox>
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