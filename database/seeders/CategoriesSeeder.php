<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder {

    public $brands = [
        'Asics',
        'Adidas',
        'New balance',
        'Nike',
        'Reebok',
        'Puma',
        'Jordan',
        'Converse',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     * @noinspection PhpUndefinedMethodInspection
     */
    public function run() {
        DB::transaction(function () {
            foreach ($this->brands as $brand) {
                Category::create([
                    'name' => $brand,
                ]);
            }
        });
    }
}
