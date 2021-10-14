@extends('layouts.app')

@section('content')

    <div class="container">

        @include('admin.components.breadcrumb', [
              'title' => 'Viewing a recording ',
              'parents' => [
                  route('admin.dashboard') => 'Admin',
                  route('admin.records.index') => 'Records',
              ],
              'active' => $record->name,
          ])

        <hr/>

        <div class="shadow card">
            <div class="card-header">
                <h1>{{ $record->name }}</h1>
            </div>
            <div class="card-body row">
                <div class="col">
                    <picture class="w-100">
                        <source type="image/webp" srcset="{{$record->images()['318x318']->getUrl('webp')}}">
                        <source type="image/jpeg" srcset="{{$record->images()['318x318']->getUrl()}}">
                        <img class="d-block w-100" src="{{$record->images()['318x318']->getUrl()}}"
                             alt="{{$record->name}}" style="max-width: 318px;margin: auto;">
                    </picture>
                </div>
                <div class="col">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span>Category: </span><span><a
                                    href="{{ route('admin.records.byCategory', $record->category) }}">{{ $record->category->name }}</a></span>
                        </li>
                        <li class="list-group-item">
                            <span>Author: </span><span><a
                                    href="{{ route('admin.records.byAuthor', $record->author) }}">{{ $record->author->name }}</a></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

@endsection
