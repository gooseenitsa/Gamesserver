<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tariff;
use App\Models\Cart;
use App\Models\Server;

class CartController extends Controller
{
    // 1. Показать корзину
    public function index()
    {
        // Достаем из базы корзину текущего юзера вместе с тарифами и играми
        $cartItems = Cart::with('tariff.game')->where('user_id', auth()->id())->get();

        // Считаем общую сумму (цена * месяцы)
        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += ($item->tariff->price * $item->months);
        }

        return view('cart.index', compact('cartItems', 'totalPrice'));
    }

    // 2. Добавить тариф в корзину
    public function add(Tariff $tariff)
    {
        // Ищем, есть ли уже этот тариф в корзине. Если нет - создаем с 1 месяцем.
        Cart::firstOrCreate(
            ['user_id' => auth()->id(), 'tariff_id' => $tariff->id],
            ['months' => 1]
        );

        return redirect()->route('cart.index');
    }

    // 3. Обновить количество месяцев
    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id == auth()->id()) {
            $cart->update(['months' => $request->months]);
        }
        return redirect()->route('cart.index');
    }

    // 4. Удалить из корзины
    public function remove(Cart $cart)
    {
        if ($cart->user_id == auth()->id()) {
            $cart->delete();
        }
        return redirect()->route('cart.index');
    }

    // 5. Оформить заказ (Покупка)
    public function checkout()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('home');
        }

        // Для каждого товара в корзине создаем активный сервер
        foreach ($cartItems as $item) {
            Server::create([
                'user_id' => auth()->id(),
                'tariff_id' => $item->tariff_id,
                'status' => 'Активен',
                'ip_address' => '192.168.' . rand(1, 255) . '.' . rand(1, 255) . ':' . rand(20000, 30000), // Генерируем фейковый IP
                'expires_at' => now()->addMonths((int) $item->months) // Дата окончания = сегодня + кол-во месяцев
            ]);
        }

        // Очищаем корзину после покупки
        Cart::where('user_id', auth()->id())->delete();

        // Перекидываем в личный кабинет
        return redirect()->route('dashboard');
    }
}