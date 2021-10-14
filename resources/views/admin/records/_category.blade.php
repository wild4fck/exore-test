@foreach ($categories as $category)

    <option value="{{ $category->id ?? "" }}"

            @isset($record->id)

            @if ( $record->category->id === $category->id )
            selected="selected"
        @endif

        @endisset
    >
        {!! $delimiter ?? '' !!}{{ $category->name ?? '' }}
    </option>

@endforeach
