<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FooterSlider extends Model
{
    use HasFactory;

    protected $guarded=[];

    public const LABELS = [
        'new_arrivals'   => 'New Arrivals',
        'new_collection' => 'New Collection',
        'trending'       => 'Trending',
        'discount'       => 'Discount',
    ];

    protected $appends = ['label_text'];

    public function getLabelTextAttribute()
    {
        return self::LABELS[$this->label] ?? null;
    }

}
