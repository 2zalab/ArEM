<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CVController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.cv', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'birth_date' => 'nullable|date',
            'birth_place' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'linkedin' => 'nullable|url',
            'orcid' => 'nullable|string|max:255',
            'google_scholar' => 'nullable|url',
        ]);

        $user = Auth::user();

        // Mise à jour des champs simples
        $user->update([
            'birth_date' => $request->birth_date,
            'birth_place' => $request->birth_place,
            'nationality' => $request->nationality,
            'address' => $request->address,
            'linkedin' => $request->linkedin,
            'orcid' => $request->orcid,
            'google_scholar' => $request->google_scholar,
        ]);

        // Mise à jour des champs JSON
        $user->education = $request->education ?? null;
        $user->experience = $request->experience ?? null;
        $user->skills = $request->skills ?? null;
        $user->languages = $request->languages ?? null;
        $user->publications = $request->publications ?? null;
        $user->certifications = $request->certifications ?? null;
        $user->references = $request->references ?? null;

        $user->save();

        return redirect()->route('profile.cv')->with('success', 'CV mis à jour avec succès');
    }

    public function export()
    {
        $user = Auth::user();

        $pdf = Pdf::loadView('profile.cv-pdf', compact('user'));

        return $pdf->download('CV-' . str_replace(' ', '-', $user->name) . '.pdf');
    }
}
