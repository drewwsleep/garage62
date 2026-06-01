@php
  $title = $car->title();
  $imageUrls = $car->imageUrls();
  $imageSrc = fn (string $url) => preg_match('/^https?:\/\//i', $url) ? $url : asset($url);
@endphp

<div
  class="card"
  data-id="{{ $car->id }}"
  data-brand="{{ $car->carModel->brand ?? '' }}"
  data-model="{{ $car->carModel->model ?? '' }}"
  data-year="{{ $car->year }}"
  data-price="{{ $car->price }}"
  data-image-url="{{ $imageUrls[0] ?? 'images/no-image.jpg' }}"
  data-images="{{ implode('|', $imageUrls) }}"
  data-color="{{ $car->color }}"
  data-features="{{ $car->features }}"
  data-services="{{ $car->services }}"
>
  <div class="card-slider">
    @foreach ($imageUrls as $imageUrl)
      <div class="slide">
        <img src="{{ $imageSrc($imageUrl) }}" alt="{{ $title }}">
      </div>
    @endforeach
  </div>
  <h5>{{ $title }}</h5>
  <div class="price">${{ number_format((float) $car->price, 0, '.', ',') }}</div>
</div>
