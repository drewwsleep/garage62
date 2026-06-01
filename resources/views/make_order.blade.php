@extends('layouts.app')

@section('title', 'Оформление заказа — Garage 62')
@section('mainClass', 'container order-container')
@section('footer')
@endsection

@section('content')
  <div class="order-header">
    <h1>Оформление заказа</h1>
    <p>Завершите оформление заказа в несколько простых шагов</p>

    <div class="order-steps">
      @foreach ([1 => 'Корзина', 2 => 'Оформление'] as $number => $label)
        <div class="step completed">
          <div class="step-number">{{ $number }}</div>
          <p>{{ $label }}</p>
        </div>
      @endforeach
    </div>
  </div>

  <section class="cart-items" id="cartItems">
    <h2>Выбранные автомобили (<span id="cartCount">0</span>)</h2>
    <div id="cartItemsContainer"></div>
  </section>

  <section class="delivery-notification">
    <div class="delivery-info">
      <div class="delivery-icon">🚗</div>
      <h3>Заказ оформлен! Автомобиль готов к выдаче</h3>
      <p>Поздравляем с успешным оформлением заказа! Ваш автомобиль уже ожидает вас.</p>

      <div class="delivery-details">
        <div class="detail-item">
          <strong>🏢 Адрес дилерского центра:</strong>
          <p>г. Рязань, ул. Пушкина, стр. 1</p>
        </div>
        <div class="detail-item">
          <strong>🕒 Часы работы:</strong>
          <p>Пн-Пт: 9:00-20:00<br>Сб-Вс: 10:00-18:00</p>
        </div>
        <div class="detail-item">
          <strong>⚠️ Что взять с собой:</strong>
          <p>Паспорт и документ, подтверждающий оплату</p>
        </div>
      </div>

      <div class="delivery-instruction">
        <p><strong>Инструкция по получению:</strong></p>
        <ol>
          @foreach (['Приезжайте в дилерский центр в рабочее время', 'Подойдите к стойке администратора', 'Назовите номер вашего заказа', 'Предъявите документы для проверки', 'Получите ключи и документы на автомобиль'] as $step)
            <li>{{ $step }}</li>
          @endforeach
        </ol>
      </div>

      <div class="delivery-note">
        <p><em>Благодарим за выбор Garage 62! Ждем вас для получения автомобиля.</em></p>
      </div>
    </div>
  </section>

  <aside class="order-summary">
    <h2>Итог заказа</h2>

    @foreach ([['Стоимость заказа:', 'sumPrice'], ['Доставка:', 'deliveryCost'], ['Страховка (1 год):', 'insurance'], ['Таможенное оформление:', 'customs']] as [$label, $id])
      <div class="summary-row">
        <span>{{ $label }}</span>
        <span id="{{ $id }}">$0</span>
      </div>
    @endforeach

    <div class="summary-row summary-total">
      <span>Общая сумма:</span>
      <span id="total">$0</span>
    </div>

    <div class="order-actions">
      <a href="{{ route('cars.page') }}" class="btn-back">← Вернуться к покупкам</a>
      <button type="button" id="submitOrderBtn" class="btn submit-order-btn">Подтвердить заказ</button>
    </div>
  </aside>
@endsection
