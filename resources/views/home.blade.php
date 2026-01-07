@extends('layouts.app')

@section('title', 'ArEM - Plateforme d\'Archives ENS Maroua')

@section('content')
<div class="row mb-5">
    <div class="col-12 text-center">
        <h1 class="display-4 mb-3">Bienvenue sur ArEM</h1>
        <p class="lead">Plateforme d'Archives de l'École Normale Supérieure de Maroua</p>
        <p>Accédez aux productions académiques de l'ENS de Maroua : mémoires, thèses, articles scientifiques et bien plus.</p>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-file-earmark-text fs-1 text-primary"></i>
                <h3 class="mt-3">{{ $statistics['total_documents'] }}</h3>
                <p class="text-muted">Documents archivés</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-people fs-1 text-primary"></i>
                <h3 class="mt-3">{{ $statistics['total_authors'] }}</h3>
                <p class="text-muted">Auteurs</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-building fs-1 text-primary"></i>
                <h3 class="mt-3">{{ $statistics['total_departments'] }}</h3>
                <p class="text-muted">Départements</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-download fs-1 text-primary"></i>
                <h3 class="mt-3">{{ $statistics['total_downloads'] }}</h3>
                <p class="text-muted">Téléchargements</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <h3 class="mb-3">Documents récents</h3>
        @forelse($recentDocuments as $document)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('documents.show', $document->arem_doc_id) }}">{{ $document->title }}</a>
                    </h5>
                    <p class="card-text text-muted">
                        {{ Str::limit($document->abstract, 200) }}
                    </p>
                    <small class="text-muted">
                        <i class="bi bi-person"></i> {{ $document->user->name }} |
                        <i class="bi bi-calendar"></i> {{ $document->year }} |
                        <i class="bi bi-tag"></i> {{ $document->documentType->name }}
                    </small>
                </div>
            </div>
        @empty
            <p class="text-muted">Aucun document disponible pour le moment.</p>
        @endforelse
    </div>

    <div class="col-md-4">
        <h3 class="mb-3">Accès rapide</h3>
        <div class="list-group mb-4">
            <a href="{{ route('documents.create') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-plus-circle"></i> Déposer un document
            </a>
            <a href="{{ route('documents.browse', ['by' => 'type']) }}" class="list-group-item list-group-item-action">
                <i class="bi bi-folder"></i> Par type de document
            </a>
            <a href="{{ route('documents.browse', ['by' => 'department']) }}" class="list-group-item list-group-item-action">
                <i class="bi bi-building"></i> Par département
            </a>
            <a href="{{ route('documents.browse', ['by' => 'year']) }}" class="list-group-item list-group-item-action">
                <i class="bi bi-calendar"></i> Par année
            </a>
        </div>

        <h4 class="mb-3">Documents populaires</h4>
        @foreach($popularDocuments as $document)
            <div class="mb-3">
                <a href="{{ route('documents.show', $document->arem_doc_id) }}" class="text-decoration-none">
                    <strong>{{ Str::limit($document->title, 60) }}</strong>
                </a>
                <br>
                <small class="text-muted">{{ $document->getTotalViews() }} vues</small>
            </div>
        @endforeach
    </div>
</div>
@endsection
