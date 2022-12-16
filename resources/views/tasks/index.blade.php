@extends('layout')

@section('content')
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">{{ Auth::user()->name }}さんのタスク</div>
      <div class="panel-body">
        <form action="{{ route('tasks.index') }}" method="GET" class="input-group">
          <input type="text" class="form-control" placeholder="キーワードを入力" name="keyword" value="{{ $keyword }}">
          <input type="submit" value="検索" class="btn btn-outline-success">
        </form>
      </div>
      <table class="table">
        <thead>
        <tr>
          <th>タイトル</th>
          <th>状態</th>
          <th>期限</th>
          <th>優先度</th>
          <th></th>
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
              <span >{{ $task->emergency }}</span>
            </td>
            <td>
              <a href="{{ route('tasks.edit', ['task_id' => $task->id]) }}" class="btn btn-primary">
                編集
              </a>
            </td>
            <td>
              <form method="post" action="{{ route('tasks.destroy', $task->id) }}">
                @csrf
                <button type="submit" class="btn btn-danger" onclick='return confirm("削除しますか？");'>削除</button>
            </form>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
