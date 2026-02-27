<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['title', 'description', 'image_url'];

    public function tariffs()
    {
        return $this->hasMany(Tariff::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}