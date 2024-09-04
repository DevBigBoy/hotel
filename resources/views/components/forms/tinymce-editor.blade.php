@props(['name' => 'description', 'value' => ''])


<textarea id="myeditorinstance" name="{{ $name }}" @class(['is-invalid' => $errors->has($name)])>
    {{ old($name, $value) }}</textarea>

@error($name)
    <span class="text-danger">{{ $message }}</span>
@enderror
