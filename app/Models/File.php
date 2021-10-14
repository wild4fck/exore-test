<?php /** @noinspection PhpUndefinedFieldInspection */

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class File extends Model {
    use HasFactory;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    /**
     * Права по умолчанию на создание вложенных директорий
     */
    const CHMOD_DIR = 0755;
    public $incrementing = false;
    public $keyType = 'string';
    protected $table = 'files';
    protected $dates = ['created_at, updated_at'];
    protected $guarded = [];
    protected $primaryKey = 'uuid';

    /**
     * @param bool $deleteFile
     * @return bool|null
     * @throws Exception
     */
    public function delete(bool $deleteFile = false): ?bool {
        if ($deleteFile and file_exists($this->getPath())) {
            unlink($this->getPath());
            if ($this->webp and file_exists($this->getPath('webp'))) {
                unlink($this->getPath('webp'));
            }
        }
        return DB::table($this->table)->where("uuid", $this->uuid)->delete();
    }

    /**
     * @param string|null $extension
     * @param bool $includeName
     * @return string|null
     */
    public function getPath(string $extension = null, bool $includeName = true): ?string {
        $addPath = $this->additional_path ? "/" . $this->additional_path : '';
        return public_path() . "/" . env("FILES_DIRECTORY", "files") . $addPath . "/" . ($includeName ? $this->attributes['uuid'] . "." . (!empty($extension) ? $extension : $this->extension) : '');
    }

    /**
     * @param string|null $extension
     * @return string
     */
    public function getUrl(string $extension = null): string {
        $addPath = $this->additional_path ? "/" . $this->additional_path : '';
        return "/" . env("FILES_DIRECTORY", "files") . $addPath . "/" . $this->attributes['uuid'] . "." . ($extension ? $extension : $this->extension);
    }

    /**
     * Создать папку для файла
     * @throws Exception
     */
    public function createDirectory() {
        // Проверяем наличие директории для данного файла и если её нет - создаем, а если не смогли - бросаем
        if (!file_exists($this->getDirectory()) && !mkdir($this->getDirectory(), (int)$this::CHMOD_DIR, true) && !is_dir($this->getDirectory())) {
            throw new Exception("Невозможно создать вложенную директорию при сохранении файла");
        }
    }

    /**
     * @return string|null
     */
    public function getDirectory(): ?string {
        if ($this->attributes['uuid']) {
            $dirname = public_path() . "/" . env("FILES_DIRECTORY", "files");
            if ($this->additional_path) {
                $dirname .= "/" . $this->additional_path;
            }
            return $dirname;
        }
        return null;
    }

    protected function setKeysForSaveQuery($query): Builder {
        $keys = $this->getKeyName();
        if (!is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach ($keys as $keyName) {
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    protected function getKeyForSaveQuery($keyName = null) {
        if (is_null($keyName)) {
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }
}
