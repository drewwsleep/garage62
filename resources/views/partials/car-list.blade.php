@foreach ($cars as $car)
  <x-car-card :car="$car" />
@endforeach
