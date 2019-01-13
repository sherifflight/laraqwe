<div class="form-group form-group-default {{ $class ?? '' }} form-group-default-select2 {{ isset($required) && $required ? 'required' : '' }}">
    <label>{!! $title ?? '' !!}</label>
    <select {{ isset($id) ? 'id=' . $id : '' }} title="{!! $title ?? '' !!}" name="{{ $name ?? '' }}" class="full-width" data-init-plugin="select2" data-placeholder="{{ $placeholer ?? '' }}" {{ isset($required) && $required ? 'required' : '' }}>
        @if(isset($optionsRaw))
            {!! $optionsRaw !!}
        @elseif(isset($options) && is_array($options))
            @foreach($options as $optValue => $optName)
                <option value="{{ $optValue }}" {{ (isset($selected) ? $selected : '') == $optValue ? 'selected' : '' }}>{{ $optName }}</option>
            @endforeach
        @endif
    </select>
</div>
@if(isset($note))
    <div class="fs-11 hint-text p-l-15 m-b-10" style="margin-top: -8px;">{!! $note !!}</div>
@endif
