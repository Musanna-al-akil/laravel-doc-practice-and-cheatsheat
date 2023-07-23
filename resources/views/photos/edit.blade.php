@extends('layouts.guestLayout')

@section('title','create photo')

@push('css')
    @Vite('resources/css/app.css')
@endpush

@section('content')

<div class="flex">
    <div class=" bg-white rounded-xl py-12 px-20 mx-auto my-12 shadow-gray-800 mt-8">
        <form action="{{route('photos.update',$photo->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <!-- 8.7.3 rendering component && 8.7.7 $attributes -->
            <x-forms.input name="name" type="text" labelName="Name" :value="$photo->name" class=" text-black">
            </x-forms.input>
            <x-forms.input name="email" type="text" :value="$photo->email" labelName="Email" class=" text-black mt-4">
            </x-forms.input>
            <x-forms.input name="username" type="text" :value="$photo->username" labelName="Username" class=" text-black mt-4">
            </x-forms.input>
            <x-forms.input name="number" type="text" labelName="Phone number" :value="$photo->number" class=" text-black mt-4">
            </x-forms.input>
            <x-forms.input name="age" type="number" :value="$photo->age" labelName="Age" class=" text-black mt-4">
            </x-forms.input>
            <x-forms.input name="show_data" type="checkbox"  labelName="Data active" class=" text-black mt-4">
            </x-forms.input>
            <x-forms.input name="image" type="file" labelName="Photo" class=" text-black mt-4">
            </x-forms.input>

            <button class="bg-indigo-500 text-white font-bold py-2 px-4 rounded mt-4" type="submit">Submit</button>
        </form>
        <img id="preview" src="#" width="200"  alt="your image" class="mt-3" style="display:none;"/>
    </div>
<div>

@endsection
@push('scripts')
<script>
    image.onchange = evt => {
        preview = document.getElementById('preview');
        preview.style.display = 'block';
        const [file] = image.files
        if (file) {
            preview.src = URL.createObjectURL(file)
        }
    }
</script>
@endpush