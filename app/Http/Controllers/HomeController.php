<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Department;
use App\Models\DocumentType;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $statistics = [
            'total_documents' => Document::where('status', 'published')->count(),
            'total_authors' => User::where('role', 'depositor')->count(),
            'total_departments' => Department::where('is_active', true)->count(),
            'total_downloads' => Document::where('status', 'published')->get()->sum(fn($doc) => $doc->getTotalDownloads()),
        ];

        $recentDocuments = Document::where('status', 'published')
            ->with(['user', 'department', 'documentType'])
            ->orderBy('published_at', 'desc')
            ->limit(10)
            ->get();

        $popularDocuments = Document::where('status', 'published')
            ->with(['user', 'department', 'documentType'])
            ->get()
            ->sortByDesc(fn($doc) => $doc->getTotalViews())
            ->take(5);

        $documentTypes = DocumentType::where('is_active', true)->get();
        $departments = Department::where('is_active', true)->get();

        return view('home', compact('statistics', 'recentDocuments', 'popularDocuments', 'documentTypes', 'departments'));
    }

    public function about()
    {
        return view('about');
    }

    public function help()
    {
        return view('help');
    }

    public function contact()
    {
        return view('contact');
    }
}
