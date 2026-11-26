<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\StudentEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with(['enrollment.student', 'issuer'])->latest()->paginate(15);
        $types = Certificate::types(); 
        return view('certificates.index', compact('certificates', 'types'));
    }

    public function create()
    {
        $enrollments = StudentEnrollment::with('student')->get();
        $types = Certificate::types();
        return view('certificates.create', compact('enrollments', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:student_enrollments,id',
            'type' => 'required|in:testimonial,character,result,transfer',
            'issue_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $validated['certificate_no'] = Certificate::generateCertificateNo();
        $validated['issued_by'] = Auth::id();

        Certificate::create($validated);

        return redirect()->route('certificates.index')
            ->with('success', 'Certificate created! Cert No: ' . $validated['certificate_no']);
    }

    public function show(Certificate $certificate)
    {
        $certificate->load([
            'enrollment.student',
            'enrollment.classRoom',
            'enrollment.section',
            'enrollment.studentSession',
            'issuer',
        ]);
        $types = Certificate::types();
        return view('certificates.show', compact('certificate', 'types'));
    }

    public function edit(Certificate $certificate)
    {
        $enrollments = StudentEnrollment::with('student')->get();
        $types = Certificate::types();
        return view('certificates.edit', compact('certificate', 'enrollments', 'types'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'enrollment_id' => 'required|exists:student_enrollments,id',
            'type' => 'required|in:testimonial,character,result,transfer',
            'issue_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $certificate->update($validated);

        return redirect()->route('certificates.index')
            ->with('success', 'Certificate updated!');
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        return redirect()->route('certificates.index')
            ->with('success', 'Certificate deleted!');
    }
}