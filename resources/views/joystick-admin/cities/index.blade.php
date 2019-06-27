@extends('joystick-admin.layout')

@section('content')

  <h2 class="page-header">Города</h2>

  @include('joystick-admin.partials.alerts')

  <p class="text-right">
    <a href="/admin/cities/create" class="btn btn-success btn-sm">Добавить</a>
  </p>
  <div class="table-responsive">
    <table class="table table-striped table-condensed">
      <thead>
        <tr class="active">
          <td>№</td>
          <td>Страна</td>
          <td>Название</td>
          <td>Номер</td>
          <td>Язык</td>
          <td>Статус</td>
          <td class="text-right">Функции</td>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @forelse ($cities as $city)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $city->country->title }}</td>
            <td>{{ $city->title }}</td>
            <td>{{ $city->sort_id }}</td>
            <td>{{ $city->lang }}</td>
            @if ($city->status == 1)
              <td class="text-success">Активен</td>
            @else
              <td class="text-danger">Неактивен</td>
            @endif
            <td class="text-right">
              <a class="btn btn-link btn-xs" href="{{ route('cities.edit', $city->id) }}" title="Редактировать"><i class="material-icons md-18">mode_edit</i></a>
              <form method="POST" action="{{ route('cities.destroy', $city->id) }}" accept-charset="UTF-8" class="btn-delete">
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

@endsection