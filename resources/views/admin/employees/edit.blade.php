@extends('layouts.app')

@section('content')

    <div class="container">

        @include('admin.components.breadcrumb', [
            'title' => 'Editing an employee',
            'parents' => [
                route('admin.dashboard') => 'Admin',
                route('admin.employees.index') => 'Employees',
            ],
            'active' => 'Editing',
        ])

        <hr/>

        <form class="form-horizontal" action="{{ route('admin.employees.update', $user) }}" method="post">
            @method('PUT')
            @csrf
            {{-- Form include --}}
            @include('admin.employees.partials.form')

        </form>
    </div>

@endsection
