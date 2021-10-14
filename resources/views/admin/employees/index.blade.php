@extends('layouts.app')

@section('content')

    <div class="container">

        @include('admin.components.breadcrumb', [
           'title' => 'Employees List',
           'parents' => [
               route('admin.dashboard') => 'Admin'
           ],
           'active' => 'Employees',
       ])

        <a href="{{ route('admin.employees.create') }}" class="btn btn-primary mb-2"><i
                class="far fa-plus-square"></i> Create</a>

        <table class="table table-striped table-borderless">
            <thead class="thead-dark">
            <th>Name</th>
            <th>Email</th>
            <th class="text-right">Do</th>
            </thead>
            <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="text-right">
                        <form onsubmit="if(confirm('Delete?')){ return true }else{ return false }"
                              action="{{ route('admin.employees.destroy', $user) }}" method="post">
                            @method('DELETE')
                            @csrf

                            <a class="btn btn-primary" href="{{ route('admin.employees.edit', $user) }}"><i
                                    class="fa fa-edit"></i></a>

                            <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center"><h2>No data</h2></td>
                </tr>
            @endforelse
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3">
                    {{ $users->links('pagination::bootstrap-4') }}
                </td>
            </tr>
            </tfoot>
        </table>

    </div>

@endsection
