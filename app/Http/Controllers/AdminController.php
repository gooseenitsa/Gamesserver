<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Server;
use App\Models\User;

class AdminController extends Controller
{
    // 1. Вывод главной страницы админки
    public function index()
    {
        // Проверка: пускаем только админа
        if (!auth()->user()->is_admin) {
            abort(403, 'Доступ запрещен. Вы не администратор.');
        }

        $allServers = Server::with(['user', 'tariff.game'])->orderBy('created_at', 'desc')->get();
        $usersCount = User::count();

        return view('admin.index', compact('allServers', 'usersCount'));
    }

    // 2. Включение / Выключение ЛЮБОГО сервера (для админа)
    public function toggle(Server $server)
    {
        if (!auth()->user()->is_admin)
            abort(403); // Защита

        $server->status = ($server->status == 'Активен') ? 'Остановлен' : 'Активен';
        $server->save();

        return back()->with('success', 'Статус сервера успешно изменен!');
    }

    // 3. Удаление ЛЮБОГО сервера (для админа)
    public function destroy(Server $server)
    {
        if (!auth()->user()->is_admin)
            abort(403); // Защита

        $server->delete();

        return back()->with('success', 'Сервер принудительно удален из базы.');
    }
}