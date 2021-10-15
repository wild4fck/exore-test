@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }} Admin</div>

                    <div class="card-body">
                        <ul class="list-group">
                            @manager
                            <li class="list-group-item">
                                <a href="{{ route('admin.employees.index') }}">Employees</a>
                            </li>
                            @endmanager
                            <li class="list-group-item"><a href="{{ route('admin.records.index') }}">Records</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
