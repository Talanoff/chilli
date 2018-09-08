@isset ($stars)
    <div class="product-item__stars mr-3">
        @for($i = 0; $i <= 5; $i++)
            <svg width="12" height="12" class="{{ $i <= $stars ? 'is-filled' : '' }}">
                <use xlink:href="#star"></use>
            </svg>
        @endfor
    </div>
@endif
