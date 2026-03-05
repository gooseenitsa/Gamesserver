<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Server;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Проверка: пускаем только админа
        if (!auth()->user()->is_admin) {
            abort(403, 'Доступ запрещен. Вы не администратор.');
        }

        // Админ видит ВСЕ серверы всех пользователей
        $allServers = Server::with(['user', 'tariff.game'])->orderBy('created_at', 'desc')->get();
        $usersCount = User::count(); // Считаем сколько всего клиентов

        return view('admin.index', compact('allServers', 'usersCount'));
    }
}