@extends('joystick-admin.layout')

@section('content')

  <h2 class="page-header">Страны</h2>

  @include('joystick-admin.partials.alerts')

  <p class="text-right">
    <a href="/admin/countries/create" class="btn btn-success btn-sm">Добавить</a>
  </p>
  <div class="table-responsive">
    <table class="table table-striped table-condensed">
      <thead>
        <tr class="active">
          <td>№</td>
          <td>Название</td>
          <td>Номер</td>
          <td>Язык</td>
          <td>Статус</td>
          <td class="text-right">Функции</td>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @forelse ($countries as $country)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $country->title }}</td>
            <td>{{ $country->sort_id }}</td>
            <td>{{ $country->lang }}</td>
            @if ($country->status == 1)
              <td class="text-success">Активен</td>
            @else
              <td class="text-danger">Неактивен</td>
            @endif
            <td class="text-right">
              <a class="btn btn-link btn-xs" href="{{ route('countries.edit', $country->id) }}" title="Редактировать"><i class="material-icons md-18">mode_edit</i></a>
              <form method="POST" action="{{ route('countries.destroy', $country->id) }}" accept-charset="UTF-8" class="btn-delete">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-link btn-xs" onclick="return confirm('Удалить запись?')"><i class="material-icons md-18">clear</i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5">Нет записи</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $countries->links() }}

@endsection