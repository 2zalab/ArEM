@extends('layouts.app')

@section('title', 'Parcourir les documents - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <h1 class="fw-bold mb-4">Parcourir les documents</h1>

    <div class="btn-group mb-4" role="group">
        <a href="{{ route('documents.browse', ['by' => 'type']) }}" class="btn btn-{{ $groupBy === 'type' ? '' : 'outline-' }}primary">
            Par type
        </a>
        <a href="{{ route('documents.browse', ['by' => 'department']) }}" class="btn btn-{{ $groupBy === 'department' ? '' : 'outline-' }}primary">
            Par département
        </a>
        <a href="{{ route('documents.browse', ['by' => 'year']) }}" class="btn btn-{{ $groupBy === 'year' ? '' : 'outline-' }}primary">
            Par année
        </a>
    </div>

    <div class="row g-4">
        @foreach($items as $item)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        @if($groupBy === 'year')
                            <h3 class="fw-bold text-primary">{{ $item->year }}</h3>
                            <p class="text-muted mb-0">{{ $item->documents_count }} document(s)</p>
                        @else
                            <h5 class="fw-bold mb-2">{{ $item->name }}</h5>
                            @if(isset($item->description))
                                <p class="text-muted small mb-3">{{ Str::limit($item->description, 100) }}</p>
                            @endif
                            <p class="mb-0">
                                <span class="badge bg-primary">{{ $item->documents_count }} document(s)</span>
                            </p>
                        @endif
                    </div>
                    <div class="card-footer bg-white border-top-0">
                        <a href="{{ route('documents.index', [$groupBy === 'type' ? 'type' : ($groupBy === 'department' ? 'department' : 'year') => $groupBy === 'year' ? $item->year : $item->id]) }}" class="btn btn-sm btn-outline-primary w-100">
                            Voir les documents
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
