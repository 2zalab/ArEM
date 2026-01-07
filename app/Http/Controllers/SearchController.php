<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentType;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::where('status', 'published');

        if ($request->has('q') && $request->q) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('abstract', 'like', "%{$searchTerm}%")
                    ->orWhereJsonContains('keywords', $searchTerm);
            });
        }

        if ($request->has('author') && $request->author) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->author}%");
            });
        }

        if ($request->has('type') && $request->type) {
            $query->where('document_type_id', $request->type);
        }

        if ($request->has('department') && $request->department) {
            $query->where('department_id', $request->department);
        }

        if ($request->has('year_from') && $request->year_from) {
            $query->where('year', '>=', $request->year_from);
        }

        if ($request->has('year_to') && $request->year_to) {
            $query->where('year', '<=', $request->year_to);
        }

        if ($request->has('language') && $request->language) {
            $query->where('language', $request->language);
        }

        $documents = $query->with(['user', 'department', 'documentType'])
            ->orderBy('published_at', 'desc')
            ->paginate(20);

        $documentTypes = DocumentType::where('is_active', true)->get();
        $departments = Department::where('is_active', true)->get();

        return view('search.index', compact('documents', 'documentTypes', 'departments'));
    }

    public function advanced()
    {
        $documentTypes = DocumentType::where('is_active', true)->get();
        $departments = Department::where('is_active', true)->get();

        return view('search.advanced', compact('documentTypes', 'departments'));
    }
}
