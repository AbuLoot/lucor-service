@extends('joystick-admin.layout')

@section('content')

  <h2 class="page-header">Опции</h2>

  @include('joystick-admin.partials.alerts')
  <p class="text-right">
    <a href="/admin/options/create" class="btn btn-success btn-sm">Добавить</a>
  </p>
  <div class="table-responsive">
    <table class="table table-condensed">
      <thead>
        <tr class="active">
          <td>№</td>
          <td>URI</td>
          <td>Название</td>
          <td>Номер</td>
          <td>Язык</td>
          <td class="text-right">Функции</td>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @forelse ($grouped as $data => $group)
          <th class="active" colspan="6">{{ $data }}</th>
          @foreach ($group as $option)
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{ $option->slug }}</td>
              <td>{{ $option->title }}</td>
              <td>{{ $option->sort_id }}</td>
              <!-- <td>{{ $option->data }}</td> -->
              <td>{{ $option->lang }}</td>
              <td class="text-right">
                <a class="btn btn-link btn-xs" href="{{ route('options.edit', $option->id) }}" title="Редактировать"><i class="material-icons md-18">mode_edit</i></a>
                <form method="POST" action="{{ route('options.destroy', $option->id) }}" accept-charset="UTF-8" class="btn-delete">
                  <input name="_method" type="hidden" value="DELETE">
                  <input name="_token" type="hidden" value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-link btn-xs" onclick="return confirm('Удалить запись?')"><i class="material-icons md-18">clear</i></button>
                </form>
              </td>
            </tr>
          @endforeach
        @empty
          <tr>
            <td colspan="6">Нет записи</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $options->links() }}

@endsection