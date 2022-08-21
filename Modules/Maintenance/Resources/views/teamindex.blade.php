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
                    <h2 class="dt-page__title mb-0 text-primary"><i class="{{ $page_icon }}"></i> {{ $sub_title }}</h2>
                </div>
                

            </div>
            <!-- /entry header -->

            <!-- Card -->
            <div class="dt-card">

                <!-- Card Body -->
                <div class="dt-card__body">

                    <table id="dataTable" class="table table-striped table-bordered table-hover">
                        <thead class="bg-primary">
                            <tr>
                                <th>Employee Id</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Department</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teams as $team)
                                <td>{{$team->employee_id}}</td>
                                <td>{{$team->first_name.' '.$team->middle_name.' '.$team->last_name}}</td>
                                <td>{{$team->email}}</td>
                                <td>{{$team->phone}}</td>
                                <td>{{$team->department_name}}</td>
                                
                            @endforeach
                        </tbody>
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
@endsection

@push('script')
<script>
    $(document).ready(function() {
    $('#dataTable').DataTable( {
        dom: 'Bfrtip',
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }
            },
            'colvis'
        ]
    } );
} );
    </script>
@endpush