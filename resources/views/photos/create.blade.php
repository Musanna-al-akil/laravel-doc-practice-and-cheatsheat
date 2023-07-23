@extends('layouts.guestLayout')

@section('title','create photo')
@push('css')
@Vite('resources/css/app.css')
@endpush

@section('content')

    <div class="text-medium text-green-800">hello</div>
    <!-- 8.7.3 rendering component && 8.7.7 $attributes -->
    <x-forms.input name="name" type="text" labelName="Name" class="text-medium text-green-800" data="nothing">
        <x-slot:prependSlot></x-slot:prependSlot>
    </x-forms.input>

@endsection