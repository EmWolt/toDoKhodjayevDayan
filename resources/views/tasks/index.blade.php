@extends('layouts.layout')
@section('title')
    Главная страница
@endsection
@section('content')
    <h1>Мои задачи</h1>
    <h6 class="text-muted">Фильтры</h6>
    <form class="row" method="get">
        @csrf
        <div class="col-md-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="completed" value="1" id="completedCheck"
                    {{ request('completed') ? 'checked' : '' }}>
                <label class="form-check-label" for="completedCheck">Выполненные</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="not_completed" value="1" id="notCompletedCheck"
                    {{ request('not_completed') ? 'checked' : '' }}>
                <label class="form-check-label" for="notCompletedCheck">Не выполненные</label>
            </div>
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary mt-3">Применить фильтры</button>
        </div>
    </form>


    <div class="table-responsive pt-4">
        <table class="table">
            <tr>
                <td>ID</td>
                <td>Название</td>
                <td>Описание</td>
                <td>Статус</td>
                <td>Дата добавления</td>
                <td>Дата обновления</td>
                <td></td>
            </tr>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>
                        @if ($task->completed == true)
                            Выполнено
                        @else
                            Не выполнено
                        @endif
                    </td>
                    <td>{{ $task->created_at }}</td>
                    <td>{{ $task->updated_at }}</td>
                    <td>
                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary text-white">Редактировать</a>
                    </td>
                    <td>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger text-white">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <br>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">Добавить новую задачу</a>
@endsection
