@extends('joystick-admin.layout')

@section('content')
  <h2 class="page-header">Слайд</h2>

  @include('joystick-admin.partials.alerts')

  <p class="text-right">
    <a href="/admin/slide/create" class="btn btn-success btn-sm">Добавить</a>
  </p>
  <div class="table-responsive">
    <table class="table table-striped table-condensed">
      <thead>
        <tr class="active">
          <td>№</td>
          <td>Позиция текста</td>
          <td>Название</td>
          <td>URI</td>
          <td>Заголовок</td>
          <td>Позиция фона (%)</td>
          <td>Язык</td>
          <td>Статус</td>
          <td class="text-right">Функции</td>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @forelse ($slide as $item)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $item->direction }}</td>
            <td>{{ $item->title }}</td>
            <td>{{ $item->slug }}</td>
            <td>{{ $item->marketing }}</td>
            <td>{{ $item->sort_id }}</td>
            <td>{{ $item->lang }}</td>
            @if ($item->status == 1)
              <th class="text-success">Активен</td>
            @else
              <th class="text-danger">Неактивен</td>
            @endif
            <th class="text-right text-nowrap">
              <a class="btn btn-link btn-xs" href="/{{ $item->link }}" title="Просмотр товара" target="_blank"><i class="material-icons md-18">link</i></a>
              <a class="btn btn-link btn-xs" href="{{ route('slide.edit', $item->id) }}" title="Редактировать"><i class="material-icons md-18">mode_edit</i></a>
              <form method="POST" action="{{ route('slide.destroy', $item->id) }}" accept-charset="UTF-8" class="btn-delete">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-link btn-xs" onclick="return confirm('Удалить запись?')"><i class="material-icons md-18">clear</i></button>
              </form>
            </td>
          </tr>
          <tr>
            <td colspan="9">
              <img src="/img/slide/{{ $item->image }}" class="img-responsive"><br>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="9">Нет записи</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $slide->links() }}

@endsection
