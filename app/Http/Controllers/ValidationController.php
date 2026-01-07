<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\ValidationWorkflow;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->canValidateDocuments()) {
                abort(403, 'Accès non autorisé');
            }
            return $next($request);
        });
    }

    public function index()
    {
        $pendingDocuments = Document::where('status', 'pending')
            ->with(['user', 'department', 'documentType'])
            ->orderBy('created_at', 'asc')
            ->paginate(20);

        return view('validation.index', compact('pendingDocuments'));
    }

    public function show($aremDocId)
    {
        $document = Document::where('arem_doc_id', $aremDocId)
            ->with(['user', 'department', 'documentType', 'metadata', 'validationWorkflows.user'])
            ->firstOrFail();

        return view('validation.show', compact('document'));
    }

    public function approve(Request $request, $aremDocId)
    {
        $request->validate([
            'comment' => 'nullable|string',
        ]);

        $document = Document::where('arem_doc_id', $aremDocId)->firstOrFail();

        $document->update([
            'status' => 'published',
            'validated_by' => Auth::id(),
            'validated_at' => now(),
            'published_at' => now(),
        ]);

        ValidationWorkflow::create([
            'document_id' => $document->id,
            'user_id' => Auth::id(),
            'action' => 'approved',
            'comment' => $request->comment,
        ]);

        Notification::create([
            'user_id' => $document->user_id,
            'type' => 'document_validated',
            'title' => 'Document validé',
            'message' => "Votre document \"{$document->title}\" a été validé et publié.",
            'data' => ['document_id' => $document->id],
        ]);

        return redirect()->route('validation.index')
            ->with('success', 'Document validé et publié avec succès');
    }

    public function reject(Request $request, $aremDocId)
    {
        $request->validate([
            'comment' => 'required|string',
            'changes' => 'nullable|array',
        ]);

        $document = Document::where('arem_doc_id', $aremDocId)->firstOrFail();

        $document->update([
            'status' => 'rejected',
        ]);

        ValidationWorkflow::create([
            'document_id' => $document->id,
            'user_id' => Auth::id(),
            'action' => 'rejected',
            'comment' => $request->comment,
            'changes' => $request->changes,
        ]);

        Notification::create([
            'user_id' => $document->user_id,
            'type' => 'document_rejected',
            'title' => 'Document rejeté',
            'message' => "Votre document \"{$document->title}\" a été rejeté. Raison : {$request->comment}",
            'data' => ['document_id' => $document->id],
        ]);

        return redirect()->route('validation.index')
            ->with('success', 'Document rejeté');
    }

    public function requestRevision(Request $request, $aremDocId)
    {
        $request->validate([
            'comment' => 'required|string',
            'changes' => 'required|array',
        ]);

        $document = Document::where('arem_doc_id', $aremDocId)->firstOrFail();

        ValidationWorkflow::create([
            'document_id' => $document->id,
            'user_id' => Auth::id(),
            'action' => 'revision_requested',
            'comment' => $request->comment,
            'changes' => $request->changes,
        ]);

        Notification::create([
            'user_id' => $document->user_id,
            'type' => 'revision_requested',
            'title' => 'Révision demandée',
            'message' => "Des modifications sont demandées pour votre document \"{$document->title}\".",
            'data' => ['document_id' => $document->id],
        ]);

        return redirect()->route('validation.index')
            ->with('success', 'Demande de révision envoyée');
    }
}
