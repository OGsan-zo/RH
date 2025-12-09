<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentRh;
use App\Models\Employe;
use App\Models\TypeDocument;

class DocumentRhController extends Controller
{
    public function index()
    {
        $documents = DocumentRh::with(['employe.candidat', 'typeDocument'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('rh.documents-rh.index', compact('documents'));
    }

    public function create()
    {
        $employes = Employe::with('candidat')->get();
        $types = TypeDocument::all();
        return view('rh.documents-rh.create', compact('employes', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employe_id' => 'required|exists:employes,id',
            'type_document_id' => 'required|exists:types_documents,id',
            'nom_fichier' => 'required|string',
            'chemin_fichier' => 'required|string',
            'type_mime' => 'nullable|string',
            'taille_bytes' => 'nullable|integer|min:0',
            'date_emission' => 'nullable|date',
            'date_expiration' => 'nullable|date',
            'valide' => 'nullable|boolean',
            'remarques' => 'nullable|string'
        ]);

        DocumentRh::create($validated);
        return redirect()->route('documents-rh.index')->with('success', 'Document ajouté avec succès');
    }

    public function show($id)
    {
        $document = DocumentRh::with(['employe.candidat', 'typeDocument'])->findOrFail($id);
        return view('rh.documents-rh.show', compact('document'));
    }

    public function edit($id)
    {
        $document = DocumentRh::findOrFail($id);
        $employes = Employe::with('candidat')->get();
        $types = TypeDocument::all();
        return view('rh.documents-rh.edit', compact('document', 'employes', 'types'));
    }

    public function update(Request $request, $id)
    {
        $document = DocumentRh::findOrFail($id);
        
        $validated = $request->validate([
            'type_document_id' => 'required|exists:types_documents,id',
            'nom_fichier' => 'required|string',
            'chemin_fichier' => 'required|string',
            'type_mime' => 'nullable|string',
            'taille_bytes' => 'nullable|integer|min:0',
            'date_emission' => 'nullable|date',
            'date_expiration' => 'nullable|date',
            'valide' => 'nullable|boolean',
            'remarques' => 'nullable|string'
        ]);

        $document->update($validated);
        return redirect()->route('documents-rh.index')->with('success', 'Document mis à jour');
    }

    public function destroy($id)
    {
        DocumentRh::findOrFail($id)->delete();
        return redirect()->route('documents-rh.index')->with('success', 'Document supprimé');
    }
}
