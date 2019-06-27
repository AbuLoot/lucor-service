@extends('layout')

@section('content')
      @extends('joystick-admin.partials.alerts')
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-8">
              <h3>Редактирование раздела</h3>
              <form action="{{ route('admin.tags.update', $tag->id) }}" method="post" class="form-horizontal">
                <input name="_method" type="hidden" value="PUT">
                {!! csrf_field() !!}
                <div class="form-group">
                  <div class="col-md-offset-3 col-md-9">
                    @include('partials.alerts')
                  </div>

                  <label for="sort_id" class="col-md-3">Номер</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : $tag->sort_id }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="category_id" class="col-md-3">Категории</label>
                  <div class="col-md-9">
                    <select class="form-control" name="category_id" id="category">
                      @foreach ($section as $item)
                        <optgroup label="{{ $item->title }}">
                          @foreach ($item->categories as $category)
                            @if ($category->id == $tag->category_id)
                              <option value="{{ $category->id }}" selected>{{ $category->title }}</option>
                            @else
                              <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endif
                          @endforeach
                        </optgroup>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="title" class="col-md-3">Заголовок тега</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" id="title" name="title" minlength="5" maxlength="80" value="{{ (old('title')) ? old('title') : $tag->title }}" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="slug" class="col-md-3">Slug</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" id="slug" name="slug" minlength="5" maxlength="80" value="{{ (old('slug')) ? old('slug') : $tag->slug }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="lang" class="col-md-3">Язык</label>
                  <div class="col-md-9">
                    <input type="text" class="form-control" id="lang" name="lang" minlength="5" maxlength="80" value="{{ (old('lang')) ? old('lang') : $tag->lang }}">
                  </div>
                </div>
                <div class="form-group">
                  <label for="status" class="col-md-3">Статус</label>
                  <div class="col-md-9">
                    <label>
                      @if ($tag->status == 1)
                        <input type="checkbox" id="status" name="status" checked> Активен
                      @else
                        <input type="checkbox" id="status" name="status"> Активен
                      @endif
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-9 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">Обновить тег</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
@endsection
