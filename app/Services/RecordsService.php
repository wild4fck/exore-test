<?php

namespace App\Services;

use App\Http\Requests\Admin\CreateRecordRequest;
use App\Models\Record;
use Illuminate\Http\Request;

class RecordsService {

    const IMAGE_PATH = 'images/records';


    /**
     * @param \App\Http\Requests\Admin\CreateRecordRequest $request
     * @param $gallery
     * @throws \Exception
     */
    public static function afterCreateRecord(CreateRecordRequest $request, $gallery) {
        foreach ($request->input('photos') as $size => $photo) {
            FileService::createFromBase64($photo, $request->input('name'), $size, self::IMAGE_PATH, true, $gallery);
        }
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Record $record
     * @return false|\Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public static function beforeUpdateRecord(Request $request, Record $record) {
        if (!empty($request->input('photos'))) {
            $gallery = $record->gallery()->first();
            $lastImages = $record->imagesAll();
            foreach ($request->input('photos') as $size => $photo) {
                FileService::createFromBase64($photo, $request->input('name'), $size, self::IMAGE_PATH, true, $gallery);
            }
        }
        return $lastImages ?? false;
    }

    /**
     * @param $lastImages
     */
    public static function afterUpdateRecord($lastImages) {
        foreach ($lastImages as $lastImage) {
            $lastImage->delete(true);
        }
    }


    public static function afterDeleteRecord(Record $record) {
        if ($images = $record->imagesAll()) {
            foreach ($images as $image) {
                $image->delete(true);
            }
        }
        $record->gallery()->first()->delete();
    }
}
