@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title')
@section('content')


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
                        General settings
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="pd-20 card-box mb-30">


<table class="table table-hover">
    <thead>
        <tr>
            <th>Username</th> <!-- Cột hiển thị tên người dùng -->
            <th>Old Value</th>
            <th>New Value</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody>
        @foreach($audits as $audit)
    <tr>
        <td>{{ optional($audit->user)->username ?? 'Unknown' }}</td>
        <td class="text-danger">
            @foreach($audit->old_values as $key => $value)
                {{ $key }}: {{ $value }} <br>
            @endforeach
        </td>
        <td class="text-primary">
            @foreach($audit->new_values as $key => $value)
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

