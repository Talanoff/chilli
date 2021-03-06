<div class="review-item-wrapper">
    <a href="{{ route('app.review.show', $review) }}" class="review-item">
        <figure class="lozad"
                style="background-image: url({{ $review->large_image }})"></figure>

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
