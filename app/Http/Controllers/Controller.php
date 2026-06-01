<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function h(mixed $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    protected function fail(string $message)
    {
        return response('<div class="php-error" data-error="' . $this->h($message) . '">' . $this->h($message) . '</div>');
    }

    protected function safeLength(string $value): int
    {
        return function_exists('mb_strlen') ? mb_strlen($value, 'UTF-8') : strlen($value);
    }
}
