<?php

namespace Database\Seeders;

use App\Models\Expression;
use Illuminate\Database\Seeder;

class ExpressionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templateList = [
            'X + (X * A)/100', 'X - (X * A)/100'
        ];

        $fieldList = [
            'price'
        ];

        foreach ($fieldList as $field) {
            foreach ($templateList as $template) {
                Expression::query()->create([
                    'template' => $template,
                    'field' => $field,
                ]);
            }
        }
    }
}
