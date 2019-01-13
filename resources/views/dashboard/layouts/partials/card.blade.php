<div class="card card-default">
    @if(isset($cardTitle) || isset($cardAfterTitle))
        <div class="card-header">

            @if(isset($cardTitle))
                <div class="card-title">{!! $cardTitle !!}</div>
            @endif

            @if(isset($cardAfterTitle))
                {!! $cardAfterTitle !!}
            @endif

            <div class="clearfix"></div>
        </div>
    @endif
    <div class="card-block">

        {!! $slot !!}

    </div>
</div>
