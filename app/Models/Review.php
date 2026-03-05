<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'game_id', 'tariff_id', 'text', 'rating'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function game()
    {
        return $this->belongsTo(Game::class);
    }
    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }
}