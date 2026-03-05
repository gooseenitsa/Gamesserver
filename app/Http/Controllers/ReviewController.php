<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Server;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request, Game $game)
    {
        // Проверяем, чтобы текст отзыва не был пустым
        $request->validate([
            'text' => 'required|min:5',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        // Создаем отзыв в базе
        Review::create([
            'user_id' => auth()->id(),
            'game_id' => $game->id,
            'text' => $request->text,
            'rating' => $request->rating
        ]);

        return back()->with('success', 'Спасибо! Ваш отзыв добавлен.');
    }

    public function storeForServer(Request $request, Server $server)
    {
        // Проверяем, что сервер принадлежит юзеру
        if ($server->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'text' => 'required|min:5',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        Review::create([
            'user_id' => auth()->id(),
            'game_id' => $server->tariff->game_id,
            'tariff_id' => $server->tariff_id,
            'text' => $request->text,
            'rating' => $request->rating
        ]);

        return back()->with('success', 'Спасибо! Ваш отзыв о сервере добавлен.');
    }
}