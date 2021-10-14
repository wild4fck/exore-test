@extends('layouts.app')

@section('content')

    <div class="container">

        @include('admin.components.breadcrumb', [
                    'title' => 'Employee creation',
                    'parents' => [
                        route('admin.dashboard') => 'Admin',
                        route('admin.employees.index') => 'Employees',
                    ],
                    'active' => 'Creation',
                ])

        <hr/>


        <form class="form-horizontal" action="{{ route('admin.employees.store') }}" method="post">
            @csrf

            {{-- Form include --}}
            @include('admin.employees.partials.form')

        </form>
    </div>

@endsection
