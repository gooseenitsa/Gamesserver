<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Game;
use App\Models\Tariff;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Создаем Админа
        User::create([
            'name' => 'Администратор',
            'email' => 'admin@mail.ru',
            'password' => Hash::make('12345678'),
            'is_admin' => true,
        ]);

        // Создаем Игру 1
        $cs = Game::create([
            'title' => 'Counter-Strike 2',
            'description' => 'Лучший хостинг для CS2. Низкий пинг, защита от DDoS.',
            'image_url' => 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/730/capsule_616x353.jpg'
        ]);

        // Тарифы для CS2
        Tariff::create(['game_id' => $cs->id, 'name' => 'Public 32', 'slots' => 32, 'ram_mb' => 2048, 'price' => 500]);
        Tariff::create(['game_id' => $cs->id, 'name' => 'CW/Mix 10', 'slots' => 10, 'ram_mb' => 1024, 'price' => 250]);

        // Создаем Игру 2
        $mc = Game::create([
            'title' => 'Minecraft',
            'description' => 'Серверы с поддержкой модов и плагинов. Версии от 1.8 до 1.20.',
            'image_url' => 'https://upload.wikimedia.org/wikipedia/ru/b/b1/Minecraft_cover.png'
        ]);

        // Тарифы для Minecraft
        Tariff::create(['game_id' => $mc->id, 'name' => 'Vanilla', 'slots' => 20, 'ram_mb' => 2048, 'price' => 300]);
        Tariff::create(['game_id' => $mc->id, 'name' => 'Forge/Modded', 'slots' => 50, 'ram_mb' => 8192, 'price' => 900]);
    }
}