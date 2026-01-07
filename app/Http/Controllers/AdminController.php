<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use App\Models\Department;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    // User Management
    public function users()
    {
        $users = User::with('department')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $departments = Department::where('is_active', true)->get();
        return view('admin.users-edit', compact('user', 'departments'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,moderator,depositor,reader',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $user->update($request->only(['name', 'email', 'role', 'department_id']));

        return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour avec succès');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'Vous ne pouvez pas supprimer votre propre compte');
        }

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé avec succès');
    }

    // Department Management
    public function departments()
    {
        $departments = Department::withCount('documents')->orderBy('name')->get();
        return view('admin.departments', compact('departments'));
    }

    public function storeDepartment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:departments,code',
        ]);

        Department::create($request->only(['name', 'code']));

        return redirect()->route('admin.departments')->with('success', 'Département créé avec succès');
    }

    public function updateDepartment(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:departments,code,' . $id,
            'is_active' => 'boolean',
        ]);

        $department->update($request->only(['name', 'code', 'is_active']));

        return redirect()->route('admin.departments')->with('success', 'Département mis à jour avec succès');
    }

    public function deleteDepartment($id)
    {
        $department = Department::findOrFail($id);

        if ($department->documents()->count() > 0) {
            return redirect()->route('admin.departments')->with('error', 'Impossible de supprimer un département avec des documents');
        }

        $department->delete();

        return redirect()->route('admin.departments')->with('success', 'Département supprimé avec succès');
    }

    // Document Type Management
    public function documentTypes()
    {
        $documentTypes = DocumentType::withCount('documents')->orderBy('name')->get();
        return view('admin.document-types', compact('documentTypes'));
    }

    public function storeDocumentType(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:document_types,code',
            'required_fields' => 'nullable|json',
        ]);

        DocumentType::create($request->only(['name', 'code', 'required_fields']));

        return redirect()->route('admin.documentTypes')->with('success', 'Type de document créé avec succès');
    }

    public function updateDocumentType(Request $request, $id)
    {
        $documentType = DocumentType::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:document_types,code,' . $id,
            'required_fields' => 'nullable|json',
            'is_active' => 'boolean',
        ]);

        $documentType->update($request->only(['name', 'code', 'required_fields', 'is_active']));

        return redirect()->route('admin.documentTypes')->with('success', 'Type de document mis à jour avec succès');
    }

    public function deleteDocumentType($id)
    {
        $documentType = DocumentType::findOrFail($id);

        if ($documentType->documents()->count() > 0) {
            return redirect()->route('admin.documentTypes')->with('error', 'Impossible de supprimer un type de document avec des documents');
        }

        $documentType->delete();

        return redirect()->route('admin.documentTypes')->with('success', 'Type de document supprimé avec succès');
    }

    // Statistics
    public function statistics()
    {
        $stats = [
            'total_users' => User::count(),
            'total_documents' => Document::count(),
            'published_documents' => Document::where('status', 'published')->count(),
            'pending_documents' => Document::where('status', 'pending')->count(),
            'rejected_documents' => Document::where('status', 'rejected')->count(),
            'total_departments' => Department::count(),
            'total_document_types' => DocumentType::count(),
        ];

        $users_by_role = User::selectRaw('role, count(*) as count')
            ->groupBy('role')
            ->get();

        $documents_by_type = DocumentType::withCount('documents')
            ->orderBy('documents_count', 'desc')
            ->limit(10)
            ->get();

        $documents_by_department = Department::withCount('documents')
            ->orderBy('documents_count', 'desc')
            ->limit(10)
            ->get();

        $recent_users = User::orderBy('created_at', 'desc')->limit(10)->get();

        return view('admin.statistics', compact(
            'stats',
            'users_by_role',
            'documents_by_type',
            'documents_by_department',
            'recent_users'
        ));
    }
}
