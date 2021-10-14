@extends('layouts.app')

@section('content')

    <div class="container">

        @include('admin.components.breadcrumb', [
               'title' => $postfix ? 'List of records by ' . $postfix : 'List of records',
               'parents' => [
                   route('admin.dashboard') => 'Admin',
               ],
               'active' => 'Records',
           ])


        <a href="{{ route('admin.records.create') }}" class="btn btn-primary mb-2"><i
                class="far fa-plus-square"></i> Создать</a>

        <table class="table table-striped">
            <thead class="thead-dark">
            <th>Name</th>
            <th class="text-center">Category</th>
            <th class="text-center">Picture</th>
            <th class="text-right">Do</th>
            </thead>
            <tbody>
            @forelse ($records as $record)
                <tr>
                    <td class="align-middle"><a
                            href="{{ route('admin.records.show', $record) }}">{{ $record->name }}</a></td>
                    <td class="text-center align-middle">
                        {{ $record->category->name }}
                    </td>
                    <td>
                        <picture class="w-100">
                            <source type="image/webp" srcset="{{$record->images()['318x318']->getUrl('webp')}}">
                            <source type="image/jpeg" srcset="{{$record->images()['318x318']->getUrl()}}">
                            <img class="d-block w-100" src="{{$record->images()['318x318']->getUrl()}}"
                                 alt="{{$record->name}}" style="max-width: 50px;margin: auto;">
                        </picture>
                    </td>
                    <td class="text-right align-middle">
                        <form onsubmit="if(confirm('Delete?')){ return true }else{ return false }"
                              action="{{ route('admin.records.destroy', $record) }}" method="post">
                            @method('DELETE')
                            @csrf

                            <a class="btn btn-primary" href="{{ route('admin.records.edit', $record) }}"><i
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
                    {{ $records->links('pagination::bootstrap-4') }}
                </td>
            </tr>
            </tfoot>
        </table>

    </div>

@endsection
