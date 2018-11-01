@if(isset($meta))
    @if ($meta->title)
        <meta name="title" content="{{ $meta->title }}">
        <meta property="og:title" content="{{ $meta->title }}">
    @endif
    @if ($meta->description)
        <meta name="description" content="{{ $meta->description }}">
        <meta property="og:description" content="{{ $meta->description }}">
    @endif
    @if ($meta->keywords)
        <meta name="keywords" content="{{ $meta->keywords }}">
    @endif
@else
    <meta name="title" content="{{ config('app.name', 'Chilli') . (isset($app_title) ? ' | ' . $app_title : '') }}">
    <meta property="og:title"
          content="{{ config('app.name', 'Chilli') . (isset($app_title) ? ' | ' . $app_title : '') }}">
@endif

    <meta property="og:image" content="{{ $image ?? asset('images/favicons/android-chrome-512x512.png') }}">
    <meta property="og:image:width" content="279">
    <meta property="og:image:height" content="279">
    <meta property="og:url" content="{{ url()->current() }}">
