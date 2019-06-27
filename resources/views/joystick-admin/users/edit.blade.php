@extends('joystick-admin.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('joystick-admin.partials.alerts')

  <p class="text-right">
    <a href="/admin/users" class="btn btn-primary btn-sm">Назад</a>
  </p>
  <form action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
    <input name="_method" type="hidden" value="PUT">
    {!! csrf_field() !!}
    <div class="form-group">
      <label for="name">Имя:</label>
      <input type="text" class="form-control" name="name" id="name" minlength="2" maxlength="60" value="{{ $user->name }}" required>
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" name="email" id="email" minlength="8" maxlength="60" value="{{ $user->email }}" required>
    </div>
    <div class="form-group">
      <label for="roles_id">Роли:</label>
      <select class="form-control" name="roles_id[]" id="roles_id" multiple required>
        <option value=""></option>
        @foreach($roles as $role)
          @if ($user->roles->contains($role->id)))
            <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
          @else
            <option value="{{ $role->id }}">{{ $role->name }}</option>
          @endif
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Изменить</button>
    </div>
  </form>
@endsection
