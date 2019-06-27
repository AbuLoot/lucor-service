@extends('joystick-admin.layout')

@section('content')
  <h2 class="page-header">Страницы</h2>

  @include('joystick-admin.partials.alerts')

  <p class="text-right">
    <a href="/admin/news/create" class="btn btn-success btn-sm">Добавить</a>
  </p>
  <div class="table-responsive">
    <table class="table table-striped table-condensed">
      <thead>
        <tr class="active">
          <td>№</td>
          <td>Название</td>
          <td>URI</td>
          <td>Заголовок</td>
          <td>Номер</td>
          <td>Язык</td>
          <td>Статус</td>
          <td class="text-right">Функции</td>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @forelse ($news as $new)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $new->title }}</td>
            <td>{{ $new->slug }}</td>
            <td>{{ $new->headline }}</td>
            <td>{{ $new->sort_id }}</td>
            <td>{{ $new->lang }}</td>
            @if ($new->status == 1)
              <td class="text-success">Активен</td>
            @else
              <td class="text-danger">Неактивен</td>
            @endif
            <td class="text-right text-nowrap">
              <a class="btn btn-link btn-xs" href="{{ route('news.edit', $new->id) }}" title="Редактировать"><i class="material-icons md-18">mode_edit</i></a>
              <form method="POST" action="{{ route('news.destroy', $new->id) }}" accept-charset="UTF-8" class="btn-delete">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-link btn-xs" onclick="return confirm('Удалить запись?')"><i class="material-icons md-18">clear</i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8">Нет записи</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $news->links() }}

@endsection