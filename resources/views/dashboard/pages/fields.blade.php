@php /** @var \App\Models\Page $item */ @endphp

<script src="{{ asset('assets/dashboard/js/summernote.js') }}" type="text/javascript" charset="utf-8" ></script>
<script rel="stylesheet" src="{{ asset('assets/dashboard/css/summernote.css') }}" type="text/css" charset="utf-8" ></script>

<div class="row">
    <div class="col-md-7">
        <div class="card card-default">
            <div class="card-header">
                <div class="card-title">Данные</div>
            </div>
            <div class="card-block">
                @include('dashboard.layouts.partials.forms.text', [
                    'title' => 'Index',
                    'name' => 'page_name',
                    'value' => old('page_name', isset($item) ? $item->page_name : ''),
                    'placeholder' => 'Введите page_name страницы.'
                ])
            </div>
            <div class="card-block">
                @include('dashboard.layouts.partials.forms.text', [
                    'title' => 'Title',
                    'name' => 'title',
                    'required' => true,
                    'value' => old('title', isset($item) ? $item->title : ''),
                    'placeholder' => 'Введите заголовок страницы.'
                ])
            </div>
        </div>
    </div>
    <div>
        <div class="card card-default">
            <div class="card-block">
                @include('dashboard.layouts.partials.forms.textarea', [
                    'title' => 'Content',
                    'name' => 'content',
                    'required' => true,
                    'value' => old('content', isset($item) ? $item->content : ''),
                    'placeholder' => 'Введите содержимое страницы.'
                ])
            </div>
        </div>
    </div>
</div>
