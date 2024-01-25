<?php

namespace Database\Seeders;

use App\Models\Condition;
use Illuminate\Database\Seeder;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $templateList = [
            'X<A', 'X>A', 'A<X<B', 'X=A'
        ];

        $fieldList = [
            'quantityFull', 'price', 'discount'
        ];

        foreach ($fieldList as $field) {
            foreach ($templateList as $template) {
                Condition::query()->create([
                    'template' => $template,
                    'field' => $field,
                ]);
            }
        }
    }
}
