@isset($meta)
    @if ($meta->title)
        <meta name="title" content="{{ $meta->title }}">
        <meta name="og:title" content="{{ $meta->title }}">
        <meta name="og:image" content="{{ $image ?? asset('images/logo.png') }}">
    @endif
    @if ($meta->description)
        <meta name="description" content="{{ $meta->description }}">
        <meta name="og:description" content="{{ $meta->description }}">
    @endif
    @if ($meta->keywords)
        <meta name="keywords" content="{{ $meta->keywords }}">
    @endif
@endisset
