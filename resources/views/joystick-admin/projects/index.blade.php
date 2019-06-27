@extends('joystick-admin.layout')

@section('content')
  <h2 class="page-header">Проекты</h2>

  @include('joystick-admin.partials.alerts')

  <p class="text-right">
    <a href="/admin/projects/create" class="btn btn-success btn-sm">Добавить</a>
  </p>
  <div class="table-responsive">
    <table class="table table-striped table-condensed">
      <thead>
        <tr class="active">
          <td>№</td>
          <td>Название</td>
          <td>Slug</td>
          <td>Имя</td>
          <td>Номер</td>
          <td>Язык</td>
          <td>Статус</td>
          <td class="text-right">Функции</td>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach ($projects as $project)
          <tr>
            <td>{{ $i++ }}</td>
            <td><a href="{{ url($project->slug) }}" target="_blank">{{ $project->title }}</a></td>
            <td>{{ $project->slug }}</td>
            <td>{{ $project->name }}</td>
            <td>{{ $project->sort_id }}</td>
            <td>{{ $project->lang }}</td>
            @if ($project->status == 1)
              <td class="text-success">Активен</td>
            @else
              <td class="text-danger">Неактивен</td>
            @endif
            <td class="text-right text-nowrap">
              <a class="btn btn-link btn-xs" href="{{ url($project->slug) }}" title="Просмотр страницы" target="_blank"><i class="material-icons md-18">link</i></a>
              <a class="btn btn-link btn-xs" href="{{ route('projects.edit', $project->id) }}" title="Редактировать"><i class="material-icons md-18">mode_edit</i></a>
              <form class="btn-delete" method="POST" action="{{ route('projects.destroy', $project->id) }}" accept-charset="UTF-8">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-link btn-xs" onclick="return confirm('Удалить запись?')"><i class="material-icons md-18">clear</i></button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection