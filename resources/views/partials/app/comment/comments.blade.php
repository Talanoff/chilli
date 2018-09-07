<section class="comments mt-10">
    <h4 class="text-white text-uppercase mb-2">Отзывы</h4>

    <div class="mb-4 flex align-center">
        @include('partials.app.product.stars', ['stars' => $product->stars])
        <span class="text-uppercase smaller">
                {{ count($product->comments) }}
            {{ count($product->comments) === 1 ? 'отзыв' : count($product->comments) > 1 && count($product->comments) < 4 ? 'отзыва' : 'отзывов' }}
            </span>
    </div>

    @forelse($product->comments as $comment)
        <div class="comments-item">
            <div class="row">
                <div class="column">
                    <h6 class="text-uppercase text-white no-wrap">{{ $comment->user->name }}</h6>
                    {{ nl2br($comment->message) }}
                </div>
                <div class="column-auto smaller text-uppercase">
                    {{ $comment->created_at->formatLocalized('%d %B %Y') }}
                    <div class="mt-2">
                        @include('partials.app.product.stars', ['stars' => $comment->user->productRating($product)])
                    </div>
                </div>
            </div>
        </div>
    @empty
        Отзывов пока нет... Будьте первым!
    @endforelse
</section>

<section class="leave-comment mt-10">
    <h4 class="text-white text-uppercase mb-2">Оставить отзыв</h4>

    <form action="{{ route('app.product.comment', $product) }}" class="w-lg-50" method="post">
        @csrf

        @guest
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <input type="text" name="name" class="form-control"
                       placeholder="Ваше имя" value="{{ old('name') }}" required>
                <div class="small text-danger">
                    {{ $errors->has('name') ? $errors->get('name')[0] : '' }}
                </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" name="email" class="form-control"
                       placeholder="E-mail" value="{{ old('email') }}" required>
                <div class="small text-danger">
                    {{ $errors->has('email') ? $errors->get('email')[0] : '' }}
                </div>
            </div>
        @endguest

        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                <textarea name="message" class="form-control"
                          placeholder="Сообщение" required>{{ old('message') }}</textarea>
            <div class="small text-danger">
                {{ $errors->has('message') ? $errors->get('message')[0] : '' }}
            </div>
        </div>

        <div class="row">
            <div class="column">
                <star-rating old="{{ old('rating') }}"></star-rating>

                <label class="small flex">
                    <input type="checkbox" name="confirmation" checked required>
                    <span class="ml-1">Отправляя отзыв, вы соглашаетесь с правилами модерации</span>
                </label>
            </div>
            <div class="column-auto">
                <button class="btn btn-primary">
                    Оставить отзыв
                </button>
            </div>
        </div>
    </form>
</section>
