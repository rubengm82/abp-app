<?php

namespace App\Http\Controllers;

use App\Models\MaterialStockItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialStockItemController extends Controller
{
    /**
     * List items and current quantity for the user's center.
     */
    public function index(Request $request)
    {
        $items = MaterialStockItem::query()
            ->where('center_id', Auth::user()->center_id)
            ->orderBy('name')
            ->get();

        return view('components.contents.materialstock.materialStockItemsList', compact('items'));
    }

    /**
     * Show form to add a new item type.
     */
    public function create()
    {
        return view('components.contents.materialstock.materialStockItemForm');
    }

    /**
     * Store a new item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        MaterialStockItem::create([
            'center_id' => Auth::user()->center_id,
            'name' => $validated['name'],
            'quantity' => 0,
        ]);

        return redirect()->route('material_stock_items_list')->with('success', 'Item afegit correctament.');
    }

    /**
     * Download items list as CSV.
     */
    public function downloadCSV()
    {
        $items = MaterialStockItem::query()
            ->where('center_id', Auth::user()->center_id)
            ->orderBy('name')
            ->get();

        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "estoc_items_{$timestamp}.csv";

        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Item', 'Quantitat disponible']);

        foreach ($items as $item) {
            fputcsv($handle, [$item->name, $item->quantity]);
        }

        fclose($handle);
        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
