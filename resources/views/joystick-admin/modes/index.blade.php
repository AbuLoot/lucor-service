@extends('joystick-admin.layout')

@section('content')

  <h2 class="page-header">Режимы</h2>

  @include('joystick-admin.partials.alerts')
  <p class="text-right">
    <a href="/admin/modes/create" class="btn btn-success btn-sm">Добавить</a>
  </p>
  <div class="table-responsive">
    <table class="table table-striped table-condensed">
      <thead>
        <tr class="active">
          <td>№</td>
          <td>URI</td>
          <td>Название</td>
          <td>Номер</td>
          <td>Данные</td>
          <td>Язык</td>
          <td class="text-right">Функции</td>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @forelse ($modes as $mode)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $mode->slug }}</td>
            <td>{{ $mode->title }}</td>
            <td>{{ $mode->sort_id }}</td>
            <td>{{ $mode->data }}</td>
            <td>{{ $mode->lang }}</td>
            <td class="text-right">
              <a class="btn btn-link btn-xs" href="{{ route('modes.edit', $mode->id) }}" title="Редактировать"><i class="material-icons md-18">mode_edit</i></a>
              <form method="POST" action="{{ route('modes.destroy', $mode->id) }}" accept-charset="UTF-8" class="btn-delete">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-link btn-xs" onclick="return confirm('Удалить запись?')"><i class="material-icons md-18">clear</i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="7">Нет записи</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $modes->links() }}

@endsection