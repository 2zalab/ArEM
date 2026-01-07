@extends('layouts.app')

@section('title', 'Recherche - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <h1 class="fw-bold mb-4">Résultats de recherche</h1>

    @if(request('q'))
        <p class="text-muted mb-4">
            Résultats pour : <strong>"{{ request('q') }}"</strong> ({{ $documents->total() }} document(s) trouvé(s))
        </p>
    @endif

    <!-- Documents List -->
    @forelse($documents as $document)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title mb-2">
                    <a href="{{ route('documents.show', $document->arem_doc_id) }}" class="text-decoration-none text-dark">
                        {{ $document->title }}
                    </a>
                </h5>
                <p class="card-text text-muted mb-3">
                    {{ Str::limit($document->abstract, 250) }}
                </p>
                <div class="d-flex flex-wrap gap-3 small text-muted">
                    <span><i class="bi bi-person me-1"></i>{{ $document->user->name }}</span>
                    <span><i class="bi bi-calendar me-1"></i>{{ $document->year }}</span>
                    <span><i class="bi bi-tag me-1"></i>{{ $document->documentType->name }}</span>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="bi bi-search fs-1 text-muted"></i>
            <p class="text-muted mt-3">Aucun résultat trouvé. Essayez d'autres mots-clés.</p>
            <a href="{{ route('search.advanced') }}" class="btn btn-primary">
                Recherche avancée
            </a>
        </div>
    @endforelse

    <!-- Pagination -->
    @if($documents->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $documents->links() }}
        </div>
    @endif
</div>
@endsection
