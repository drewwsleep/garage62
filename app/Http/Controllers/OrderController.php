<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $userId = (int) $request->input('user_id', 0);
        $startDate = trim((string) $request->input('start_date', ''));
        $endDate = trim((string) $request->input('end_date', ''));
        $totalPrice = (float) $request->input('total_price', 0);
        $carIds = (array) $request->input('car_id', []);
        $quantities = (array) $request->input('quantity', []);
        $unitPrices = (array) $request->input('unit_price', []);

        $error = $this->validateCreate($userId, $startDate, $endDate, $totalPrice, $carIds);
        if ($error !== null) {
            return $this->fail($error);
        }

        $items = $this->prepareItems($carIds, $quantities, $unitPrices);
        if ($items === []) {
            return $this->fail('В корзине нет валидных позиций');
        }
        if (!User::query()->where('id', $userId)->exists()) {
            return $this->fail('Пользователь не найден');
        }

        try {
            $orderId = DB::transaction(function () use ($userId, $startDate, $endDate, $totalPrice, $items) {
                $mainCarId = $items[0]['car_id'] ?? null;
                $orderId = DB::table('orders')->insertGetId([
                    'user_id' => $userId,
                    'car_id' => $mainCarId,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'total_price' => $totalPrice,
                ]);

                foreach ($items as $item) {
                    DB::table('order_items')->insert([
                        'order_id' => $orderId,
                        'car_id' => $item['car_id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'total_price' => $item['total_price'],
                    ]);
                }

                return $orderId;
            });
        } catch (\Throwable $exception) {
            return $this->fail('Ошибка при оформлении заказа: ' . $exception->getMessage());
        }

        return response('<div class="order-result" data-order-id="' . (int) $orderId . '">Заказ успешно оформлен</div>');
    }

    public function index(Request $request)
    {
        $authUser = $request->session()->get('auth_user');
        if (!is_array($authUser) || (int) ($authUser['id'] ?? 0) <= 0) {
            return $this->fail('Пользователь не авторизован');
        }

        $requestedUserId = (int) $request->query('user_id', 0);
        $isAdmin = ($authUser['role'] ?? '') === 'admin';
        $targetUserId = $isAdmin ? ($requestedUserId > 0 ? $requestedUserId : 0) : (int) $authUser['id'];

        if ($request->query('action') === 'get') {
            $orderId = (int) $request->query('order_id', 0);
            if ($orderId <= 0) {
                return $this->fail('Некорректный ID заказа');
            }

            $order = $this->findOrder($orderId, $targetUserId);
            if (!$order) {
                return $this->fail('Заказ не найден');
            }

            return response($this->renderDetail($order));
        }

        return response($this->renderList($this->listOrders($targetUserId)));
    }

    private function validateCreate(int $userId, string $startDate, string $endDate, float $totalPrice, array $carIds): ?string
    {
        if ($userId <= 0) {
            return 'Пользователь не авторизован';
        }
        if (!$this->isValidDate($startDate)) {
            return 'Некорректная дата начала';
        }
        if (!$this->isValidDate($endDate)) {
            return 'Некорректная дата окончания';
        }
        if ($startDate > $endDate) {
            return 'Дата начала не может быть позже даты окончания';
        }
        if ($totalPrice <= 0) {
            return 'Сумма заказа должна быть больше нуля';
        }
        if ($carIds === []) {
            return 'Корзина пуста';
        }

        return null;
    }

    private function isValidDate(string $value): bool
    {
        $date = \DateTime::createFromFormat('Y-m-d', $value);
        return $date instanceof \DateTime && $date->format('Y-m-d') === $value;
    }

    private function prepareItems(array $carIds, array $quantities, array $unitPrices): array
    {
        $items = [];
        foreach ($carIds as $index => $rawCarId) {
            $carId = (int) $rawCarId;
            $quantity = isset($quantities[$index]) ? max(1, (int) $quantities[$index]) : 1;
            $unitPrice = isset($unitPrices[$index]) ? (float) $unitPrices[$index] : 0.0;

            if ($carId <= 0 || $unitPrice <= 0) {
                continue;
            }

            $items[] = [
                'car_id' => $carId,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_price' => $unitPrice * $quantity,
            ];
        }

        return $items;
    }

    private function findOrder(int $orderId, int $targetUserId): ?array
    {
        $query = DB::table('orders')->where('id', $orderId);
        if ($targetUserId > 0) {
            $query->where('user_id', $targetUserId);
        }

        $order = $query->first();
        if (!$order) {
            return null;
        }

        $data = (array) $order;
        $data['items'] = DB::table('order_items as oi')
            ->leftJoin('cars as c', 'c.id', '=', 'oi.car_id')
            ->leftJoin('car_models as cm', 'c.model_id', '=', 'cm.id')
            ->select('oi.id', 'oi.car_id', 'oi.quantity', 'oi.unit_price', 'oi.total_price', 'cm.brand', 'cm.model', 'c.year', 'c.image_url')
            ->where('oi.order_id', $orderId)
            ->orderBy('oi.id')
            ->get()
            ->map(fn ($item) => (array) $item)
            ->all();

        return $data;
    }

    private function listOrders(int $targetUserId): array
    {
        $query = DB::table('orders as o')
            ->leftJoin('cars as c', 'c.id', '=', 'o.car_id')
            ->leftJoin('car_models as cm', 'c.model_id', '=', 'cm.id')
            ->select('o.id', 'o.user_id', 'o.car_id', 'o.order_date', 'o.start_date', 'o.end_date', 'o.total_price', 'cm.brand', 'cm.model', 'c.image_url')
            ->orderByDesc('o.order_date')
            ->orderByDesc('o.id');

        if ($targetUserId > 0) {
            $query->where('o.user_id', $targetUserId);
        }

        return $query->get()->map(fn ($order) => (array) $order)->all();
    }

    private function renderDetail(array $order): string
    {
        $html = '<div class="order-detail" data-order-id="' . (int) $order['id'] . '">';
        $html .= '<h3>Заказ #' . (int) $order['id'] . '</h3>';
        foreach (($order['items'] ?? []) as $item) {
            $title = trim((string) ($item['brand'] ?? '') . ' ' . (string) ($item['model'] ?? ''));
            $html .= '<div class="order-item">' . $this->h($title) . ' x ' . (int) $item['quantity'] . '</div>';
        }
        $html .= '</div>';

        return $html;
    }

    private function renderList(array $orders): string
    {
        $html = '';
        foreach ($orders as $order) {
            $title = trim((string) ($order['brand'] ?? '') . ' ' . (string) ($order['model'] ?? ''));
            $html .= '<div class="order-row" data-order-id="' . (int) $order['id'] . '">';
            $html .= '<strong>Заказ #' . (int) $order['id'] . '</strong> ';
            $html .= $this->h($title) . ' - ' . $this->h($order['total_price'] ?? '');
            $html .= '</div>';
        }

        return $html;
    }
}
