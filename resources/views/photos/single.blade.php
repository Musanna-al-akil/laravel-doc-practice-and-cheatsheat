@extends('layouts.guestLayout')

@section('title','View Photos')
@push('css')
@Vite('resources/css/app.css')
@endpush
@section('content')

    <div class="grid grid-cols-3  gap-4 mt-8">
 
           <h1>{{$photo->id}}</h1>
    <div>
@endsection