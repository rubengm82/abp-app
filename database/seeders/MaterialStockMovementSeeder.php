<?php

namespace Database\Seeders;

use App\Models\MaterialStockItem;
use App\Models\MaterialStockMovement;
use App\Models\Professional;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class MaterialStockMovementSeeder extends Seeder
{
    /**
     * Seed sample movements and update item quantities accordingly.
     */
    public function run(): void
    {
        MaterialStockMovement::query()->delete();

        $professionalIds = Professional::query()->whereIn('center_id', [1, 2])->limit(3)->pluck('id')->toArray();
        if (empty($professionalIds)) {
            return;
        }

        $items = MaterialStockItem::all();
        if ($items->isEmpty()) {
            return;
        }

        foreach ($items as $item) {
            $qtyEntrada = rand(20, 100);
            $qtySortida = rand(0, min(15, $qtyEntrada));

            MaterialStockMovement::create([
                'material_stock_item_id' => $item->id,
                'type' => 'Entrada',
                'quantity' => $qtyEntrada,
                'movement_date' => Carbon::now()->subDays(rand(5, 30)),
                'person' => 'Proveedor Suministres SA',
                'professional_id' => $professionalIds[array_rand($professionalIds)],
            ]);

            if ($qtySortida > 0) {
                MaterialStockMovement::create([
                    'material_stock_item_id' => $item->id,
                    'type' => 'Sortida',
                    'quantity' => $qtySortida,
                    'movement_date' => Carbon::now()->subDays(rand(1, 10)),
                    'person' => 'Persona receptora',
                    'professional_id' => $professionalIds[array_rand($professionalIds)],
                ]);
            }
        }

        // Recompute and set current quantity per item (sum Entrada - sum Sortida)
        foreach ($items as $item) {
            $entrada = MaterialStockMovement::where('material_stock_item_id', $item->id)->where('type', 'Entrada')->sum('quantity');
            $sortida = MaterialStockMovement::where('material_stock_item_id', $item->id)->where('type', 'Sortida')->sum('quantity');
            $item->update(['quantity' => $entrada - $sortida]);
        }
    }
}
