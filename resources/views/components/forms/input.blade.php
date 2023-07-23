<!-- 8.7.8 Default / Merged Attributes -->
<div  {{ $attributes->merge(['class'=>'font-medium ']) }} >
    <!-- 8.7.4 passing data -->
    <label for="{{$name}}" class="block">{{$labelName}} : </label>

    <input id="{{$name}}"  name="{{$name}}" type="{{$type}}" value="{{ $type == 'checkbox' ? 1 :old($name)}}{{isset($value) ? $value :' '}}" class="mt-1 bg-gray-50 p-1  rounded-md    @error($name) outline-red-300 @else outline-slate-400 @enderror {{$type == 'checkbox' || $type == 'file' ? '': 'focus:outline-sky-300 w-64 outline outline-2 '}}" {{ old($name) ? 'checked="checked"' : ''}}>
    
    <!--12.2 display validation errors -->
    @error($name)
    <span class="block text-red-500 font-normal mt-1">{{ $message }}</span>
    @enderror
    
    {{$slot}}
</div>