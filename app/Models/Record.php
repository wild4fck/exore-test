<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Record extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function author(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * @return Collection
     */
    public function imagesAll(): Collection {
        return $this->gallery()->first()->hasMany(Image::class, 'gallery_id')->get();
    }

    /**
     * @return BelongsTo
     */
    public function gallery(): BelongsTo {
        return $this->belongsTo(Gallery::class, 'gallery_id', 'id');
    }

    /**
     * @return array
     */
    public function images(): array {
        $res = [];
        $images = $this->gallery()->first()->hasMany(Image::class, 'gallery_id')->get();
        if ($images) {
            foreach (array_column($images->toArray(), 'size') as $i => $size) {
                $res[$size] = $images[$i];
            }
        }
        return $res;
    }
}
