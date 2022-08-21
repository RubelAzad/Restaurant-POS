@extends('layouts.app')

@section('title')
    {{ $page_title }}
@endsection

@push('stylesheet')
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.1/css/bootstrap-multiselect.css"
        type="text/css">
    <style>
        .col-md-4.member .bootstrap-select {
            width: 100% !important;
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
                    <!-- /entry heading -->
                    @if (permission('facilitydiscount-add'))
                        <button class="btn btn-primary btn-sm"
                            onclick="showStoreFormModal('Add New facilitydiscount','Save')">
                            <i class="fas fa-plus-square"></i> Add New
                        </button>
                    @endif


                </div>
                <!-- /entry header -->

                <!-- Card -->
                <div class="dt-card">

                    <!-- Card Body -->
                    <div class="dt-card__body">

                        <form id="form-filter">
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="name">Food Name</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="Enter Food name">
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="button" class="btn btn-danger btn-sm float-right" id="btn-reset"
                                        data-toggle="tooltip" data-placement="top" data-original-title="Reset Data">
                                        <i class="fas fa-redo-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm float-right mr-2" id="btn-filter"
                                        data-toggle="tooltip" data-placement="top" data-original-title="Filter Data">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <table id="dataTable" class="table table-striped table-bordered table-hover">
                            <thead class="bg-primary">
                                <tr>
                                    @if (permission('facilitydiscount-bulk-delete'))
                                        <th>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="select_all"
                                                    onchange="select_all()">
                                                <label class="custom-control-label" for="select_all"></label>
                                            </div>
                                        </th>
                                    @endif
                                    <th>Sl</th>
                                    <th>Memeber Name</th>
                                    <th>Facility Name</th>
                                    <th>Price</th>
                                    <th>Discount Type</th>
                                    <th>Percentage Discount</th>
                                    <th>Fixed Discount</th>
                                    <th>Discount Price</th>
                                    <th>Discount Start Date</th>
                                    <th>Discount End Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                    </div>
                    <!-- /card body -->

                </div>
                <!-- /card -->

            </div>
            <!-- /grid item -->

        </div>
        <!-- /grid -->

    </div>
    @include('membership::facilitydiscountmodal')
@endsection

@push('script')
    <script src="js/spartan-multi-image-picker-min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.1/js/bootstrap-multiselect.min.js">
    </script>
    <script>
        $(document).ready(function() {
            function card_numberInputCheck(c, v) {
                if (c && v === 'percentage') {
                    $('.percentageDiscount').removeClass('d-none');
                } else {
                    $('.percentageDiscount').addClass('d-none');
                }

                if (c && v === 'fixed') {
                    $('.fixedDiscount').removeClass('d-none');
                } else {
                    $('.fixedDiscount').addClass('d-none');
                }
            }
            $('.card_numberInput').each(function() {
                $(this).is(':checked') && card_numberInputCheck($(this).is(':checked'), $(this).val());
            });
            $('.card_numberInput').on('change', function() {
                let checked = $(this).is(':checked');
                let val = $(this).val();
                card_numberInputCheck(checked, val);
            });
        });
    </script>

    <script type="text/javascript">
        $('#store_or_update_modal').on('show.bs.modal', function() {
            if ($('#offer').is(':checked') === false) {
                $('.dependentOnOffer').hide();
            } else {
                $('.dependentOnOffer').show();
            }
        });

        $('#offer').on('change', function() {
            if ($(this).is(':checked')) {
                $('.dependentOnOffer').show();
            } else {
                $('.dependentOnOffer').hide();
            }
        })
    </script>
    <script>
        var table;
        $(document).ready(function() {
            $('.time').datetimepicker({
                format: 'hh:mm A',
                ignoreReadonly: true
            });
            $('.date').datetimepicker({
                format: 'YYYY-MM-DD',
                ignoreReadonly: true
            });
            table = $('#dataTable').DataTable({
                "processing": true, //Feature control the processing indicator
                "serverSide": true, //Feature control DataTable server side processing mode
                "order": [], //Initial no order
                "responsive": true, //Make table responsive in mobile device
                "bInfo": true, //TO show the total number of data
                "bFilter": false, //For datatable default search box show/hide
                "lengthMenu": [
                    [5, 10, 15, 25, 50, 100, 1000, 10000, -1],
                    [5, 10, 15, 25, 50, 100, 1000, 10000, "All"]
                ],
                "pageLength": 25, //number of data show per page
                "language": {
                    processing: `<i class="fas fa-spinner fa-spin fa-3x fa-fw text-primary"></i> `,
                    emptyTable: '<strong class="text-danger">No Data Found</strong>',
                    infoEmpty: '',
                    zeroRecords: '<strong class="text-danger">No Data Found</strong>'
                },
                "ajax": {
                    "url": "{{ route('facilitydiscount.datatable.data') }}",
                    "type": "POST",
                    "data": function(data) {
                        data.name = $("#form-filter #name").val();
                        data._token = _token;
                    }
                },
                "columnDefs": [{
                        @if (permission('facilitydiscount-bulk-delete'))
                            "targets": [0, 12],
                        @else
                            "targets": [11],
                        @endif
                        "orderable": false,
                        "className": "text-center"
                    },
                    {
                        @if (permission('facilitydiscount-bulk-delete'))
                            "targets": [1, 2, 3, 4, 5, 6, 7, 10, 11],
                        @else
                            "targets": [0, 1, 3, 4, 5, 6, 9, 10],
                        @endif
                        "className": "text-center"
                    },
                    {
                        @if (permission('facilitydiscount-bulk-delete'))
                            "targets": [8, 9],
                        @else
                            "targets": [7, 8],
                        @endif
                        "className": "text-right"
                    }
                ],
                "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6' <'float-right'B>>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'<'float-right'p>>>",

                "buttons": [
                    @if (permission('facilitydiscount-report'))
                        {
                            'extend': 'colvis',
                            'className': 'btn btn-secondary btn-sm text-white',
                            'text': 'Column'
                        }, {
                            "extend": 'print',
                            'text': 'Print',
                            'className': 'btn btn-secondary btn-sm text-white',
                            "title": "Menu List",
                            "orientation": "landscape", //portrait
                            "pageSize": "A4", //A3,A5,A6,legal,letter
                            "exportOptions": {
                                columns: function(index, data, node) {
                                    return table.column(index).visible();
                                }
                            },
                            customize: function(win) {
                                $(win.document.body).addClass('bg-white');
                            },
                        }, {
                            "extend": 'csv',
                            'text': 'CSV',
                            'className': 'btn btn-secondary btn-sm text-white',
                            "title": "Menu List",
                            "filename": "facilitydiscount-list",
                            "exportOptions": {
                                columns: function(index, data, node) {
                                    return table.column(index).visible();
                                }
                            }
                        }, {
                            "extend": 'excel',
                            'text': 'Excel',
                            'className': 'btn btn-secondary btn-sm text-white',
                            "title": "Menu List",
                            "filename": "facilitydiscount-list",
                            "exportOptions": {
                                columns: function(index, data, node) {
                                    return table.column(index).visible();
                                }
                            }
                        }, {
                            "extend": 'pdf',
                            'text': 'PDF',
                            'className': 'btn btn-secondary btn-sm text-white',
                            "title": "Menu List",
                            "filename": "facilitydiscount-list",
                            "orientation": "landscape", //portrait
                            "pageSize": "A4", //A3,A5,A6,legal,letter
                            "exportOptions": {
                                columns: [1, 2, 3]
                            },
                        },
                    @endif
                    @if (permission('facilitydiscount-bulk-delete'))
                        {
                            'className': 'btn btn-danger btn-sm delete_btn d-none text-white',
                            'text': 'Delete',
                            action: function(e, dt, node, config) {
                                multi_delete();
                            }
                        }
                    @endif
                ],
            });

            $('#btn-filter').click(function() {
                table.ajax.reload();
            });

            $('#btn-reset').click(function() {
                $('#form-filter')[0].reset();
                $('#form-filter .selectpicker').selectpicker('refresh');
                table.ajax.reload();
            });

            $(document).on('click', '#save-btn', function() {
                let form = document.getElementById('store_or_update_form');
                let formData = new FormData(form);
                let url = "{{ route('facilitydiscount.store.or.update') }}";
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
                        $('#store_or_update_form').find('.is-invalid').removeClass(
                            'is-invalid');
                        $('#store_or_update_form').find('.error').remove();
                        if (data.status == false) {
                            $.each(data.errors, function(key, value) {
                                $('#store_or_update_form input#' + key).addClass(
                                    'is-invalid');
                                $('#store_or_update_form textarea#' + key).addClass(
                                    'is-invalid');
                                $('#store_or_update_form select#' + key).parent()
                                    .addClass('is-invalid');
                                if (key == 'code') {
                                    $('#store_or_update_form #' + key).parents(
                                        '.form-group').append(
                                        '<small class="error text-danger">' +
                                        value + '</small>');
                                } else {
                                    $('#store_or_update_form #' + key).parent().append(
                                        '<small class="error text-danger">' +
                                        value + '</small>');
                                }

                            });
                        } else {
                            notification(data.status, data.message);
                            if (data.status == 'success') {
                                if (method == 'update') {
                                    table.ajax.reload(null, false);
                                } else {
                                    table.ajax.reload();
                                }
                                $('#store_or_update_modal').modal('hide');
                            }
                        }

                    },
                    error: function(xhr, ajaxOption, thrownError) {
                        console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr
                            .responseText);
                    }
                });
            });

            $(document).on('click', '.edit_data', function() {
                let id = $(this).data('id');
                $('#store_or_update_form')[0].reset();
                $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
                $('#store_or_update_form').find('.error').remove();
                if (id) {
                    $.ajax({
                        url: "{{ route('facilitydiscount.edit') }}",
                        type: "POST",
                        data: {
                            id: id,
                            _token: _token
                        },
                        dataType: "JSON",
                        success: function(data) {


                            $('#store_or_update_form #update_id').val(data.id);
                            $('#store_or_update_form #facilities_member_id').val(data.facilities_member_id);
                            $('#store_or_update_form #facilities_discount_id').val(data.facilities_discount_id);
                            $('#store_or_update_form #facilities_discount_price').val(data.facilities_discount_price);
                            //$('#store_or_update_form #facilities_discount_type').val(data.facilities_discount_type);
                            $('#store_or_update_form #facilities_discount_type').prop('radio' ,data.facilities_discount_type);
                            $('#store_or_update_form #facilities_discount_percentage').val(data.facilities_discount_percentage);
                            $('#store_or_update_form #facilities_discount_fixed').val(data.facilities_discount_fixed);
                            $('#store_or_update_form #facilities_discount_offer_price').val(data.facilities_discount_offer_price);
                            $('#store_or_update_form #facilities_discount_start_date').val(data.facilities_discount_start_date);
                            $('#store_or_update_form #facilities_discount_end_date').val(data.facilities_discount_end_date);

                            

                            $('#store_or_update_modal').modal({
                                keyboard: false,
                                backdrop: 'static',
                            });
                            $('#store_or_update_modal .modal-title').html(
                                '<i class="fas fa-edit"></i> <span>Edit ' + data.name +
                                '</span>');
                            $('#store_or_update_modal #save-btn').text('Update');

                        },
                        error: function(xhr, ajaxOption, thrownError) {
                            console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr
                                .responseText);
                        }
                    });
                }
            });




            $(document).on('click', '.delete_data', function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let row = table.row($(this).parent('tr'));
                let url = "{{ route('facilitydiscount.delete') }}";
                delete_data(id, url, table, row, name);
            });

            function multi_delete() {
                let ids = [];
                let rows;
                $('.select_data:checked').each(function() {
                    ids.push($(this).val());
                    rows = table.rows($('.select_data:checked').parents('tr'));
                });
                if (ids.length == 0) {
                    Swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: 'Please checked at least one row of table!',
                        icon: 'warning',
                    });
                } else {
                    let url = "{{ route('facilitydiscount.bulk.delete') }}";
                    bulk_delete(ids, url, table, rows);
                }
            }

            $(document).on('click', '.change_status', function() {
                let id = $(this).data('id');
                let status = $(this).data('status');
                let name = $(this).data('name');
                let row = table.row($(this).parent('tr'));
                let url = "{{ route('facilitydiscount.change.status') }}";
                change_status(id, status, name, table, url);

            });

            $(document).on('change', '.facilities_data', function() {
                let id = $(this).val();

                if (id) {
                    $.ajax({
                        url: "{{ route('facilitydiscount.price') }}",
                        type: "POST",
                        data: {
                            facilities_id: id,
                            _token: _token
                        },
                        dataType: "JSON",
                        success: function(data) {
                            let {
                                facilities_price
                            } = Array.isArray(data) && data[0];
                            $('#facilities_discount_price').val(facilities_price);
                        },
                        error: function(xhr, ajaxOption, thrownError) {
                            console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr
                                .responseText);
                        }
                    });
                }
            });

            $('#image').spartanMultiImagePicker({
                fieldName: 'image',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName: 'col-md-12 com-sm-12 com-xs-12',
                maxFileSize: '',
                dropFileLabel: 'Drop Here',
                allowExt: 'png|jpg|jpeg',
                onExtensionErr: function(index, file) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Only png,jpg,jpeg file format allowed!'
                    });
                }
            });

            $('input[name="image"]').prop('required', true);

            $('.remove-files').on('click', function() {
                $(this).parents('.col-md-12').remove();
            });

            $('#generate_barcode').click(function() {
                $.get('generate-code', function(data) {
                    $('#store_or_update_form #code').val(data);
                });
            });



        });


        function showStoreFormModal(modal_title, btn_text) {
            $('#store_or_update_form')[0].reset();
            $('#store_or_update_form #update_id').val('');
            $('#store_or_update_form').find('.is-invalid').removeClass('is-invalid');
            $('#store_or_update_form').find('.error').remove();

            $('#store_or_update_form #image img.spartan_image_placeholder').css('display', 'block');
            $('#store_or_update_form #image .spartan_remove_row').css('display', 'none');
            $('#store_or_update_form #image .img_').css('display', 'none');
            $('#store_or_update_form #image .img_').attr('src', '');
            $('.selectpicker').selectpicker('refresh');
            $('#store_or_update_modal').modal({
                keyboard: false,
                backdrop: 'static',
            });
            $('#store_or_update_modal .modal-title').html('<i class="fas fa-plus-square"></i> ' + modal_title);
            $('#store_or_update_modal #save-btn').text(btn_text);
        }
    </script>
@endpush
