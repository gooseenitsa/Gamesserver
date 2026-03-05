<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\Tariff;

class GameServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            [
                'title' => 'Minecraft',
                'description' => 'Самая популярная песочница. Идеально для ванильного выживания и серверов с модами (Forge, Fabric, Paper).',
                'image_url' => 'https://images.unsplash.com/photo-1607513746994-51f730a44832?q=80&w=800&auto=format&fit=crop',
                'tariffs' => [
                    ['name' => 'Vanilla Start', 'slots' => 10, 'ram_mb' => 2048, 'price' => 250],
                    ['name' => 'Pro Modded', 'slots' => 50, 'ram_mb' => 8192, 'price' => 900],
                    ['name' => 'Bungee Network', 'slots' => 200, 'ram_mb' => 16384, 'price' => 2500],
                ]
            ],
            [
                'title' => 'Counter-Strike 2',
                'description' => 'Новая эра соревновательного шутера. Высокий тикрейт и минимальный пинг для турниров и пабликов.',
                'image_url' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=800&auto=format&fit=crop',
                'tariffs' => [
                    ['name' => 'Public 64T', 'slots' => 20, 'ram_mb' => 2048, 'price' => 400],
                    ['name' => 'Matchmaking 128T', 'slots' => 10, 'ram_mb' => 4096, 'price' => 750],
                ]
            ],
            [
                'title' => 'Rust',
                'description' => 'Выживание в жестоком мире. Требует мощного железа для большого количества построек и игроков.',
                'image_url' => 'https://images.unsplash.com/photo-1579373903781-fd5c0c30c4cd?q=80&w=800&auto=format&fit=crop',
                'tariffs' => [
                    ['name' => 'Barren Start', 'slots' => 50, 'ram_mb' => 6144, 'price' => 800],
                    ['name' => 'Procedural Max', 'slots' => 150, 'ram_mb' => 16384, 'price' => 2100],
                ]
            ],
            [
                'title' => 'ARK: Survival Evolved',
                'description' => 'Динозавры, трайбы и рейды. Надежные серверы для комфортной игры без лагов даже на больших базах.',
                'image_url' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?q=80&w=800&auto=format&fit=crop',
                'tariffs' => [
                    ['name' => 'Island Base', 'slots' => 30, 'ram_mb' => 8192, 'price' => 1200],
                    ['name' => 'Cluster Node', 'slots' => 70, 'ram_mb' => 16384, 'price' => 2800],
                ]
            ],
            [
                'title' => 'Palworld',
                'description' => 'Многопользовательское выживание с Палами! Соберите друзей для совместного строительства базы и фарма.',
                'image_url' => 'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?q=80&w=800&auto=format&fit=crop',
                'tariffs' => [
                    ['name' => 'Co-op (4-8)', 'slots' => 8, 'ram_mb' => 8192, 'price' => 950],
                    ['name' => 'Guilds (16-32)', 'slots' => 32, 'ram_mb' => 16384, 'price' => 1800],
                ]
            ]
        ];

        foreach ($games as $gameData) {
            $game = Game::firstOrCreate(
                ['title' => $gameData['title']],
                ['description' => $gameData['description'], 'image_url' => $gameData['image_url']]
            );

            foreach ($gameData['tariffs'] as $tariffData) {
                Tariff::firstOrCreate([
                    'game_id' => $game->id,
                    'name' => $tariffData['name']
                ], [
                    'slots' => $tariffData['slots'],
                    'ram_mb' => $tariffData['ram_mb'],
                    'price' => $tariffData['price']
                ]);
            }
        }
    }
}
