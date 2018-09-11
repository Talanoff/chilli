@if (count($recommended))
    <section class="recommended mt-10">
        <h4 class="text-white text-uppercase mb-2">Возможно вам будет интересно</h4>

        <div class="products flex">
            @foreach($recommended as $product)
                @include('partials.app.product.single', ['default' => true])
            @endforeach
        </div>
    </section>
@endif
