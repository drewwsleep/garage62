@extends('layouts.app')

@section('title', 'Регистрация — Garage 62')
@section('mainClass', 'container auth-page')

@section('content')
  <div class="auth-container">
    <div class="auth-card">
      <h1>Регистрация</h1>

      <form class="auth-form register-form" id="registerForm" method="post" action="{{ route('auth.register') }}" novalidate>
        @csrf
        <div class="form-group">
          <label for="name">Имя</label>
          <input type="text" id="name" placeholder="Ваше имя" name="name" required>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" placeholder="Ваш email" name="email" required>
        </div>

        <div class="form-group">
          <label for="password">Пароль</label>
          <div class="password-container">
            <input type="password" id="password" placeholder="Придумайте пароль (мин. 8 символов)" name="password" required>
          </div>
        </div>

        <div class="form-group">
          <label for="confirmPassword">Подтверждение пароля</label>
          <div class="password-container">
            <input type="password" id="confirmPassword" placeholder="Повторите пароль" name="confirmPassword" required>
          </div>
        </div>

        <button type="submit" class="auth-button">Зарегистрироваться</button>
        <div id="regMessage"></div>
        <div id="notification"></div>

        <div class="auth-footer">
          Уже есть аккаунт? <a href="{{ route('login.page') }}">Войти</a>
        </div>
      </form>
    </div>
  </div>
@endsection
