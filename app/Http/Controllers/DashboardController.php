<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Server; // Подключаем модель серверов

class DashboardController extends Controller
{
    public function index()
    {
        // Достаем из базы серверы ТОЛЬКО ТЕКУЩЕГО пользователя
        // ВМЕСТЕ с тарифом и игрой, чтобы вывести красивые названия
        $servers = Server::with(['tariff.game'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc') // Сначала новые
            ->get();

        // Отдаем их в шаблон dashboard
        return view('dashboard', compact('servers'));
    }
}