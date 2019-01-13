<div class="form-group form-group-default {{ isset($required) && $required ? 'required' : '' }}">
    <label>
        {!! $title ?? '' !!}
        @if(isset($lang))
            @include('dashboard.layouts.partials.'.$lang.'-label')
        @endif
    </label>
    <textarea name="{{ $name ?? '' }}" class="form-control {{ isset($editor) && $editor ? 'redactor' : '' }}" placeholder="{{ $placeholder ?? '' }}" {{ isset($required) && $required ? 'required' : '' }}>{!! $value ?? '' !!}</textarea>
</div>
