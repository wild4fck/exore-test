<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends File {
    use HasFactory;

    /**
     * @return string
     */
    public function getWebp(): string {
        return $this->getUrl('webp');
    }

    public function getAllSizes(): string {
        return (exec("find {$this->getPath(null, false)} -iname '{$this->attributes['uuid']}*'"));
    }
}
