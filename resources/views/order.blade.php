@extends('layouts.app')

@section('title', 'Корзина — Garage 62')
@section('mainClass', 'container order-container')
@section('footer')
@endsection

@section('content')
  <div class="order-header">
    <h1>Оформление заказа</h1>
    <p>Завершите оформление заказа в несколько простых шагов</p>

    <div class="order-steps">
      <div class="step completed">
        <div class="step-number">1</div>
        <p>Корзина</p>
      </div>
      <div class="step active">
        <div class="step-number">2</div>
        <p>Оформление</p>
      </div>
    </div>
  </div>

  <section class="cart-items" id="cartItems">
    <h2>Выбранные автомобили (<span id="cartCount">0</span>)</h2>
  </section>

  <aside class="order-summary">
    <h2>Итог заказа</h2>

    @foreach ([['Стоимость заказа:', 'sumPrice'], ['Доставка:', 'delivery'], ['Страховка (1 год):', 'insurance'], ['Таможенное оформление:', 'customs']] as [$label, $id])
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
      <a href="{{ route('make-order.page') }}" class="btn-continue" id="checkoutBtn">Оформить заказ →</a>
    </div>
  </aside>
@endsection
