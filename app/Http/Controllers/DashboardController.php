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
    // Включение / Выключение сервера
    public function toggle(Server $server)
    {
        // Проверяем, что сервер принадлежит именно этому юзеру
        if ($server->user_id == auth()->id()) {
            // Меняем статус на противоположный
            $server->status = ($server->status == 'Активен') ? 'Остановлен' : 'Активен';
            $server->save();
        }
        return back()->with('success', 'Статус сервера изменен!');
    }

    // Удаление сервера
    public function destroy(Server $server)
    {
        if ($server->user_id == auth()->id()) {
            $server->delete();
        }
        return back()->with('success', 'Сервер удален из вашего аккаунта.');
    }
}