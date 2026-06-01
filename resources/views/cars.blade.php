@extends('layouts.app')

@section('title', 'В наличии — Garage 62')
@section('mainClass', 'container main-grid')

@section('content')
  <aside class="filters panel">
    <h3>Ключевые слова</h3>
    <div class="keywords">
      <input type="text" placeholder="Введите слово...">
      <button class="add-btn">Добавить</button>
    </div>

    <h3>Фишки</h3>
    <div class="filter-row">
      @foreach (['Подогрев сидений', 'AWD', 'МКПП'] as $feature)
        <label><input type="checkbox" value="{{ $feature }}">{{ $feature }}</label>
      @endforeach
      <div class="custom-input">
        <input type="text" placeholder="Своя фишка..." class="custom-feature">
        <button class="add-custom-btn" data-type="features">+</button>
      </div>
    </div>

    <h3>Стоимость</h3>
    <div class="price-filter">
      <div class="price-inputs">
        <div class="price-input-group">
          <label>От</label>
          <input type="number" class="price-from" min="0" max="5000000" value="0" placeholder="$0">
        </div>
        <div class="price-separator">-</div>
        <div class="price-input-group">
          <label>До</label>
          <input type="number" class="price-to" min="0" max="5000000" value="5000000" placeholder="$5 000 000">
        </div>
      </div>
    </div>

    <details class="dropdown">
      <summary>Цвет ▾</summary>
      <div class="dropdown-list">
        @foreach (['Чёрный', 'Красный', 'Тёмно-синий'] as $color)
          <label><input type="checkbox" value="{{ $color }}">{{ $color }}</label>
        @endforeach
        <div class="custom-input">
          <input type="text" placeholder="Свой цвет..." class="custom-color">
          <button class="add-custom-btn" data-type="colors">+</button>
        </div>
      </div>
    </details>

    <details class="dropdown">
      <summary>Дополнительные услуги ▾</summary>
      <div class="dropdown-list">
        @foreach (['Алькантара', 'Карбон пакет', 'Двухсоставные кованые диски'] as $service)
          <label><input type="checkbox" value="{{ $service }}">{{ $service }}</label>
        @endforeach
        <div class="custom-input">
          <input type="text" placeholder="Своя услуга..." class="custom-service">
          <button class="add-custom-btn" data-type="services">+</button>
        </div>
      </div>
    </details>
  </aside>

  <section class="content">
    <div class="search-row">
      <div class="sort-dropdown">
        <select id="sortSelect" class="sort-select">
          <option value="new">Новые</option>
          <option value="cheap">Дешевле</option>
          <option value="expensive">Дороже</option>
        </select>
      </div>
    </div>

    <div class="products-grid">
      @forelse ($cars as $car)
        <x-car-card :car="$car" />
      @empty
        <p class="empty-list">Автомобили пока не добавлены.</p>
      @endforelse
    </div>
  </section>
@endsection
