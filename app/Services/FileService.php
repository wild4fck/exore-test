<?php /** @noinspection PhpUndefinedFieldInspection */


namespace App\Services;


use App\Models\File;
use App\Models\Gallery;
use App\Services\System\UUID;
use Exception;
use Illuminate\Http\UploadedFile;

/**
 * Class FileService
 * @package App\Services
 */
class FileService {

    /**
     * @param string|null $base64String
     * @return string
     */
    public static function getBase64FileSize(?string $base64String): string {
        if ($base64String) {
            $data = explode(',', $base64String);

            $alignChars = substr($data[1], -1) == '=' ? 1 : 0;
            $alignChars += substr($data[1], -2) == '==' ? 1 : 0;

            return (strlen($data[1]) / 4) * 3 - $alignChars;
        }
        return 0;
    }

    /**
     * @param string $base64
     * @param string $filename
     * @param string $size
     * @param string|null $additionalPath
     * @param bool $webp
     * @param Gallery|null $gallery
     * @return static|null
     * @throws Exception
     */
    public static function createFromBase64(string $base64, string $filename, string $size = null, ?string $additionalPath = null, bool $webp = false, Gallery $gallery = null): ?File {

        $data = explode(',', $base64);
        $start = strpos($data[0], '/') + 1;
        $finish = strpos($data[0], ';');
        $extension = substr($data[0], $start, $finish - $start);

        $file = new File;
        $file->uuid = UUID::generate();
        $file->additional_path = $additionalPath;
        $file->name = $filename;
        $file->webp = $webp;
        $file->size = $size;
        $file->extension = $extension;

        if ($gallery) {
            $file->gallery_id = $gallery->id;
        }

        $file->createDirectory();

        file_put_contents($file->getPath(), base64_decode($data[1]));

        if ($webp) {
            exec("cwebp -q 85 \"{$file->getPath()}\" -o \"{$file->getPath('webp')}\"");
        }

        $file->save();
        return $file;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param string $filename
     * @param string|null $additionalPath
     * @param string|null $description
     * @return File|null
     * @throws Exception
     */
    public static function createFromUploadedFile(UploadedFile $uploadedFile, string $filename, ?string $additionalPath = null, string $description = null): ?File {
        $file = new File;
        $file->uuid = UUID::generate();
        $file->additional_path = $additionalPath;
        $file->name = $filename;
        $file->description = $description;
        $file->extension = $uploadedFile->extension();
        $file->createDirectory();
        file_put_contents($file->getPath(), $uploadedFile->getContent());
        $file->save();
        return $file;
    }

}
