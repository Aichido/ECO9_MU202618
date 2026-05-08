<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['formation_id', 'user_id', 'note', 'commentaire'];

    protected $casts = [
        'note' => 'integer',
    ];

    public static function moyennePourFormation($formationId)
    {
        return self::where('formation_id', $formationId)->avg('note') ?? 0.0;
    }

    public static function nombreAvisPourFormation($formationId)
    {
        return self::where('formation_id', $formationId)->count();
    }
}