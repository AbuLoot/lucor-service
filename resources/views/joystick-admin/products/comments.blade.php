@extends('joystick-admin.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('joystick-admin.partials.alerts')

  <div class="row">
    <div class="col-md-6">
      <ul class="nav nav-tabs">
        <li role="presentation"><a href="{{ route('products.edit', $product->id) }}">Инфо</a></li>
        <li role="presentation" class="active"><a href="#">Коментарии</a></li>
      </ul>
    </div>
    <div class="col-md-6">
      <p class="text-right">
        <a href="/admin/products" class="btn btn-primary btn-sm">Назад</a>
      </p>
    </div>
  </div><br>

  @foreach ($product->comments as $comment)
    <blockquote>
      <p class="pull-right"><a href="/admin/products/{{ $comment->id }}/destroy-comment"><i class="material-icons md-24">clear</i></a></p>
      <p>{{ $comment->comment }}</p>
      <footer class="blockquote-footer">
        {{ $comment->name }} оценил продукт на:
        @for($i = 1; $i <= $comment->stars; ++$i)
          <span class="text-gold"><i class="material-icons">grade</i></span>
        @endfor
      </footer>
    </blockquote>
  @endforeach
@endsection
