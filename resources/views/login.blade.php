@extends('layouts.app')

@section('title', 'Войти — Garage 62')
@section('mainClass', 'container auth-page')

@section('content')
  <div class="auth-container">
    <div class="auth-card">
      <h1>Войти в аккаунт</h1>

      <form class="auth-form" id="loginForm" method="post" action="{{ route('auth.login') }}" novalidate>
        @csrf
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" placeholder="Ваш email" name="email" required>
        </div>

        <div class="form-group">
          <label for="password">Пароль</label>
          <div class="password-container">
            <input type="password" id="password" placeholder="Ваш пароль" name="password" required>
          </div>
        </div>

        <button type="submit" class="auth-button">Войти</button>
        <div id="loginMessage"></div>
        <div id="notification"></div>

        <div class="auth-footer">
          Нет аккаунта? <a href="{{ route('register.page') }}">Зарегистрироваться</a>
        </div>
      </form>
    </div>
  </div>
@endsection
