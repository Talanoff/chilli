<div class="item">
    <div class="item-id">{{ $attr->id }}</div>
    <div class="item-header row justify-content-between">
        <div class="col-sm-9 col-lg-6">
            <h3>
                <a href="{{ route('admin.'. $name .'.edit', $attr) }}"
                   class="d-inline-flex align-items-center">
                    {{ $title ?? $attr->title }}
                </a>
            </h3>
        </div>
        @isset($additional)
            <div class="col-md-auto">
                {{ $additional }}
            </div>
        @endisset
    </div>
    <div class="item-footer row justify-content-end mt-3">
        @isset($category)
            <h5 class="mb-0 col">
                <a class="link-dashed"
                   href="{{ route('admin.'. $name .'.index', ['category' => $category->id]) }}">
                    {{ $category->title }}
                </a>
            </h5>
        @endisset

        <div class="col text-right">
            <a href="{{ route('admin.'. $name .'.edit', $attr) }}"
               class="btn btn-warning btn-sm">
                <svg width="23" height="23">
                    <use xlink:href="#refresh"></use>
                </svg>
            </a>

            <a href="{{ route('admin.'. $name .'.delete', $attr) }}"
               onclick="confirmDelete({{ $attr->id }})"
               class="btn btn-danger btn-sm">
                <svg width="23" height="23" style="fill: #fff;">
                    <use xlink:href="#delete"></use>
                </svg>
            </a>
            <form action="{{ route('admin.'. $name .'.delete', $attr) }}"
                  id="delete-form-{{ $attr->id }}" method="post" style="display: none;">
                @csrf
                @method('delete')
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function confirmDelete(id) {
            event.preventDefault();

            const agree = confirm('Уверены?');

            if (agree) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    </script>
@endpush
