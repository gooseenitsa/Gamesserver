<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'tariff_id', 'months'];

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }
}