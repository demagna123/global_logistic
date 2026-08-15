<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\QuoteItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Afficher la liste des devis
     */
    public function index()
    {
        $quotes = Quote::with('items')->orderBy('created_at', 'desc')->paginate(10);
        return view('admins.quotes.index', compact('quotes'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        $serviceTypes = Quote::SERVICE_TYPES;
        $statuses = Quote::STATUSES;
        return view('admins.quotes.create', compact('serviceTypes', 'statuses'));
    }

    /**
     * Enregistrer un nouveau devis
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'nullable|string|max:50',
            'service_type' => 'required|in:transit_douane,tierce_detention,representation_commerciale,transport_logistique,entreposage',
            'description' => 'required|string',
            'valid_until' => 'nullable|date|after:today',
            'status' => 'required|in:draft,sent,accepted,rejected',
            'admin_notes' => 'nullable|string',
            'items' => 'nullable|array',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0'
        ]);

        // Créer le devis
        $quote = Quote::create($request->except('items'));

        // Ajouter les lignes de produit
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                $quote->items()->create([
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => $item['quantity'] * $item['unit_price']
                ]);
            }
        }

        return redirect()->route('admins.quotes.index')
            ->with('success', 'Devis créé avec succès !');
    }

    /**
     * Afficher un devis spécifique
     */
    public function show(string $id)
    {
        $quote = Quote::with('items')->findOrFail($id);
        $serviceTypes = Quote::SERVICE_TYPES;
        $statuses = Quote::STATUSES;
        return view('admins.quotes.show', compact('quote', 'serviceTypes', 'statuses'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit(string $id)
    {
        $quote = Quote::with('items')->findOrFail($id);
        $serviceTypes = Quote::SERVICE_TYPES;
        $statuses = Quote::STATUSES;
        return view('admins.quotes.edit', compact('quote', 'serviceTypes', 'statuses'));
    }

    /**
     * Mettre à jour un devis
     */
    public function update(Request $request, string $id)
    {
        $quote = Quote::findOrFail($id);

        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'nullable|string|max:50',
            'service_type' => 'required|in:transit_douane,tierce_detention,representation_commerciale,transport_logistique,entreposage',
            'description' => 'required|string',
            'valid_until' => 'nullable|date|after:today',
            'status' => 'required|in:draft,sent,accepted,rejected',
            'admin_notes' => 'nullable|string',
            'items' => 'nullable|array',
            'items.*.id' => 'nullable|exists:quote_items,id',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'deleted_items' => 'nullable|array',
            'deleted_items.*' => 'nullable|exists:quote_items,id'  // ✅ AJOUTER nullable
        ]);

        // Mettre à jour le devis
        $quote->update($request->except('items', 'deleted_items'));

        // Supprimer les lignes sélectionnées
        if ($request->has('deleted_items')) {
            $quote->items()->whereIn('id', $request->deleted_items)->delete();
        }

        // Mettre à jour ou créer les lignes
        if ($request->has('items')) {
            foreach ($request->items as $itemData) {
                if (isset($itemData['id'])) {
                    // Mettre à jour une ligne existante
                    $item = $quote->items()->find($itemData['id']);
                    if ($item) {
                        $item->update([
                            'description' => $itemData['description'],
                            'quantity' => $itemData['quantity'],
                            'unit_price' => $itemData['unit_price'],
                            'total' => $itemData['quantity'] * $itemData['unit_price']
                        ]);
                    }
                } else {
                    // Créer une nouvelle ligne
                    $quote->items()->create([
                        'description' => $itemData['description'],
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $itemData['unit_price'],
                        'total' => $itemData['quantity'] * $itemData['unit_price']
                    ]);
                }
            }
        }

        return redirect()->route('admins.quotes.index')
            ->with('success', 'Devis mis à jour avec succès !');
    }

    /**
     * Supprimer un devis
     */
    public function destroy(string $id)
    {
        $quote = Quote::findOrFail($id);
        $quote->delete();

        return redirect()->route('admins.quotes.index')
            ->with('success', 'Devis supprimé avec succès !');
    }

    /**
     * Changer le statut d'un devis
     */
    public function changeStatus(Request $request, string $id)
    {
        $quote = Quote::findOrFail($id);

        $request->validate([
            'status' => 'required|in:draft,sent,accepted,rejected'
        ]);

        $quote->status = $request->status;
        $quote->save();

        $statusLabel = Quote::STATUSES[$request->status] ?? $request->status;

        return redirect()->route('admins.quotes.index')
            ->with('success', "Statut du devis mis à jour : {$statusLabel}");
    }

    /**
     * Exporter un devis en PDF
     */
    public function exportPdf(string $id)
    {
        $quote = Quote::with('items')->findOrFail($id);

        // Générer le PDF
        $pdf = Pdf::loadView('admins.quotes.pdf', compact('quote'));

        // Télécharger le PDF
        return $pdf->download('devis-' . $quote->id . '.pdf');

        // OU : Afficher dans le navigateur
        // return $pdf->stream('devis-' . $quote->id . '.pdf');
    }
}
