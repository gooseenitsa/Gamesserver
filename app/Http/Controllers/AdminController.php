<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Server;
use App\Models\User;
use App\Models\Game;
use App\Models\Tariff;

class AdminController extends Controller
{
    // 1. Вывод главной страницы админки
    public function index(Request $request)
    {
        // Проверка: пускаем только админа
        if (!auth()->user()->is_admin) {
            abort(403, 'Доступ запрещен. Вы не администратор.');
        }

        $query = Server::with(['user', 'tariff.game']);

        // Фильтрация
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('game_id')) {
            $query->whereHas('tariff.game', function($q) use ($request) {
                $q->where('id', $request->game_id);
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $allServers = $query->orderBy('created_at', 'desc')->get();
        $usersCount = User::count();

        // Данные для выпадающих списков
        $users = User::orderBy('name')->get();
        $games = Game::orderBy('title')->get();
        $tariffs = Tariff::with('game')->get();

        return view('admin.index', compact('allServers', 'usersCount', 'users', 'games', 'tariffs'));
    }

    // 2. Включение / Выключение ЛЮБОГО сервера (для админа)
    public function toggle(Server $server)
    {
        if (!auth()->user()->is_admin) abort(403);

        $server->status = ($server->status == 'Активен') ? 'Остановлен' : 'Активен';
        $server->save();

        return back()->with('success', 'Статус сервера успешно изменен!');
    }

    // 3. Удаление ЛЮБОГО сервера (для админа)
    public function destroy(Server $server)
    {
        if (!auth()->user()->is_admin) abort(403);

        $server->delete();

        return back()->with('success', 'Сервер принудительно удален из базы.');
    }

    // 4. Добавление новой игры
    public function storeGame(Request $request)
    {
        if (!auth()->user()->is_admin) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'required|url'
        ]);

        Game::create($request->only('title', 'description', 'image_url'));

        return back()->with('success', 'Новая игра успешно добавлена!');
    }

    // 5. Добавление нового тарифа к игре
    public function storeTariff(Request $request)
    {
        if (!auth()->user()->is_admin) abort(403);

        $request->validate([
            'game_id' => 'required|exists:games,id',
            'name' => 'required|string|max:255',
            'slots' => 'required|integer|min:1',
            'ram_mb' => 'required|integer|min:128',
            'price' => 'required|numeric|min:0'
        ]);

        Tariff::create($request->only('game_id', 'name', 'slots', 'ram_mb', 'price'));

        return back()->with('success', 'Новый тариф успешно добавлен!');
    }

    // 6. Добавление сервера пользователю вручную
    public function storeServer(Request $request)
    {
        if (!auth()->user()->is_admin) abort(403);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tariff_id' => 'required|exists:tariffs,id',
            'months' => 'required|integer|min:1'
        ]);

        Server::create([
            'user_id' => $request->user_id,
            'tariff_id' => $request->tariff_id,
            'status' => 'Активен',
            'ip_address' => '192.168.' . rand(1, 255) . '.' . rand(1, 255) . ':' . rand(20000, 30000),
            'expires_at' => now()->addMonths($request->months)
        ]);

        return back()->with('success', 'Сервер успешно выдан пользователю!');
    }
}