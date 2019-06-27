@extends('joystick-admin.layout')

@section('content')
  <h2 class="page-header">Создание</h2>

  @include('joystick-admin.partials.alerts')

  <p class="text-right">
    <a href="/admin/cities" class="btn btn-primary btn-sm">Назад</a>
  </p>
  <form action="{{ route('cities.store') }}" method="post">
    {!! csrf_field() !!}
    <div class="form-group">
      <label for="country_id">Страны</label>
      <select id="country_id" name="country_id" class="form-control" required>
        <option value=""></option>
        @foreach($countries as $country)
          <option value="{{ $country->id }}">{{ $country->title }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="title">Название</label>
      <input type="text" class="form-control" id="title" name="title" minlength="5" maxlength="80" value="{{ (old('title')) ? old('title') : '' }}" required>
    </div>
    <div class="form-group">
      <label for="slug">Slug</label>
      <input type="text" class="form-control" id="slug" name="slug" minlength="5" maxlength="80" value="{{ (old('slug')) ? old('slug') : '' }}">
    </div>
    <div class="form-group">
      <label for="sort_id">Номер</label>
      <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : NULL }}">
    </div>
    <div class="form-group">
      <label for="lang">Язык</label>
      <select id="lang" name="lang" class="form-control" required>
        @foreach($languages as $language)
          @if (old('lang') == $language->slug)
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
        <input type="checkbox" id="status" name="status" checked> Активен
      </label>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Создать</button>
    </div>
  </form>
@endsection
