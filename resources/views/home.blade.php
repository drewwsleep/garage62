@extends('layouts.app')

@section('title', 'Garage 62 — Крупнейший автодилер премиум-класса в России')

@section('content')
  <section class="hero-section">
    <div class="hero-slider">
      @foreach (['saloon.jpg', 'girls.jpg', 'saloon2.jpg', 'sunset.jpg', 'family.jpg'] as $index => $image)
        <div class="hero-slide {{ $index === 0 ? 'active' : '' }}">
          <img src="{{ asset('images/' . $image) }}" alt="">
        </div>
      @endforeach
      <div class="hero-overlay"></div>
    </div>

    <div class="hero-content">
      <h1>Премиальные автомобили для истинных ценителей</h1>
      <p>Крупнейший автодилер премиум-класса в России. Более 15 лет на рынке, 5000+ довольных клиентов, эксклюзивные модели и индивидуальный подход к каждому.</p>
      <div class="cta-buttons">
        <button class="btn-primary" onclick="window.location.href='{{ route('cars.page') }}'">Выбрать автомобиль</button>
        <button class="btn-secondary" onclick="window.location.href='#features'">Узнать больше</button>
      </div>
    </div>
  </section>

  <section class="features-section" id="features">
    <div class="section-title">
      <h2>Почему выбирают нас</h2>
      <p>Мы предлагаем не просто автомобили, а полный комплекс услуг для наших клиентов</p>
    </div>

    <div class="features-grid">
      @foreach ([
        ['🚗', 'Эксклюзивные модели', 'В нашем каталоге представлены редкие и ограниченные серии автомобилей премиум-класса'],
        ['🏆', 'Официальный дилер', 'Прямые контракты с ведущими автопроизводителями гарантируют подлинность и качество'],
        ['🔧', 'Сервисное обслуживание', 'Собственный сервисный центр с оригинальными запчастями и сертифицированными специалистами'],
        ['📋', 'Полное сопровождение', 'Оформление документов, страховка, доставка и таможенное оформление "под ключ"'],
      ] as [$icon, $title, $text])
        <div class="feature-card">
          <div class="feature-icon">{{ $icon }}</div>
          <h3>{{ $title }}</h3>
          <p>{{ $text }}</p>
        </div>
      @endforeach
    </div>
  </section>

  <section class="brands-section">
    <div class="section-title">
      <h2>Наши бренды</h2>
      <p>Работаем только с проверенными производителями премиум-класса</p>
    </div>

    <div class="brands-grid">
      @foreach (['PORSCHE', 'FERRARI', 'BMW', 'MERCEDES', 'LAMBORGHINI', 'AUDI', 'BENTLEY', 'AURUS', 'TOYOTA', 'LEXUS'] as $brand)
        <div class="brand-logo">{{ $brand }}</div>
      @endforeach
    </div>
  </section>

  <section class="stats-section">
    @foreach ([['15+', 'Лет на рынке'], ['5000+', 'Довольных клиентов'], ['250+', 'Автомобилей в наличии'], ['24/7', 'Поддержка клиентов']] as [$number, $label])
      <div class="stat-card">
        <div class="stat-number">{{ $number }}</div>
        <div class="stat-label">{{ $label }}</div>
      </div>
    @endforeach
  </section>

  <section class="testimonials-section">
    <div class="section-title">
      <h2>Отзывы клиентов</h2>
      <p>Что говорят о нас наши клиенты</p>
    </div>

    <div class="testimonial">
      <div class="testimonial-text">
        "Приобрел Porsche 911 GT3 через Garage 62. Отличный сервис, профессиональные консультанты, все документы оформили быстро. Особенно понравился индивидуальный подход и внимание к деталям."
      </div>
      <div class="testimonial-author">
        <div class="author-avatar"></div>
        <div class="author-info">
          <p class="author-name">Александр Петров</p>
          <p class="author-role">Предприниматель</p>
        </div>
      </div>
    </div>
  </section>

  <section class="news-section">
    <div class="section-title">
      <h2>Последние новости</h2>
      <p>Следите за нашими обновлениями и событиями</p>
    </div>

    <div class="news-grid">
      @foreach ([
        ['🏎️', '15 марта 2024', 'Новая коллекция Porsche 2024', 'В нашем салоне появились новейшие модели Porsche с обновленным дизайном и технологиями'],
        ['🏁', '10 марта 2024', 'Трек-день для владельцев', 'Организовали эксклюзивный трек-день на автодроме для владельцев спортивных автомобилей'],
        ['🎁', '5 марта 2024', 'Специальное предложение', 'При покупке любого автомобиля до конца месяца — бесплатное годовое обслуживание'],
      ] as [$icon, $date, $title, $text])
        <div class="news-card">
          <div class="news-image">{{ $icon }}</div>
          <div class="news-content">
            <div class="news-date">{{ $date }}</div>
            <h3>{{ $title }}</h3>
            <p>{{ $text }}</p>
            <a href="#" class="read-more">Читать далее →</a>
          </div>
        </div>
      @endforeach
    </div>
  </section>

  <section class="call-to-action">
    <h2>Готовы к новому автомобилю?</h2>
    <p>Запишитесь на тест-драйв или получите консультацию нашего специалиста прямо сейчас</p>
    <button class="btn-cta" onclick="window.location.href='#contacts'">Связаться с нами</button>
  </section>
@endsection
