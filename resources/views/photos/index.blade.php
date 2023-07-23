@extends('layouts.guestLayout')

@section('title','View Photos')
@push('css')
@Vite('resources/css/app.css')
@endpush
@section('content')

    <div class="grid grid-cols-3  gap-4 mt-8">
        @foreach ($data as $photo)
            <a href="{{route('photos.show',$photo->id)}}" class="w-full bg-white rounded-xl  shadow-gray-800 ">
                <div>
                    <img class="rounded-t-xl" src="images/{{$photo->photo}}">
                    <h1>{{$photo->name}}</h1>
                </div>
            </a>            
        @endforeach 
    <div>
@endsection