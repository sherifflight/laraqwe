<div class="form-group form-group-default {{ isset($required) && $required ? 'required' : '' }}">
    <label>
        {!! $title ?? '' !!}
        @if(isset($lang))
            @include('dashboard.layouts.partials.'.$lang.'-label')
        @endif
    </label>
    <input name="{{ $name ?? '' }}" value="{{ $value ?? '' }}" type="password" class="form-control" placeholder="{{ $placeholder ?? '' }}" {{ isset($required) && $required ? 'required' : '' }} />
</div>
