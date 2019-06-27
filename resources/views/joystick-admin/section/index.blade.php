@extends('admin.layout')

@section('content')
  <h1 class="page-header">Разделы</h1>

  @include('joystick-admin.partials.alerts')
  <p class="text-right">
    <a href="/admin/section/create" class="btn btn-success btn-sm">Добавить</a>
  </p>
  <div class="table-responsive">
    <table class="table-admin table table-striped table-condensed">
      <thead>
        <tr class="active">
          <th>№</th>
          <th>Название</th>
          <th>Иконка</th>
          <th>Номер</th>
          <th>Язык</th>
          <th>Статус</th>
          <th class="text-right">Функции</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @forelse ($section as $item)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->title_description }}</td>
            <td>{{ $item->sort_id }}</td>
            @if ($item->status == 1)
              <td class="text-success">Активен</td>
            @else
              <td class="text-danger">Неактивен</td>
            @endif
            <td class="text-right">
              <a class="btn btn-link btn-xs" href="{{ route('section.edit', $item->id) }}" title="Редактировать"><span class="glyphicon glyphicon-edit"></span></a>
              <form method="POST" action="{{ route('section.destroy', $item->id) }}" accept-charset="UTF-8" class="btn-delete">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-link btn-xs" onclick="return confirm('Удалить запись ({{ $item->title }})?')"><span class="glyphicon glyphicon-remove"></span></button>
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