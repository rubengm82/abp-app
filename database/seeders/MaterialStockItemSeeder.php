<?php

namespace Database\Seeders;

use App\Models\MaterialStockItem;
use Illuminate\Database\Seeder;

class MaterialStockItemSeeder extends Seeder
{
    /**
     * Seed material stock item types per center. Duplicate names allowed per center.
     */
    public function run(): void
    {
        MaterialStockItem::query()->delete();

        $itemNames = [
            'Roba uniforme S',
            'Roba uniforme M',
            'Roba uniforme L',
            'Guants',
            'Mascaretes',
            'Bates',
            'Sabates seguretat',
        ];

        $centerIds = [1, 2];

        foreach ($centerIds as $centerId) {
            foreach ($itemNames as $name) {
                MaterialStockItem::create([
                    'center_id' => $centerId,
                    'name' => $name,
                    'quantity' => 0,
                ]);
            }
        }
    }
}
