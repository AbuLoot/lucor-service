@extends('joystick-admin.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('joystick-admin.partials.alerts')

  <p class="text-right">
    <a href="/admin/news" class="btn btn-primary btn-sm">Назад</a>
  </p>
  <form action="{{ route('news.update', $news->id) }}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    {!! csrf_field() !!}

    <div class="form-group">
      <label for="title">Название</label>
      <input type="text" class="form-control" id="title" name="title" minlength="2" maxlength="80" value="{{ (old('title')) ? old('title') : $news->title }}" required>
    </div>
    <div class="form-group">
      <label for="slug">URI</label>
      <input type="text" class="form-control" id="slug" name="slug" minlength="2" maxlength="80" value="{{ (old('slug')) ? old('slug') : $news->slug }}">
    </div>
    <div class="form-group">
      <label for="page_id">Категории</label>
      <select id="page_id" name="page_id" class="form-control">
        <option value="NULL"></option>
        <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $news) { ?>
          <?php foreach ($nodes as $node) : ?>
            <?php if ($node->id == $news->page_id) : ?>
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
      <label for="headline">Заголовок</label>
      <input type="text" class="form-control" id="headline" name="headline" minlength="2" maxlength="500" value="{{ (old('headline')) ? old('headline') : $news->headline }}">
    </div>
    <div class="form-group">
      <label for="video">Код видео</label>
      <input type="text" class="form-control" id="video" name="video" minlength="2" maxlength="500" value="{{ (old('video')) ? old('video') : $news->video }}">
    </div>
    <div class="form-group">
      <label for="sort_id">Номер</label>
      <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : $news->sort_id }}">
    </div>
    <div class="form-group">
      <label for="image">Картинка</label><br>
      <div class="fileinput fileinput-new" data-provides="fileinput">
        <div class="fileinput-new thumbnail" style="width:100%;height:auto;">
          <img src="/img/news/{{ $news->image }}">
        </div>
        <div class="fileinput-preview fileinput-exists thumbnail" style="width:100%;height:auto;"></div>
        <div>
          <span class="btn btn-default btn-sm btn-file">
            <span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Выбрать</span>
            <span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>
            <input type="file" name="image" accept="image/*">
          </span>
          <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label for="title_description">Мета название</label>
      <input type="text" class="form-control" id="title_description" name="title_description" maxlength="255" value="{{ (old('title_description')) ? old('title_description') : $news->title_description }}">
    </div>
    <div class="form-group">
      <label for="meta_description">Мета описание</label>
      <input type="text" class="form-control" id="meta_description" name="meta_description" maxlength="255" value="{{ (old('meta_description')) ? old('meta_description') : $news->meta_description }}">
    </div>
    <div class="form-group">
      <label for="content">Контент</label>
      <textarea class="form-control" id="content" name="content" rows="5">{{ (old('content')) ? old('content') : $news->content }}</textarea>
    </div>
    <div class="form-group">
      <label for="lang">Язык</label>
      <select id="lang" name="lang" class="form-control" required>
        <option value=""></option>
        @foreach($languages as $language)
          @if ($news->lang == $language->slug)
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
        <input type="checkbox" id="status" name="status" @if ($news->status == 1) checked @endif> Активен
      </label>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Изменить</button>
    </div>
  </form>
@endsection

@section('head')
  <link href="/joystick/css/jasny-bootstrap.min.css" rel="stylesheet">
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
      // content_css: '//www.tinymce.com/css/codepen.min.css',
      image_advtab: true ,
   
      external_filemanager_path:"/responsive_filemanager/filemanager/",
      filemanager_title:"Responsive Filemanager" ,
      external_plugins: { "filemanager" : "/responsive_filemanager/filemanager/plugin.min.js"}
    });
  </script>
@endsection

@section('scripts')
  <script src="/joystick/js/jasny-bootstrap.js"></script>
@endsection

