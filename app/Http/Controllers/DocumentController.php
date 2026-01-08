<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Department;
use App\Models\Notification;
use App\Services\PdfCoverService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::where('status', 'published')
            ->with(['user', 'department', 'documentType']);

        if ($request->has('type') && $request->type) {
            $query->where('document_type_id', $request->type);
        }

        if ($request->has('department') && $request->department) {
            $query->where('department_id', $request->department);
        }

        if ($request->has('year') && $request->year) {
            $query->where('year', $request->year);
        }

        $documents = $query->orderBy('published_at', 'desc')->paginate(20);
        $documentTypes = DocumentType::where('is_active', true)->get();
        $departments = Department::where('is_active', true)->get();

        return view('documents.index', compact('documents', 'documentTypes', 'departments'));
    }

    public function create()
    {
        $documentTypes = DocumentType::where('is_active', true)->get();
        $departments = Department::where('is_active', true)->get();

        return view('documents.create', compact('documentTypes', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'authors' => 'required|array|min:1',
            'authors.*.name' => 'required|string|max:255',
            'authors.*.institution' => 'nullable|string|max:255',
            'keywords' => 'required|array|min:1',
            'language' => 'required|string',
            'year' => 'required|integer',
            'document_type_id' => 'required|exists:document_types,id',
            'department_id' => 'nullable|exists:departments,id',
            'file' => 'required|file|mimes:pdf|max:20480',
            'access_rights' => 'required|in:public,restricted,embargo',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('documents', $fileName, 'private');

        // Préparer les données des auteurs
        $authors = array_values(array_filter($request->authors, function($author) {
            return !empty($author['name']);
        }));

        $document = Document::create([
            'user_id' => Auth::id(),
            'department_id' => $request->department_id ?? Auth::user()->department_id,
            'document_type_id' => $request->document_type_id,
            'title' => $request->title,
            'authors' => $authors,
            'abstract' => $request->abstract,
            'keywords' => $request->keywords,
            'language' => $request->language,
            'year' => $request->year,
            'academic_year' => $request->academic_year,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => 'pdf',
            'file_size' => $file->getSize(),
            'access_rights' => $request->access_rights,
            'embargo_date' => $request->embargo_date,
            'status' => 'pending',
        ]);

        foreach ($request->metadata ?? [] as $key => $value) {
            if ($value) {
                $document->setMetaValue($key, $value);
            }
        }

        return redirect()->route('documents.show', $document->arem_doc_id)
            ->with('success', 'Document soumis avec succès. En attente de validation.');
    }

    public function show($aremDocId)
    {
        $document = Document::where('arem_doc_id', $aremDocId)
            ->with(['user', 'department', 'documentType', 'metadata', 'validator'])
            ->firstOrFail();

        if ($document->status !== 'published' && (!Auth::check() || (Auth::user()->id !== $document->user_id && !Auth::user()->canValidateDocuments()))) {
            abort(403, 'Accès non autorisé');
        }

        $document->incrementViews();

        $totalViews = $document->getTotalViews();
        $totalDownloads = $document->getTotalDownloads();

        return view('documents.show', compact('document', 'totalViews', 'totalDownloads'));
    }

    public function edit($aremDocId)
    {
        $document = Document::where('arem_doc_id', $aremDocId)->firstOrFail();

        if (Auth::user()->id !== $document->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        if ($document->status === 'published') {
            return redirect()->route('documents.show', $document->arem_doc_id)
                ->with('error', 'Impossible de modifier un document publié');
        }

        $documentTypes = DocumentType::where('is_active', true)->get();
        $departments = Department::where('is_active', true)->get();

        return view('documents.edit', compact('document', 'documentTypes', 'departments'));
    }

    public function update(Request $request, $aremDocId)
    {
        $document = Document::where('arem_doc_id', $aremDocId)->firstOrFail();

        if (Auth::user()->id !== $document->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'abstract' => 'required|string',
            'authors' => 'nullable|array',
            'authors.*.name' => 'required_with:authors|string|max:255',
            'authors.*.institution' => 'nullable|string|max:255',
            'keywords' => 'required|array|min:1',
            'language' => 'required|string',
            'year' => 'required|integer',
            'file' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        // Préparer les données des auteurs
        $authors = null;
        if ($request->has('authors')) {
            $authors = array_values(array_filter($request->authors, function($author) {
                return !empty($author['name']);
            }));
        }

        $updateData = [
            'title' => $request->title,
            'abstract' => $request->abstract,
            'keywords' => $request->keywords,
            'language' => $request->language,
            'year' => $request->year,
            'academic_year' => $request->academic_year,
            'access_rights' => $request->access_rights,
            'embargo_date' => $request->embargo_date,
        ];

        if ($authors) {
            $updateData['authors'] = $authors;
        }

        $document->update($updateData);

        if ($request->hasFile('file')) {
            Storage::disk('private')->delete($document->file_path);

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('documents', $fileName, 'private');

            $document->update([
                'file_path' => $filePath,
                'file_name' => $fileName,
                'file_size' => $file->getSize(),
            ]);
        }

        foreach ($request->metadata ?? [] as $key => $value) {
            $document->setMetaValue($key, $value);
        }

        return redirect()->route('documents.show', $document->arem_doc_id)
            ->with('success', 'Document mis à jour avec succès');
    }

    public function destroy($aremDocId)
    {
        $document = Document::where('arem_doc_id', $aremDocId)->firstOrFail();

        if (Auth::user()->id !== $document->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Accès non autorisé');
        }

        Storage::disk('private')->delete($document->file_path);
        $document->delete();

        return redirect()->route('profile.documents')
            ->with('success', 'Document supprimé avec succès');
    }

    public function preview($aremDocId)
    {
        $document = Document::where('arem_doc_id', $aremDocId)->firstOrFail();

        // Check access permissions
        if (!$document->isAccessible() && (!Auth::check() || (Auth::user()->id !== $document->user_id && !Auth::user()->canValidateDocuments()))) {
            abort(403, 'Accès non autorisé');
        }

        $filePath = storage_path('app/private/' . $document->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'Fichier non trouvé');
        }

        // Générer le PDF avec page de garde
        $coverService = new PdfCoverService();
        $pdfWithCover = $coverService->addCoverPage($document, $filePath);

        // Retourner le PDF avec page de garde et le supprimer après envoi
        return response()->file($pdfWithCover, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $document->file_name . '"'
        ])->deleteFileAfterSend(true);
    }

    public function download($aremDocId)
    {
        $document = Document::where('arem_doc_id', $aremDocId)->firstOrFail();

        if (!$document->isAccessible() && (!Auth::check() || Auth::user()->id !== $document->user_id)) {
            abort(403, 'Accès restreint à ce document');
        }

        $document->incrementDownloads();

        $filePath = storage_path('app/private/' . $document->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'Fichier non trouvé');
        }

        // Générer le PDF avec page de garde
        $coverService = new PdfCoverService();
        $pdfWithCover = $coverService->addCoverPage($document, $filePath);

        // Retourner le PDF avec page de garde pour téléchargement
        return response()->download($pdfWithCover, $document->file_name, [
            'Content-Type' => 'application/pdf'
        ])->deleteFileAfterSend(true);
    }

    public function browse(Request $request)
    {
        $groupBy = $request->get('by', 'type');

        if ($groupBy === 'type') {
            $items = DocumentType::where('is_active', true)
                ->withCount(['documents' => function ($query) {
                    $query->where('status', 'published');
                }])
                ->get();
        } elseif ($groupBy === 'department') {
            $items = Department::where('is_active', true)
                ->withCount(['documents' => function ($query) {
                    $query->where('status', 'published');
                }])
                ->get();
        } elseif ($groupBy === 'year') {
            $items = Document::where('status', 'published')
                ->selectRaw('year, COUNT(*) as documents_count')
                ->groupBy('year')
                ->orderBy('year', 'desc')
                ->get();
        }

        return view('documents.browse', compact('items', 'groupBy'));
    }
}
