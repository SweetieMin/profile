@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page pageTitle')
@section('content')

@push('stylesheets')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap4.css">
@endpush

    <div class="page-header">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="title">
                    <h4>Activity log</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            User settings
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="pd-20 card-box mb-30">
        <table id="example" class="table table-striped table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Event</th>
                    <th>Old Value</th>
                    <th>New Value</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($audits as $audit)
                    <tr>
                        <td>{{ optional($audit->user)->username ?? 'Unknown' }}</td>
                        <td>{{ $audit->event }}</td>
                        <td class="text-danger">
                            @foreach ($audit->old_values as $key => $value)
                                {{ $key }}: {{ $value }} <br>
                            @endforeach
                        </td>
                        
                        <td class="text-primary">
                            @foreach ($audit->new_values as $key => $value)
                                {{ $key }}: {{ $value }} <br>
                            @endforeach
                        </td>
                        <td>{{ $audit->created_at }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

@endsection

@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.js"></script>


    <script>
        new DataTable('#example');
    </script>
@endpush