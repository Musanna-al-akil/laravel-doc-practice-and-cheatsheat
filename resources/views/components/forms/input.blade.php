<!-- 8.7.8 Default / Merged Attributes -->
<div  {{ $attributes->merge(['class'=>'font-bold']) }} >
    <!-- 8.7.4 passing data -->
    {{$prependSlot}}
    <label for="{{$name}}">{{$labelName}} : </label>
    <input id="{{$name}}" type="{{$type}}" class="@error($name) is-invalid @enderror">
    @error($name)
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    
    {{$slot}}
</div>