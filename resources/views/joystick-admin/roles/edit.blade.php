@extends('joystick-admin.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('joystick-admin.partials.alerts')

  <p class="text-right">
    <a href="/admin/roles" class="btn btn-primary btn-sm">Назад</a>
  </p>
  <form action="{{ route('roles.update', $role->id) }}" method="post">
    <input type="hidden" name="_method" value="PUT">
    {!! csrf_field() !!}

    <div class="form-group">
      <label for="name">Название</label>
      <input type="text" class="form-control" id="name" name="name" maxlength="80" value="{{ (old('name')) ? old('name') : $role->name }}" required>
    </div>
    <div class="form-group">
      <label for="display_name">Метка</label>
      <input type="text" class="form-control" id="display_name" name="display_name" maxlength="80" value="{{ (old('display_name')) ? old('display_name') : $role->display_name }}">
    </div>
    <div class="form-group">
      <label for="description">Описание</label>
      <input type="text" class="form-control" id="description" name="description" maxlength="80" value="{{ (old('description')) ? old('description') : $role->description }}">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Изменить</button>
    </div>
  </form>
@endsection
