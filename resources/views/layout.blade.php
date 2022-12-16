<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ToDo App</title>
  @yield('styles')
  <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
<header>
  <nav class="header">
    <div class= "header-left">
      <a class= "header-logo" href="/">
        やることリスト
      </a>
    </div>
    <div class= "header-right">
      <a href="{{ route('tasks.new') }}" >
        タスクを追加する
      </a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf

        <x-responsive-nav-link :href="route('logout')"
                onclick="event.preventDefault();
                            this.closest('form').submit();">
            {{ __('Log Out') }}
        </x-responsive-nav-link>
      </form>
    </div>
  </nav>
</header>
<main>
  @yield('content')
</main>
@yield('scripts')
</body>
</html>
