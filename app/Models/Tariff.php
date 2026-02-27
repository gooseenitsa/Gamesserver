<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $fillable = ['game_id', 'name', 'slots', 'ram_mb', 'price'];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}