@if(!isset($hide_title))
    <hr class="mt-4 mb-3">
    <h5>Meta информация</h5>
@endif

<div class="form-group">
    <label for="meta-title">Заголовок</label>
    <input type="text" name="meta[title]" id="meta-title" class="form-control"
           value="{{ old('meta.title') ?? isset($meta) ? $meta->title : null }}">
</div>

<div class="form-group">
    <label for="meta-description">Описание</label>
    <input type="text" name="meta[description]" id="meta-description" class="form-control"
           value="{{ old('meta.description') ?? isset($meta) ? $meta->description : null }}">
</div>

<div class="form-group">
    <label for="meta-keywords">Ключевые слова</label>
    <input type="text" name="meta[keywords]" id="meta-keywords" class="form-control"
           value="{{ old('meta.keywords') ?? isset($meta) ? $meta->keywords : null }}">
</div>
