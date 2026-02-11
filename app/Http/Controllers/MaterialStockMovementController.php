<?php

namespace App\Http\Controllers;

use App\Models\MaterialStockItem;
use App\Models\MaterialStockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialStockMovementController extends Controller
{
    /**
     * List movements for items of the user's center.
     */
    public function index(Request $request)
    {
        $query = MaterialStockMovement::query()
            ->with(['materialStockItem', 'professional'])
            ->whereHas('materialStockItem', fn ($q) => $q->where('center_id', Auth::user()->center_id))
            ->orderBy('movement_date', 'desc')
            ->orderBy('created_at', 'desc');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('type', 'like', "%{$search}%")
                    ->orWhere('person', 'like', "%{$search}%")
                    ->orWhere('quantity', 'like', "%{$search}%")
                    ->orWhereHas('materialStockItem', fn ($q2) => $q2->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('professional', fn ($q2) => $q2->whereAny(['name', 'surname1'], 'like', "%{$search}%"));
            });
        }

        $movements = $query->get();

        return $request->ajax()
            ? view('components.contents.materialstock.tables.materialStockMovementsListTable', compact('movements'))->render()
            : view('components.contents.materialstock.materialStockMovementsList', compact('movements'));
    }

    /**
     * Show form to create a movement (Fer moviment).
     */
    public function create()
    {
        $items = MaterialStockItem::query()
            ->where('center_id', Auth::user()->center_id)
            ->orderBy('name')
            ->get();

        return view('components.contents.materialstock.materialStockMovementForm', compact('items'));
    }

    /**
     * Store a movement and update item quantity.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_stock_item_id' => 'required|exists:material_stock_items,id',
            'type' => 'required|in:Entrada,Sortida',
            'quantity' => 'required|integer|min:1',
            'movement_date' => 'required|date',
            'person' => 'nullable|string|max:255',
        ]);

        $item = MaterialStockItem::where('id', $validated['material_stock_item_id'])
            ->where('center_id', Auth::user()->center_id)
            ->firstOrFail();

        $qty = (int) $validated['quantity'];
        if ($validated['type'] === 'Entrada') {
            $item->increment('quantity', $qty);
        } else {
            $item->decrement('quantity', $qty);
        }

        MaterialStockMovement::create([
            'material_stock_item_id' => $item->id,
            'type' => $validated['type'],
            'quantity' => $qty,
            'movement_date' => $validated['movement_date'],
            'person' => filled($validated['person'] ?? null) ? trim($validated['person']) : null,
            'professional_id' => Auth::id(),
        ]);

        return redirect()->route('material_stock_movements_list')->with('success', 'Moviment registrat correctament.');
    }

    /**
     * Show a single movement.
     */
    public function show(MaterialStockMovement $materialStockMovement)
    {
        $item = $materialStockMovement->materialStockItem;
        if ($item->center_id !== Auth::user()->center_id) {
            abort(403);
        }

        return view('components.contents.materialstock.materialStockMovementShow', compact('materialStockMovement'));
    }

    /**
     * Cancel a movement: revert item quantity then delete the movement.
     */
    public function destroy(MaterialStockMovement $materialStockMovement)
    {
        $item = $materialStockMovement->materialStockItem;
        if ($item->center_id !== Auth::user()->center_id) {
            abort(403);
        }

        if ($materialStockMovement->type === 'Entrada') {
            $item->decrement('quantity', $materialStockMovement->quantity);
        } else {
            $item->increment('quantity', $materialStockMovement->quantity);
        }

        $materialStockMovement->delete();

        return redirect()->route('material_stock_movements_list')->with('success', 'Moviment cancel·lat correctament.');
    }

    /**
     * Download movements list as CSV.
     */
    public function downloadCSV()
    {
        $movements = MaterialStockMovement::query()
            ->with(['materialStockItem', 'professional'])
            ->whereHas('materialStockItem', fn ($q) => $q->where('center_id', Auth::user()->center_id))
            ->orderBy('movement_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "estoc_moviments_{$timestamp}.csv";

        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Data', 'Tipus', 'Item', 'Quantitat', 'Persona', 'Professional']);

        foreach ($movements as $m) {
            $proName = $m->professional ? $m->professional->name . ' ' . $m->professional->surname1 : '';
            fputcsv($handle, [
                $m->movement_date?->format('d/m/Y'),
                $m->type,
                $m->materialStockItem->name ?? '',
                $m->quantity,
                $m->person,
                $proName,
            ]);
        }

        fclose($handle);
        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
