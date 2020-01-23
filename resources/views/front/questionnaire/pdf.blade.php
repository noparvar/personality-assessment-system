<style type="text/css">
    body {
        direction: rtl;
        font-family: 'iransans';
        text-align: right
        padding: 0;
        margin: 0;
    }
    @page {
        header: page-header;
        footer: page-footer;
    }

    .page-header {
        text-align: left;
        direction: ltr;
    }
    .page-header img {
        text-align: left;
        direction: ltr;
    }
</style>
<body>
<htmlpageheader name="page-header">
    <div class="page-header">
        <img src="/images/logo-1.png">
    </div>
</htmlpageheader>

<htmlpagefooter name="page-footer">
    <div class="page-header">
        <a href="https://maliraftari.com/">www.maliraftari.com</a>
    </div>
</htmlpagefooter>

    <div style="direction: rtl;text-align: right">
        {{--<img src="{{ $user->avatar_url }}" alt="">--}}
        <h1>{{ $user->name }}</h1>
        <h2>تیپ شخصیتی شما: {{ $personTypes->type }}</h2>
        <br>
        <br>
        @foreach(config('questionnaire.person_type_details') as $key => $detailItem)
            @if(! empty($details[$key]))
                <h3>{{ $detailItem }}</h3>
                <p>{!! $details[$key] !!}</p>
            @endif
        @endforeach
    </div>
</body>
