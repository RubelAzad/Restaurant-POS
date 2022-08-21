@extends('layouts.app')

@section('title')
    {{ $page_title }}
@endsection

@push('stylesheet')
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

                </div>
                <!-- /entry header -->

                <!-- Card -->
                <div class="dt-card">

                    <!-- Card Body -->
                    <div class="dt-card__body">
                        <div class="dt-card__body tabs-container tabs-vertical">

                            <!-- Tab Navigation -->
                            <ul class="nav nav-tabs flex-column" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#general-cardsetting" role="tab"
                                        aria-controls="general-cardsetting" aria-selected="true">Card Setting
                                    </a>
                                </li>
                            </ul>
                            <!-- /tab navigation -->

                            <!-- Tab Content -->
                            <div class="tab-content">

                                <!-- Tab Pane -->
                                <div id="general-cardsetting" class="tab-pane active">
                                    <div class="card-body">
                                        <form id="general-form" class="col-md-12" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <x-form.textbox labelName="Title" name="title" required="required"
                                                    value="{{ config('cardsettings.title') }}" col="col-md-8"
                                                    placeholder="Enter title" />

                                                <x-form.textbox labelName="Card Prefix" name="card_prefix"
                                                    required="required" value="{{ config('cardsettings.card_prefix') }}"
                                                    col="col-md-8" placeholder="Enter Card prefix" />

                                                <div class="form-group col-md-8">
                                                    <label for="">Chosse Your Number Format</label><br>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="number" name="card_number"
                                                            value="number" class="custom-control-input card_numberInput"
                                                            {{ config('cardsettings.card_number') == 'number' ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="number">number</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" id="random" name="card_number"
                                                            value="random" class="custom-control-input card_numberInput"
                                                            {{ config('cardsettings.card_number') == 'random' ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="random">Random</label>
                                                    </div>
                                                </div>

                                                <x-form.textbox labelName="Card Number Format" name="card_number_format"
                                                    value="{{ config('cardsettings.card_number_format') }}"
                                                    col="col-md-8 cardNumber d-none"
                                                    placeholder="Enter Card Number Format" />

                                                <x-form.textbox labelName="Random Number Start Length" name="card_random_format"
                                                    value="{{ config('cardsettings.card_random_format') }}"
                                                    col="col-md-8 d-none randomNumber"
                                                    placeholder="Enter Random Number Start Length" />

                                                <x-form.textbox labelName="Random Number Generate Length must be equal or geter than start length" name="card_random_generate"
                                                    value="{{ config('cardsettings.card_random_generate') }}"
                                                    col="col-md-8 d-none randomNumber"
                                                    placeholder="Enter Random Number Generate Length Same or geter than" />
                                            </div>

                                            <div class="form-group col-md-12">
                                                <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                                                <button type="button" class="btn btn-primary btn-sm" id="general-save-btn"
                                                    onclick="save_data('general')">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /tab pane-->

                            </div>
                            <!-- /tab content -->

                        </div>
                    </div>
                    <!-- /card body -->

                </div>
                <!-- /card -->

            </div>
            <!-- /grid item -->

        </div>
        <!-- /grid -->

    </div>
@endsection

@push('script')
    <script src="js/spartan-multi-image-picker-min.js"></script>
    <script>
        $(document).ready(function() {

            function card_numberInputCheck(c, v) {
                if (c && v === 'number') {
                    $('.cardNumber').removeClass('d-none');
                } else {
                    $('.cardNumber').addClass('d-none');
                }

                if (c && v === 'random') {
                    $('.randomNumber').removeClass('d-none');
                } else {
                    $('.randomNumber').addClass('d-none');
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


            $('#logo').spartanMultiImagePicker({
                fieldName: 'logo',
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
                        text: 'Only png, jpg and jpeg file format allowed!'
                    });
                }
            });
            $('#favicon').spartanMultiImagePicker({
                fieldName: 'favicon',
                maxCount: 1,
                rowHeight: '200px',
                groupClassName: 'col-md-12 com-sm-12 com-xs-12',
                maxFileSize: '',
                dropFileLabel: 'Drop Here',
                allowExt: 'png',
                onExtensionErr: function(index, file) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Only png file format allowed!'
                    });
                }
            });

            $('input[name="logo"],input[name="favicon"]').prop('required', true);

            $('.remove-files').on('click', function() {
                $(this).parents('.col-md-12').remove();
            });



        });

        function save_data(form_id) {
            let form = document.getElementById(form_id + '-form');
            let formData = new FormData(form);
            let url;
            if (form_id == 'general') {
                url = "{{ route('general.cardsetting') }}";
            } else {
                url = "{{ route('mail.setting') }}";
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
                    $('#' + form_id + '-save-btn').addClass('kt-spinner kt-spinner--md kt-spinner--light');
                },
                complete: function() {
                    $('#' + form_id + '-save-btn').removeClass('kt-spinner kt-spinner--md kt-spinner--light');
                },
                success: function(data) {
                    $('#' + form_id + '-form').find('.is-invalid').removeClass('is-invalid');
                    $('#' + form_id + '-form').find('.error').remove();
                    if (data.status == false) {
                        $.each(data.errors, function(key, value) {
                            $('#' + form_id + '-form input#' + key).addClass('is-invalid');
                            $('#' + form_id + '-form textarea#' + key).addClass('is-invalid');
                            $('#' + form_id + '-form select#' + key).parent().addClass('is-invalid');
                            $('#' + form_id + '-form #' + key).parent().append(
                                '<small class="error text-danger">' + value + '</small>');
                        });
                    } else {
                        notification(data.status, data.message);
                    }
                },
                error: function(xhr, ajaxOption, thrownError) {
                    console.log(thrownError + '\r\n' + xhr.statusText + '\r\n' + xhr.responseText);
                }
            });
        }
    </script>
@endpush
