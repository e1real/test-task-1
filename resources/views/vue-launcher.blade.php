@extends('layouts.app')

@section('content')
    <div id="vue-app">
        <{{ $pageComponent }}
            @foreach($props as $key => $prop)
                :{{ $key }}="{{ $prop }}"
            @endforeach
        />
    </div>
@endsection
