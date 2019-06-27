@extends('joystick-admin.layout')

@section('content')
  <h2 class="page-header">Пользователи</h2>

  @include('joystick-admin.partials.alerts')

  <div class="table-responsive">
    <table class="table table-striped table-condensed">
      <thead>
        <tr class="active">
          <th>№</th>
          <th>Имя</th>
          <th>Email</th>
          <th>Роль</th>
          <th class="text-right">Функции</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @forelse ($users as $user)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
              @foreach ($user->roles as $role)
                {{ $role->name }}<br>
              @endforeach
            </td>
            <td class="text-right text-nowrap">
              <a class="btn btn-link btn-xs" href="{{ route('users.edit', $user->id) }}" title="Редактировать"><i class="material-icons md-18">mode_edit</i></a>
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
  {{ $users->links() }}

@endsection
