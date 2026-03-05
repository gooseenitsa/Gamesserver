<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class CatalogController extends Controller
{
    // Главная страница: Вывод всех игр + ПОИСК
    public function index(Request $request)
    {
        $query = Game::query();

        // Если пользователь что-то ввел в поиск
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $games = $query->get();
        return view('welcome', compact('games'));
    }

    // Страница одной игры: Вывод тарифов + СОРТИРОВКА
    public function show(Request $request, Game $game)
    {
        $tariffsQuery = $game->tariffs();

        if ($request->sort == 'price_desc') {
            $tariffsQuery->orderBy('price', 'desc');
        } else {
            $tariffsQuery->orderBy('price', 'asc');
        }

        $tariffs = $tariffsQuery->get();

        // ДОСТАЕМ ОТЗЫВЫ ВМЕСТЕ С ИМЕНАМИ ПОЛЬЗОВАТЕЛЕЙ И ТАРИФАМИ (Свежие сверху)
        $reviews = $game->reviews()->with(['user', 'tariff'])->orderBy('created_at', 'desc')->get();

        return view('catalog.show', compact('game', 'tariffs', 'reviews'));
    }
}