<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function cars(Request $request)
    {
        if (!$this->isAdmin($request)) {
            return $this->fail('Недостаточно прав');
        }

        if ($request->isMethod('get')) {
            return (new CarController())->index();
        }

        $action = trim((string) $request->input('action', ''));
        if ($action === 'create') {
            $payload = $this->parseCarPayload($request);
            if (isset($payload['error'])) {
                return $this->fail($payload['error']);
            }

            $this->createCar($payload);
            return response('OK');
        }

        if ($action === 'update') {
            $carId = (int) $request->input('id', 0);
            if ($carId <= 0) {
                return $this->fail('Некорректный ID автомобиля');
            }

            $payload = $this->parseCarPayload($request);
            if (isset($payload['error'])) {
                return $this->fail($payload['error']);
            }

            if (!DB::table('cars')->where('id', $carId)->exists()) {
                return $this->fail('Автомобиль не найден');
            }

            $modelId = $this->saveCarModel($payload['brand'], $payload['model']);
            DB::table('cars')->where('id', $carId)->update([
                'model_id' => $modelId,
                'year' => $payload['year'],
                'price' => $payload['price'],
                'image_url' => $payload['image_url'],
                'color' => $payload['color'],
                'features' => $payload['features'],
                'services' => $payload['services'],
            ]);

            return response('OK');
        }

        if ($action === 'delete') {
            $carId = (int) $request->input('id', 0);
            if ($carId <= 0) {
                return $this->fail('Некорректный ID автомобиля');
            }

            $car = DB::table('cars')->where('id', $carId)->first();
            if (!$car) {
                return $this->fail('Автомобиль не найден');
            }

            DB::table('cars')->where('id', $carId)->delete();
            $count = DB::table('cars')->where('model_id', $car->model_id)->count();
            if ($count === 0) {
                DB::table('car_models')->where('id', $car->model_id)->delete();
            }

            return response('OK');
        }

        return $this->fail('Неизвестное действие');
    }

    public function users(Request $request)
    {
        if (!$this->isAdmin($request)) {
            return $this->fail('Недостаточно прав');
        }

        if ($request->isMethod('get')) {
            return response($this->renderUserRows(User::query()->orderByDesc('id')->get()->toArray()));
        }

        if ($request->input('action') !== 'update') {
            return $this->fail('Неизвестное действие');
        }

        $userId = (int) $request->input('id', 0);
        $name = trim((string) $request->input('name', ''));
        $email = trim((string) $request->input('email', ''));
        $password = trim((string) $request->input('password', ''));
        $role = trim((string) $request->input('role', ''));

        if ($userId <= 0) {
            return $this->fail('Некорректный ID пользователя');
        }
        if ($name === '' || $this->safeLength($name) < 2) {
            return $this->fail('Имя должно быть не менее 2 символов');
        }
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->fail('Некорректный email');
        }
        if ($password !== '' && $this->safeLength($password) < 8) {
            return $this->fail('Пароль должен быть не менее 8 символов');
        }
        if ($role !== '' && !in_array($role, ['user', 'admin'], true)) {
            return $this->fail('Некорректное значение роли');
        }

        $user = User::query()->find($userId);
        if (!$user) {
            return $this->fail('Пользователь не найден');
        }

        $user->name = $name;
        $user->email = $email;
        if ($password !== '') {
            $user->password = $password;
        }
        if ($role !== '') {
            $user->role = $role;
        }
        $user->save();

        return response('OK');
    }

    private function isAdmin(Request $request): bool
    {
        $user = $request->session()->get('auth_user');
        return is_array($user) && ($user['role'] ?? '') === 'admin';
    }

    private function parseCarPayload(Request $request): array
    {
        $brand = trim((string) $request->input('brand', ''));
        $model = trim((string) $request->input('model', ''));
        $yearRaw = trim((string) $request->input('year', ''));
        $priceRaw = trim((string) $request->input('price', ''));
        $imageUrl = trim((string) $request->input('image_url', ''));
        $color = trim((string) $request->input('color', ''));
        $featuresRaw = trim((string) $request->input('features', ''));
        $servicesRaw = trim((string) $request->input('services', ''));

        if ($brand === '') {
            return ['error' => 'Заполните поле "Марка"'];
        }
        if ($model === '') {
            return ['error' => 'Заполните поле "Модель"'];
        }

        $year = null;
        if ($yearRaw !== '') {
            $year = (int) $yearRaw;
            if ($year < 1900 || $year > 2100) {
                return ['error' => 'Некорректный год'];
            }
        }

        $price = (float) $priceRaw;
        if ($price <= 0) {
            return ['error' => 'Цена должна быть больше нуля'];
        }

        $features = $featuresRaw === '' ? [] : array_map('trim', array_filter(explode(';', $featuresRaw)));
        $services = $servicesRaw === '' ? [] : array_map('trim', array_filter(explode(';', $servicesRaw)));

        return [
            'brand' => $brand,
            'model' => $model,
            'year' => $year,
            'price' => $price,
            'image_url' => $imageUrl === '' ? null : $imageUrl,
            'color' => $color === '' ? null : $color,
            'features' => implode('; ', $features),
            'services' => implode('; ', $services),
        ];
    }

    private function createCar(array $payload): void
    {
        $modelId = $this->saveCarModel($payload['brand'], $payload['model']);
        DB::table('cars')->insert([
            'model_id' => $modelId,
            'year' => $payload['year'],
            'price' => $payload['price'],
            'image_url' => $payload['image_url'],
            'color' => $payload['color'],
            'features' => $payload['features'],
            'services' => $payload['services'],
        ]);
    }

    private function saveCarModel(string $brand, string $model): int
    {
        $record = DB::table('car_models')
            ->where('brand', $brand)
            ->where('model', $model)
            ->first();

        if ($record) {
            return (int) $record->id;
        }

        return (int) DB::table('car_models')->insertGetId([
            'brand' => $brand,
            'model' => $model,
        ]);
    }

    private function renderUserRows(array $users): string
    {
        $html = '';
        foreach ($users as $user) {
            $html .= sprintf(
                '<tr data-user-id="%d" data-name="%s" data-email="%s" data-role="%s"><td>%d</td><td>%s</td><td>%s</td><td><button type="button" class="admin-user-edit" data-user-id="%d">Редактировать</button></td></tr>',
                (int) $user['id'],
                $this->h($user['name'] ?? ''),
                $this->h($user['email'] ?? ''),
                $this->h($user['role'] ?? 'user'),
                (int) $user['id'],
                $this->h($user['name'] ?? ''),
                $this->h($user['email'] ?? ''),
                (int) $user['id']
            );
        }

        return $html;
    }
}
