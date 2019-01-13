<div class="form-group">
    <label class="{{ isset($required) && $required ? 'required' : '' }}">{{ $label or 'Изображение' }}</label>
    <span class="help">{!! $help or 'jpeg или png; менее, чем 10 МБ' !!}</span><br />
    <img class="image-preview" src="{{ isset($entity) ? cloud_image($entity->{(isset($attribute) ? $attribute : $name)}, 600, 400) : dashboard_placeholder_image(600, 400) }}" data-placeholder="{{ dashboard_placeholder_image(600, 400) }}" />
    <input name="{{ $name }}" type="file" class="file-input image-input" />
</div>