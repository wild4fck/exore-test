@extends('layouts.app')

@section('content')

    <div class="container">

        @include('admin.components.breadcrumb', [
            'title' => 'Редактирование пользователя',
            'parents' => [
                route('admin.dashboard') => 'Главная',
                route('admin.employees.index') => 'Пользователи',
            ],
            'active' => 'Редактирование',
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
