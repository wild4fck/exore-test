@extends('layouts.app')

@section('content')

    <div class="container">

        @include('admin.components.breadcrumb', [
              'title' => 'Editing a record',
              'parents' => [
                  route('admin.dashboard') => 'Admin',
                  route('admin.records.index') => 'Records',
              ],
              'active' => 'Editing',
          ])

        <hr/>

        <form class="form-horizontal" action="{{ route('admin.records.update', $record) }}" method="post">
            @method('PUT')
            @csrf

            {{-- Form include --}}
            @include('admin.records._form')
        </form>

    </div>

@endsection
