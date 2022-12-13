# todoアプリ作成にあたって
備忘録的に作成した手順やミスしたポイントをまとめてあります。

## 使用技術
- PHP (8.2.0)
- Laravel (8.83.27) →laravel9は参考にできるドキュメントが少ないため勉強のために一つ下げてアプリ制作した。
- mysql (8.0.31)

# 作成手順
## アプリ作成
`composer create-project "laravel/laravel=8.*" .`にてファイル作成

## データベースの設定
`mysql`
から
`mysql> create database myapp_todo;`
でデータベース作成

.envを編集

```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=myapp_todo *ここをデータベース名に変更
DB_USERNAME=root
DB_PASSWORD=
```
## Taskモデルを作成する
`php artisan make:model -a Task`でマイグレーションファイル、コントローラー、seederファイルなど一括で作成する。
```実行結果
Model created successfully.
Factory created successfully.
Created Migration: 2022_12_13_025926_create_tasks_table
Seeder created successfully.
Request created successfully.
Request created successfully.
Controller created successfully.
Policy created successfully.
```

マイグレーションファイルを以下のように編集
```
public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');　*ユーザーの外部キーを入れておく
            $table->string('title', 100);
            $table->integer('status')->default(1);
            $table->date('due_date');
            $table->timestamps();
        });
    }
```
`php artisan migrate`を実行
これでTaskのテーブルが作成される

## Taskのテストデータを登録する
datebeseファイルの中の
- factries
- seeders
を編集

factories/TaskFactorie.phpに以下を追加
```
use App\Models\Task;
中略
return [
            'user_id' => 1,
            'title' => $this->faker->realText(rand(10,100)),
            'status' => 1,
            'due_date' => Carbon::now()->addDay(5),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
```

seeders/TaskSeeder.phpに以下を追加
```
use App\Models\Task;
中略
public function run()
    {
        Task::factory()->count(10)->create();
    }
```
seeders/DatebaseSeeder.phpに以下を追加
```
public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(TaskSeeder::class);
    }
```

seeders/UserSeeder.phpを作成し（`php artisan make:seeder UserSeeder`）以下を追加
```
use App\Models\User;
中略
public function run()
    {
        User::factory()->count(3)->create();
    }
```

`php artisan db:seed`を実行してテストデータを入れれた。

## ログイン機能を実装する(Laravel Breeze)
ログインユーザーがタスクを登録できるようにログイン機能から実装していく。今回は初学者向けのLaravel Breezeにて実装する。
導入手順
1.`composer require laravel/breeze:^2.1`でインストールする
2.`php artisan breeze:install`で実行
3.`npm install`　`npm run dev`も実行
4.`php artisan migrate`

<img width="1440" alt="スクリーンショット 2022-12-13 13 35 20" src="https://user-images.githubusercontent.com/105266085/207227671-c3459b18-c3de-4b92-abf8-bdbf63513b0e.png">

実装できた

## Task一覧機能の実装
routes/web.phpに以下を追加
```
Route::get('/users/{id}/tasks', [TaskController::class, 'index'])->name('tasks.index');
```

index.blade.phpを編集する
public/css/styles.cssで多少デザインを整える。

コントローラー(TaskController.php)の編集
```
public function index()
    {
        $tasks = Task::all();  *Taskのデータを全て取得

        return view('tasks/index', [
            'tasks' => $tasks,　　　*tasksに$tasksを代入
        ]);
    }
```

## Task作成機能の実装
### Task作成ページ
作成用のページを用意する。
routes/web.phpに以下を追加
```
Route::get('/users/{id}/tasks/new', [TaskController::class, 'new'])->name('tasks.new');
```
コントローラーの編集
```
public function index()
    {
        return view('tasks/new', [
            'user_id' => $id
        ]);
    }
```
task.newのviewを編集する

### Task作成
`php artisan make:request CreateTask`でバリデーションのための FormRequest クラスを作成する。
```
public function authorize()
    {
        return true;  *今回は使わないのでtrueに変える
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:100',　　*字数制限
            'due_date' => 'required|date|after_or_equal:today',　　*今日以降の日付にする
        ];
    }
    
    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'due_date' => '期限日',
        ];
    }

    public function messages()
    {
        return [
            'due_date.after_or_equal' => ':attribute には今日以降の日付を入力してください。',
        ];
    }
}
```

