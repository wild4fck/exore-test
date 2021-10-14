@extends('layouts.app')

@section('content')

    <div class="container">

        @include('admin.components.breadcrumb', [
            'title' => 'Adding an entry',
            'parents' => [
                route('admin.dashboard') => 'Admin',
                route('admin.records.index') => 'Records',
            ],
            'active' => 'Adding',
        ])

        <hr/>

        <form class="form-horizontal" action="{{ route('admin.records.store') }}" method="post">
            @csrf

            {{-- Form include --}}
            @include('admin.records._form')

        </form>

    </div>

@endsection
