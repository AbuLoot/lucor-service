@extends('admin.layout')

@section('content')
  <h1 class="page-header">Редактирование</h1>

  @include('joystick-admin.partials.alerts')
  <p class="text-right">
    <a href="/admin/section" class="btn btn-primary btn-sm">Назад</a>
  </p>
  <form action="{{ route('section.update', $section->id) }}" method="post">
    <input type="hidden" name="_method" value="PUT">
    {!! csrf_field() !!}

    <div class="form-group">
      <label for="title">Заголовок сервиса</label>
      <input type="text" class="form-control" id="title" name="title" minlength="2" maxlength="80" value="{{ (old('title')) ? old('title') : $section->title }}" required>
    </div>
    <div class="form-group">
      <label for="slug">Slug</label>
      <input type="text" class="form-control" id="slug" name="slug" minlength="2" maxlength="80" value="{{ (old('slug')) ? old('slug') : $section->slug }}">
    </div>
    <div class="form-group">
      <label for="sort_id">Номер</label>
      <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : $section->sort_id }}">
    </div>
    <div class="form-group">
      <label for="icon">Иконка (вставляйте название иконок из <a target="_blank" href="http://fontawesome.io/icons/">www.fontawesome.io/icons</a>)</label>
      <input type="text" class="form-control" id="title_description" name="title_description" maxlength="255" value="{{ (old('title_description')) ? old('title_description') : $section->title_description }}">
    </div>
    <!-- <div class="form-group">
      <label for="meta_description">Мета описание</label>
      <input type="text" class="form-control" id="meta_description" name="meta_description" maxlength="255" value="{{ (old('meta_description')) ? old('meta_description') : $section->meta_description }}">
    </div> -->
    <div class="form-group">
      <label for="content">Текст</label>
      <textarea class="form-control" id="content" name="content" rows="3" maxlength="2000">{{ (old('content')) ? old('content') : $section->content }}</textarea>
    </div>
    <div class="form-group">
      <label for="lang">Язык</label>
      <select id="lang" name="lang" class="form-control" required>
        <option value=""></option>
        @foreach($languages as $language)
          @if ($section->lang == $language->slug)
            <option value="{{ $language->slug }}" selected>{{ $language->title }}</option>
          @else
            <option value="{{ $language->slug }}">{{ $language->title }}</option>
          @endif
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="status">Статус</label>
      <label>
        @if ($section->status == 1)
          <input type="checkbox" id="status" name="status" checked> Активен
        @else
          <input type="checkbox" id="status" name="status"> Активен
        @endif
      </label>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Обновить</button>
    </div>
  </form>
@endsection

@section('exception')
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