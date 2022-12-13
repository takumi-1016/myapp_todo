@extends('layout')

@section('content')
  <div class="container">
    <div class="row">
      <div class="column col-md-8">
        <div class="panel panel-default">
          <div class="panel-heading">{{ Auth::user()->name }}さんタスク</div>
          <div class="panel-body">
            <div class="text-right">
              <a href="{{ route('tasks.new', ['id' => \Auth::user()->id]) }}" class="btn btn-default btn-block">
                タスクを追加する
              </a>
            </div>
            <div>
              <form action="{{ route('tasks.index') }}" method="GET">
                <input type="text" name="keyword" value="{{ $keyword }}">
                <input type="submit" value="検索">
              </form>
            </div>
          </div>
          <table class="table">
            <thead>
            <tr>
              <th>タイトル</th>
              <th>状態</th>
              <th>期限</th>
              <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($tasks as $task)
              <tr>
                <td>{{ $task->title }}</td>
                <td>
                  <span class="label {{ $task->status_class }}">{{ $task->status_label }}</span>
                </td>
                <td>{{ $task->formatted_due_date }}</td>
                <td>
                  <a href="{{ route('tasks.edit', ['task_id' => $task->id]) }}">
                    編集
                  </a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
