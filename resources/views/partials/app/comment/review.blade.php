<section class="comments mt-10">
    <h4 class="text-white text-uppercase mb-2">Отзывы</h4>

    <div class="mb-4 flex align-center">
        <span class="text-uppercase smaller">
                {{ count($review->comments) }}
            {{ count($review->comments) === 1 ? 'отзыв' : (count($review->comments) > 1 && count($review->comments) < 4 ? 'отзыва' : 'отзывов') }}
            </span>
    </div>

    @forelse($review->comments as $comment)
        <div class="comments-item">
            <div class="row">
                <div class="column">
                    <h6 class="text-uppercase text-white no-wrap">{{ $comment->user->name }}</h6>
                    {{ nl2br($comment->message) }}
                </div>
                <div class="column-auto smaller text-uppercase">
                    {{ $comment->created_at->formatLocalized('%d %B %Y') }}
                </div>
            </div>
        </div>
    @empty
        Отзывов пока нет... Будьте первым!
    @endforelse
</section>

<section class="leave-comment mt-10">
    <h4 class="text-white text-uppercase mb-2">Оставить отзыв</h4>

    <form action="{{ route('app.review.comment', $review) }}" class="w-lg-50" method="post">
        @csrf

        @guest
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <input type="text" name="name" class="form-control"
                       placeholder="Ваше имя" value="{{ old('name') }}" required>
                @if ($errors->has('name'))
                    <div class="small text-danger" role="alert">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" name="email" class="form-control"
                       placeholder="E-mail" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <div class="small text-danger" role="alert">
                        {{ $errors->first('email') }}
                    </div>
                @endif
            </div>
        @endguest

        <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                <textarea name="message" class="form-control"
                          placeholder="Сообщение" required>{{ old('message') }}</textarea>
            @if ($errors->has('message'))
                <div class="small text-danger" role="alert">
                    {{ $errors->first('message') }}
                </div>
            @endif
        </div>

        <div class="row">
            <div class="column">
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
