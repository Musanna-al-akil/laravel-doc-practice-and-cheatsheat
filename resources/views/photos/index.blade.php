@extends('layouts.guestLayout')

@section('title','View Photos')
@push('css')
@Vite('resources/css/app.css')
@endpush
@section('content')

    <div class="text-purple-800">hello</div>
    @disk('local')
    this using local
    @elsedisk('s3')
    this using s3
    @enddisk

@endsection