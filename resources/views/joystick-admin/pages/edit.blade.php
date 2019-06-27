@extends('joystick-admin.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('joystick-admin.partials.alerts')

  <p class="text-right">
    <a href="/admin/pages" class="btn btn-primary btn-sm">Назад</a>
  </p>
  <form action="{{ route('pages.update', $page->id) }}" method="post">
    <input type="hidden" name="_method" value="PUT">
    {!! csrf_field() !!}

    <div class="form-group">
      <label for="title">Название</label>
      <input type="text" class="form-control" id="title" name="title" minlength="2" maxlength="80" value="{{ (old('title')) ? old('title') : $page->title }}" required>
    </div>
    <div class="form-group">
      <label for="slug">Slug</label>
      <input type="text" class="form-control" id="slug" name="slug" maxlength="80" value="{{ (old('slug')) ? old('slug') : $page->slug }}">
    </div>
    <div class="form-group">
      <label for="page_id">Категории</label>
      <select id="page_id" name="page_id" class="form-control">
        <option value="NULL"></option>
        <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $page) { ?>
          <?php foreach ($nodes as $node) : ?>
            <?php if ($node->id == $page->parent_id) : ?>
              <option value="{{ $node->id }}" selected>{{ PHP_EOL.$prefix.' '.$node->title }}</option>
            <?php else : ?>
              <option value="{{ $node->id }}">{{ PHP_EOL.$prefix.' '.$node->title }}</option>
            <?php endif; ?>
            <?php $traverse($node->children, $prefix.'___'); ?>
          <?php endforeach; ?>
        <?php }; ?>
        <?php $traverse($pages); ?>
      </select>
    </div>
    <div class="form-group">
      <label for="icon">Icon</label>
      <input type="text" class="form-control" id="icon" name="icon" maxlength="80" value="{{ (old('icon')) ? old('icon') : $page->icon }}">
    </div>
    <div class="form-group">
      <label for="sort_id">Номер</label>
      <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : $page->sort_id }}">
    </div>
    <div class="form-group">
      <label for="title_description">Мета название</label>
      <input type="text" class="form-control" id="title_description" name="title_description" maxlength="255" value="{{ (old('title_description')) ? old('title_description') : $page->title_description }}">
    </div>
    <div class="form-group">
      <label for="meta_description">Мета описание</label>
      <input type="text" class="form-control" id="meta_description" name="meta_description" maxlength="255" value="{{ (old('meta_description')) ? old('meta_description') : $page->meta_description }}">
    </div>
    <div class="form-group">
      <label for="content">Контент</label>
      <textarea class="form-control" id="content" name="content" rows="5">{{ (old('content')) ? old('content') : $page->content }}</textarea>
    </div>
    <div class="form-group">
      <label for="lang">Язык</label>
      <select id="lang" name="lang" class="form-control" required>
        <option value=""></option>
        @foreach($languages as $language)
          @if ($page->lang == $language->slug)
            <option value="{{ $language->slug }}" selected>{{ $language->title }}</option>
          @else
            <option value="{{ $language->slug }}">{{ $language->title }}</option>
          @endif
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="status">Статус:</label>
      <label>
        <input type="checkbox" id="status" name="status" @if ($page->status == 1) checked @endif> Активен
      </label>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Изменить</button>
    </div>
  </form>
@endsection

@section('head')
  <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
  <script>
    tinymce.init({
      selector: 'textarea',
      height: 300,
      menubar: false,
      plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table contextmenu paste code'
      ],
      toolbar: 'code undo redo | table insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
      // content_css: '//www.tinymce.com/css/codepen.min.css'
    });
  </script>
@endsection