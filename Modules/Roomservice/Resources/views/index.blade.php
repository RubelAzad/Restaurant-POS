@extends('layouts.app')

@section('title')
    {{ $page_title }}
@endsection

@push('stylesheet')
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
    <style>
        .swal-height {
            height: 30vh;
            margin-bottom: 20px;
        }
    </style>
@endpush

@section('content')
    <div class="dt-content">

        <!-- Grid -->
        <div class="row">
            <div class="col-xl-12 pb-3">
                <ol class="breadcrumb bg-white">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                    <li class="active breadcrumb-item">{{ $sub_title }}</li>
                </ol>
            </div>
            <!-- Grid Item -->
            <div class="col-xl-12">

                <!-- Entry Header -->
                <div class="dt-entry__header">

                    <!-- Entry Heading -->
                    <div class="dt-entry__heading">
                        <h2 class="dt-page__title mb-0 text-primary"><i class="{{ $page_icon }}"></i> {{ $sub_title }}
                        </h2>
                    </div>


                </div>
                <!-- /entry header -->
                <!-- roomitem -->
                <div class="dt-roomitem">

                    <!-- roomitem Body -->
                    <div class="dt-roomitem__body">
                        <div class="row align-items-center" style="height: 60px">

                            <div class="form-group col-md-1 ml-6">
                                <input class="form-check-input" id="checkAll" type="checkbox" name="checkAll"
                                    value="checkAll">
                                <label for="checkAll" class="form-check-label">All</label>
                            </div>
                            <div class="form-group col-md-4" id="roomServiceType" style="display: none">
                                <label for="">Room Service Price Type</label><br>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <label class="form-check-label" for="roomServicePricePercentage">
                                        <input type="radio" class="form-check-input roomServicePriceOrPercentage"
                                            id="roomServicePricePercentage" name="priceOrPercentage" value="percentage"
                                            checked>Percentage
                                    </label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <label class="form-check-label" for="roomServicePriceFixed">
                                        <input type="radio" class="form-check-input roomServicePriceOrPercentage"
                                            id="roomServicePriceFixed" name="priceOrPercentage" value="fixed">Fixed
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-4" id="roomServicePrice" style="display: none">
                                <div class="form-group d-flex">
                                    <input type="text" id="room_service_price" class="form-control mr-2"
                                        placeholder="Extra Price" />
                                    <button type="button" class="btn btn-primary btn-sm" id="add_btn">Add</button>
                                </div>
                            </div>
                        </div>
                        <div class="list-group" id="myFileContainer"></div>
                        <form id="roomitem_form" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="hidden" name="update_id" id="update_id" />
                                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th>SL</th>
                                                <th width="8%">Item Id</th>
                                                <th width="40%">Item Name</th>
                                                <th width="20%">Price</th>
                                                <th width="20%">Room service item Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0;
                                            ?>
                                            @foreach ($items as $item)
                                                <tr>
                                                    <td><input type="checkbox" id="vehicle1" name="room_service_item_id[]"
                                                            value="{{ $item->id }}"></td>
                                                    <td width="8%">{{ $item->id }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td class="productPrice">{{ $item->price }}</td>
                                                    <td><input type="text" name="room_service_extra_price[]"
                                                            placeholder="Add Extra Price"
                                                            class="form-control room-service-price" />
                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>

                                    </table>
                                </div>
                                <div class="form-group col-md-12 text-center">
                                    <button type="button" class="btn btn-primary btn-sm" id="save-btn">Save</button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <!-- /roomitem body -->

                </div>
                <!-- /roomitem -->

            </div>
            <!-- /grid item -->

        </div>
        <!-- /grid -->

    </div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>">
    <script>
        $(document).ready(function() {

            $('#checkAll').on('change', function() {
                if ($(this).is(":checked")) {
                    $('#roomServicePrice').fadeIn();
                    $('#roomServiceType').fadeIn();
                    $('#example td').each(function() {
                        $(this).find('input[type="checkbox"]').prop('checked', true);
                        $(this).find('input[type="radio"]').prop('checked', true);
                    });
                } else {
                    $('#roomServicePrice').fadeOut();
                    $('#roomServiceType').fadeOut();
                    $('#room_service_price').val('');
                    $('#example td').each(function() {
                        $(this).find('input[type="checkbox"]').prop('checked', false);
                        $(this).find('input[type="radio"]').prop('checked', false);
                        $(this).find('.room-service-price').val('');
                    });
                }
            });


            $('#example td').each(function() {
                $(this).find('input[type="checkbox"]').on('change', function() {
                    if ($(this).is(":checked") === false) {
                        $(this).closest('tr').find('.room-service-price').val('');
                    } else {
                        $(this).closest('tr').find('.room-service-price').val($(
                            '#room_service_price').val());
                    }
                })
            });

            function dataInit() {
                var DataTable = $('#example').DataTable({
                    lengthChange: true,
                    paging: false,
                    ordering: false,
                    info: false,
                    buttons: ['copy', 'excel', 'pdf', 'colvis']
                });

                DataTable.buttons().container()
                    .appendTo('#example_wrapper .col-md-6:eq(0)');
            }
            dataInit();

            function extraPriceCalculate() {
                $('.roomServicePriceOrPercentage').each(function() {
                    if ($(this).is(':checked')) {
                        let priceExtendType = $(this).val();
                        $('.room-service-price').each(function() {
                            if ($(this).closest('tr').find('input[type="checkbox"]').is(
                                    ":checked") === true) {
                                let pp = parseInt($(this).closest('tr').find('td.productPrice')
                                    .text().trim())

                                if (priceExtendType === 'fixed') {
                                    $(this).val(parseInt($('#room_service_price').val()) + pp);
                                } else if (priceExtendType === 'percentage') {
                                    let percentagedPrice = Math.round((parseInt($(
                                        '#room_service_price').val()) * pp) / 100);
                                    $(this).val(pp + percentagedPrice);
                                }
                            }
                        });
                    }
                });
            }

            $('#add_btn').on('click', function() {
                extraPriceCalculate();
            });

            $('.roomServicePriceOrPercentage').on('change', function() {
                extraPriceCalculate();
            })

            $(document).on('click', '#save-btn', function() {
                let form = document.getElementById('roomitem_form');
                let formData = new FormData(form);
                let url = "{{ route('roomitem.store.or.update') }}";
                let id = $('#update_id').val();
                let method;
                if (id) {
                    method = 'update';
                } else {
                    method = 'add';
                }
                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    dataType: "JSON",
                    contentType: false,
                    processData: false,
                    cache: false,
                    beforeSend: function() {
                        $('#save-btn').addClass('kt-spinner kt-spinner--md kt-spinner--light');
                    },
                    complete: function() {
                        $('#save-btn').removeClass(
                            'kt-spinner kt-spinner--md kt-spinner--light');
                    },
                    success: function(data) {

                        if (data === true) {
                            swal.fire({
                                title: "Room Service Add Price",
                                icon: 'success',
                                text: "Add Price has been Saved Successfully",
                                customClass: 'swal-height',
                                showConfirmButton: false,
                                reverseButtons: !0
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 3000);
                        } else {
                            swal.fire("Error!", "error");
                        }

                    },
                    error: function(xhr, ajaxOption, thrownError) {
                        console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr
                            .responseText);
                    }
                });
            });
        });
    </script>
@endpush
