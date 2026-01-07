@extends('layouts.app')

@section('title', 'Notifications - ArEM')

@section('content')
<div class="container-fluid px-5 py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0"><i class="bi bi-bell me-2"></i>Notifications</h1>
        @if(auth()->user()->unreadNotificationsCount() > 0)
            <form action="{{ route('notifications.readAll') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-check-all me-2"></i>Tout marquer comme lu
                </button>
            </form>
        @endif
    </div>

    @php
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->paginate(20);
    @endphp

    @forelse($notifications as $notification)
        <div class="card mb-3 {{ $notification->is_read ? 'bg-light' : '' }}">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="flex-shrink-0 me-3">
                        @if($notification->type === 'document_validated')
                            <div class="rounded-circle bg-success bg-opacity-10 p-3">
                                <i class="bi bi-check-circle fs-4 text-success"></i>
                            </div>
                        @elseif($notification->type === 'document_rejected')
                            <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                                <i class="bi bi-x-circle fs-4 text-danger"></i>
                            </div>
                        @elseif($notification->type === 'revision_requested')
                            <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                                <i class="bi bi-pencil fs-4 text-warning"></i>
                            </div>
                        @else
                            <div class="rounded-circle bg-info bg-opacity-10 p-3">
                                <i class="bi bi-info-circle fs-4 text-info"></i>
                            </div>
                        @endif
                    </div>

                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="mb-1">
                                {{ $notification->title }}
                                @if(!$notification->is_read)
                                    <span class="badge bg-primary ms-2">Nouveau</span>
                                @endif
                            </h5>
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </div>

                        <p class="mb-2">{{ $notification->message }}</p>

                        <div class="d-flex gap-2">
                            @if(isset($notification->data['document_id']))
                                @php
                                    $document = \App\Models\Document::find($notification->data['document_id']);
                                @endphp
                                @if($document)
                                    <a href="{{ route('documents.show', $document->arem_doc_id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>Voir le document
                                    </a>
                                @endif
                            @endif

                            @if(!$notification->is_read)
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-check me-1"></i>Marquer comme lu
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-bell-slash fs-1 text-muted"></i>
                <h4 class="mt-3">Aucune notification</h4>
                <p class="text-muted">Vous n'avez reçu aucune notification pour le moment.</p>
            </div>
        </div>
    @endforelse

    <!-- Pagination -->
    @if($notifications->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
