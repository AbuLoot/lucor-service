@extends('joystick-admin.layout')

@section('content')

  <h2 class="page-header">Роли</h2>

  @include('joystick-admin.partials.alerts')

  <p class="text-right">
    <a href="/admin/roles/create" class="btn btn-success btn-sm">Добавить</a>
  </p>
  <div class="table-responsive">
    <table class="table-admin table table-striped table-condensed">
      <thead>
        <tr class="active">
          <td>№</td>
          <td>Название</td>
          <td>Метка</td>
          <td class="text-right">Функции</td>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @forelse ($roles as $role)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $role->name }}</td>
            <td>{{ $role->display_name }}</td>
            <td class="text-right">
              <a class="btn btn-link btn-xs" href="{{ route('roles.edit', $role->id) }}" title="Редактировать"><i class="material-icons md-18">mode_edit</i></a>
              <form method="POST" action="{{ route('roles.destroy', $role->id) }}" accept-charset="UTF-8" class="btn-delete">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-link btn-xs" onclick="return confirm('Удалить запись?')"><i class="material-icons md-18">clear</i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="4">Нет записи</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

@endsection