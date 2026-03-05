<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $fillable = ['user_id', 'tariff_id', 'status', 'ip_address', 'expires_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class);
    }
}