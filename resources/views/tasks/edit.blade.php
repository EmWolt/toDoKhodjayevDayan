@extends('layouts.layout')
@section('title')
    Редактировать задачу
@endsection
@section('content')
    <div class="container">
        <h1>Редактирование задачи</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="mt-4 shadow-lg mb-5 bg-body rounded">
            <form class="row g-3 p-5 forma" method="post" action="{{ route('tasks.update', $task->id) }}">
                @csrf
                @method('put')
                <div class="col-md-12">
                    <label for="title" class="form-label">Название задачи</label>
                    <input type="text" value="{{ $task->title }}" placeholder="Убрать двор" name="title"
                        class="form-control" id="title">
                </div>
                <div class="col-md-12">
                    <label class="form-label">Комментарий (при необходимости)</label>
                    <textarea name="description" placeholder="желательно хорошо убрать" class="form-control" cols="20" rows="5">{{ $task->description }}</textarea>
                </div>
                <div class="form-check">
                    <input class="form-check-input" name="completed" value="1" type="checkbox" id="flexCheckDefault"
                        {{ $task->completed ? 'checked' : '' }}>
                    <label class="form-check-label" for="flexCheckDefault">
                        Задача выполнена
                    </label>
                </div>
                <div class="d-grid gap-2 col-lg-6 mx-auto">
                    <button class="btn btn-lg btn-primary" type="submit">Редактировать</button>
                </div>
            </form>
        </div>
    </div>
@endsection
