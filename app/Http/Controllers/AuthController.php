<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $email = trim((string) $request->input('email', ''));
        $password = trim((string) $request->input('password', ''));

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->fail('Некорректный email');
        }
        if ($password === '') {
            return $this->fail('Пароль не может быть пустым');
        }

        $user = User::query()
            ->select(['id', 'name', 'email', 'password', 'role'])
            ->whereRaw('LOWER(email) = LOWER(?)', [$email])
            ->first();

        if (!$user || (string) $user->password !== $password) {
            return $this->fail('Неверный email или пароль');
        }

        $authUser = $this->normalizeUser($user->toArray());
        $request->session()->regenerate();
        $request->session()->put('auth_user', $authUser);

        return response($this->renderUser($authUser));
    }

    public function register(Request $request)
    {
        $name = trim((string) $request->input('name', ''));
        $email = trim((string) $request->input('email', ''));
        $password = trim((string) $request->input('password', ''));

        if ($name === '' || $this->safeLength($name) < 2) {
            return $this->fail('Имя должно быть не менее 2 символов');
        }
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->fail('Некорректный email');
        }
        if ($this->safeLength($password) < 8) {
            return $this->fail('Пароль должен быть не менее 8 символов');
        }

        if (User::query()->whereRaw('LOWER(email) = LOWER(?)', [$email])->exists()) {
            return $this->fail('Пользователь с таким email уже существует');
        }

        try {
            $user = DB::transaction(function () use ($name, $email, $password) {
                return User::query()->create([
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'role' => 'user',
                ]);
            });
        } catch (\Throwable $exception) {
            return $this->fail('Ошибка при регистрации: ' . $exception->getMessage());
        }

        $authUser = $this->normalizeUser($user->toArray());
        $request->session()->regenerate();
        $request->session()->put('auth_user', $authUser);

        return response($this->renderUser($authUser));
    }

    public function me(Request $request)
    {
        return response($this->renderUser($request->session()->get('auth_user')));
    }

    public function logout(Request $request)
    {
        $request->session()->forget('auth_user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response('OK');
    }

    private function normalizeUser(array $user): array
    {
        return [
            'id' => (int) ($user['id'] ?? 0),
            'name' => (string) ($user['name'] ?? ''),
            'email' => (string) ($user['email'] ?? ''),
            'role' => (string) ($user['role'] ?? 'user'),
        ];
    }

    private function renderUser(?array $user): string
    {
        if ($user === null || (int) ($user['id'] ?? 0) <= 0) {
            return '';
        }

        return sprintf(
            '<span class="auth-user" data-id="%d" data-name="%s" data-email="%s" data-role="%s"></span>',
            (int) $user['id'],
            $this->h($user['name'] ?? ''),
            $this->h($user['email'] ?? ''),
            $this->h($user['role'] ?? 'user')
        );
    }
}
