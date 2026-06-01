<header class="site-header">
  <div class="container header-inner">
    <a href="{{ route('home') }}" class="logo">
      <img src="{{ asset('images/icon.png') }}" alt="Garage 62"> | Garage 62
    </a>

    <nav class="main-nav">
      <a href="{{ route('home') }}" class="nav-btn {{ request()->routeIs('home') ? 'active' : '' }}">Главная</a>
      <a href="{{ route('cars.page') }}" class="nav-btn {{ request()->routeIs('cars.page') ? 'active' : '' }}">В наличии</a>
      <a href="{{ request()->routeIs('home') || request()->routeIs('cars.page') ? '#contacts' : route('home') . '#contacts' }}" class="nav-btn contacts-link">Контакты</a>
    </nav>

    <div class="auth">
      <a href="{{ route('order.page') }}" class="cart-btn" title="Текущий заказ">🛒</a>

      <div id="authButtons">
        <a href="{{ route('login.page') }}" class="btn ghost">Войти</a>
        <a href="{{ route('register.page') }}" class="btn">Зарегистрироваться</a>
      </div>

      <div id="userInfo" class="user-info">
        <span id="userName"></span>
        <span id="userRole"></span>
        <button id="logoutBtn" class="btn ghost">Выйти</button>
      </div>
    </div>
  </div>
</header>
