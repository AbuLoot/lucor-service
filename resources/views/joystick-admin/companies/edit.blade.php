@extends('joystick-admin.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('joystick-admin.partials.alerts')

  <p class="text-right">
    <a href="/admin/companies" class="btn btn-primary btn-sm">Назад</a>
  </p>
  <form action="{{ route('companies.update', $company->id) }}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    {!! csrf_field() !!}

    <div class="form-group">
      <label for="title">Название</label>
      <input type="text" class="form-control" id="title" name="title" minlength="2" maxlength="80" value="{{ (old('title')) ? old('title') : $company->title }}" required>
    </div>
    <div class="form-group">
      <label for="slug">Slug</label>
      <input type="text" class="form-control" id="slug" name="slug" minlength="2" maxlength="80" value="{{ (old('slug')) ? old('slug') : $company->slug }}">
    </div>
    <div class="form-group">
      <label for="sort_id">Номер</label>
      <input type="text" class="form-control" id="sort_id" name="sort_id" value="{{ (old('sort_id')) ? old('sort_id') : $company->sort_id }}">
    </div>
    <div class="form-group">
      <label for="country_id">Страны</label>
      <select id="country_id" name="country_id" class="form-control">
        <option value=""></option>
        @foreach($countries as $country)
          @if ($country->id == $company->country_id)
            <option value="{{ $country->id }}" selected>{{ $country->title }}</option>
          @else
            <option value="{{ $country->id }}">{{ $country->title }}</option>
          @endif
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="address">Адрес</label>
      <input type="text" class="form-control" id="address" name="address" value="{{ (old('address')) ? old('address') : $company->address }}">
    </div>
    <div class="form-group">
      <label for="image">Логотип</label><br>
      <div class="fileinput fileinput-new" data-provides="fileinput">
        <div class="fileinput-new thumbnail" style="width:300px;height:200px;">
          <img src="/img/companies/{{ $company->logo }}">
        </div>
        <div class="fileinput-preview fileinput-exists thumbnail" style="width:300px;height:200px;"></div>
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
      <label for="about">О компании</label>
      <textarea class="form-control" id="about" name="about" rows="5">{{ (old('about')) ? old('about') : $company->about }}</textarea>
    </div>
    <div class="form-group">
      <label for="phones">Номера телефонов</label>
      <input type="text" class="form-control" id="phones" name="phones" value="{{ (old('phones')) ? old('phones') : $company->phones }}">
    </div>
    <div class="form-group">
      <label for="website">Website</label>
      <input type="text" class="form-control" id="website" name="website" value="{{ (old('website')) ? old('website') : $company->website }}">
    </div>
    <div class="form-group">
      <label for="emails">Emails</label>
      <input type="text" class="form-control" id="emails" name="emails" value="{{ (old('emails')) ? old('emails') : $company->emails }}">
    </div>
    <div class="form-group">
      <label for="lang">Язык</label>
      <select id="lang" name="lang" class="form-control">
        <option value=""></option>
        @foreach($languages as $language)
          @if ($company->lang == $language->slug)
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
        <input type="checkbox" id="status" name="status" @if ($company->status == 1) checked @endif> Активен
      </label>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Изменить</button>
    </div>
  </form>
@endsection

@section('head')
  <link href="/joystick/css/jasny-bootstrap.min.css" rel="stylesheet">
@endsection

@section('scripts')
  <script src="/joystick/js/jasny-bootstrap.js"></script>
@endsection

