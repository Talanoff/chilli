@if ($errors->any())
    <div class="alert alert-danger notification">
        {!! count($errors) > 1 ? '<ol class="mb-0 pl-3">' : '<ul class="mb-0 pl-3 list-unstyled">' !!}
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        {!! count($errors) > 1 ? '</ol>' : '</ul>' !!}
    </div>
@endif
