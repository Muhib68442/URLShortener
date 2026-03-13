<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Url extends Model
{
    protected $table = 'urls';

    protected $fillable = [
        'user_id',
        'original_url',
        'short_code',
        'clicks',
        'expires_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($url) {

            // EXPIRATION DATE (7Days)
            if (!$url->expires_at) {
                $url->expires_at = now()->addDays(7);
            }

            // SHORTEN URL (6-Digit)
            if (!$url->short_code) {
                $code = Str::random(6);
                while (Url::where('short_code', $code)->exists()) {
                    $code = Str::random(6);
                }
                $url->short_code = $code;
            }
        });
    }

    // TYPE CAST EXPIRE DATE
    protected $casts = [
        'expires_at' => 'datetime:Y-m-d H:i:s',
    ];

    // INCREMENT COUNT [MANUAL]
    public function incrementClicks()
    {
        $this->clicks++;
        $this->save();
    }

    // URL belongs to Users [RELATION]
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
