@php
    $classes = 'w-lg-1/3';

    if (request()->get('page') < 2) {
    $classes = $large ? 'w-lg-2/3' : ($loop->index > 0 && $loop->index < 3 ? 'w-lg-1 h-50' : 'w-lg-1/3');
    }
@endphp

<div class="review-item-wrapper w-md-1/2 {{ $classes }}">
    <a href="{{ route('app.review.show', $review) }}" class="review-item">
        <figure class="lozad"
                data-background-image="{{ $loop->index === 0 ? $review->large_image : $review->thumbnail }}"></figure>

        <div class="review-item__title">
            <p class="small text-primary text-uppercase mb-1">
                {{ App\Models\Review\Review::$CATEGORIES[$review->type] }}
            </p>
            <h6 class="text-uppercase text-white">
                {{ $review->title }}
            </h6>
        </div>

        @if ($review->type === 'video')
            <span class="review-item__play">
                <svg width="26" height="26">
                    <use xlink:href="#play"></use>
                </svg>
            </span>
        @endif
    </a>
</div>
