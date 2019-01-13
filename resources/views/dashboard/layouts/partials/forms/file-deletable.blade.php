<div class="form-group">
    <label class="m-b-0 {{ isset($required) && $required ? 'required' : '' }}">{{ $label or 'Файл' }}</label>
    <span class="help">{!! $help or 'jpeg или png; менее, чем 50 МБ' !!}</span><br />
    @if(isset($entity) && $entity->{(isset($attribute) ? $attribute : $name)})
        <a href="{{ $entity->{(isset($attribute) ? $attribute : $name)} }}" target="_blank" class="m-b-5" download>Загруженный файл</a>
        @if(isset($entity) && $entity->{(isset($attribute) ? $attribute : $name)})
            <div class="checkbox check-warning m-t-0 m-b-5">
                <input name="remove_{{ $name }}" id="remove{{ studly_case($name) }}" {{ old('remove_'.$name) == 1 ? 'checked=checked' : '' }} class="remove-file-checkbox" type="checkbox" value="1">
                <label for="remove{{ studly_case($name) }}" class="fs-10">Удалить файл</label>
            </div>
        @endif
    @endif
    <input name="{{ $name }}" type="file" class="file-input {{ old('remove_'.$name) == 1 ? 'disabled' : '' }}" title="{{ isset($entity) && $entity->{(isset($attribute) ? $attribute : $name)} ? 'Заменить' : 'Выбрать' }}" />
</div>
