@extends('layouts.master')
@section('title', 'Marksheet')

@section('content')
@php
    $student = $result->enrollment->student;
    $schoolName = config('app.name') === 'Laravel' ? 'School Management System' : config('app.name');
    $examName = $result->examSubject->exam->name ?? 'Examination';
    $sessionName = $result->enrollment->studentSession->name
        ?? $result->examSubject->exam->session->name
        ?? '-';
    $totalObtained = $examResults->sum(fn ($item) => (float) $item->obtained_marks);
    $totalFullMarks = $examResults->sum(fn ($item) => (float) $item->examSubject->full_marks);
    $percentage = $totalFullMarks > 0 ? ($totalObtained / $totalFullMarks) * 100 : 0;
    $overallGrade = match (true) {
        $examResults->contains(fn ($item) => $item->status === 'absent') => 'F',
        $examResults->contains(fn ($item) => $item->status === 'fail') => 'F',
        $percentage >= 80 => 'A+',
        $percentage >= 70 => 'A',
        $percentage >= 60 => 'A-',
        $percentage >= 50 => 'B',
        $percentage >= 40 => 'C',
        $percentage >= 33 => 'D',
        default => 'F',
    };
    $gradePoint = match ($overallGrade) {
        'A+' => 5.00,
        'A' => 4.00,
        'A-' => 3.50,
        'B' => 3.00,
        'C' => 2.00,
        'D' => 1.00,
        default => 0.00,
    };
@endphp

<style>
    .marksheet-print { display: none; }
    .marksheet-preview {
        max-width: 980px;
        margin: 0 auto;
        background: #fff;
        border: 8px double #1f6b3a;
        color: #111;
    }

    @media print {
        @page { size: A4 portrait; margin: 10mm; }
        body * { visibility: hidden !important; }
        #marksheet-print, #marksheet-print * { visibility: visible !important; }
        #marksheet-print {
            display: block !important;
            position: absolute;
            inset: 0;
            width: 100%;
            min-height: 275mm;
            box-sizing: border-box;
            color: #111;
            background: #fff;
            border: 8px double #1f6b3a;
            outline: 2px solid #1f6b3a;
            outline-offset: -14px;
            padding: 12mm 12mm 8mm;
            font-family: Arial, sans-serif;
        }
        #marksheet-print h1,
        #marksheet-print h2,
        #marksheet-print h3,
        #marksheet-print p { margin: 0; }
        .no-print { display: none !important; }
        .marksheet-print, .marksheet-print * {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }

    .marksheet-header { text-align: center; border-bottom: 2px solid #1f6b3a; padding-bottom: 10px; }
    .marksheet-header h1 { color: #17572d; font-size: 28px; font-weight: 700; }
    .marksheet-header h2 { margin-top: 4px; font-size: 18px; }
    .marksheet-header p { margin: 4px 0 0; font-size: 14px; }
    .marksheet-title {
        display: inline-block;
        margin: 12px 0;
        padding: 5px 24px;
        border: 1px solid #1f6b3a;
        font-weight: 700;
        color: #17572d;
    }
    .marksheet-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px 24px;
        margin: 12px 0 14px;
        font-size: 14px;
    }
    .marksheet-table { width: 100%; border-collapse: collapse; margin-top: 8px; }
    .marksheet-table th,
    .marksheet-table td { border: 1px solid #555; padding: 7px; text-align: center; }
    .marksheet-table th { background: #eaf4ed !important; color: #17572d; }
    .marksheet-table td:first-child,
    .marksheet-table th:first-child { text-align: left; }
    .marksheet-summary {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 8px;
        margin-top: 12px;
    }
    .marksheet-summary div { border: 1px solid #555; padding: 8px; text-align: center; }
    .marksheet-signatures {
        display: flex;
        justify-content: space-between;
        margin-top: 44px;
    }
    .marksheet-signatures div {
        width: 34%;
        border-top: 1px solid #111;
        text-align: center;
        padding-top: 5px;
        font-size: 13px;
    }
</style>

<div class="container-fluid px-3 px-lg-4 py-4">
    <article id="marksheet-print" class="marksheet-print">
        <header class="marksheet-header">
            <h1>{{ $schoolName }}</h1>
            <h2>Bangladesh</h2>
            <p>Academic Transcript / Marksheet</p>
            <div class="marksheet-title">{{ strtoupper($examName) }}</div>
        </header>

        <section class="marksheet-info">
            <div><strong>Student Name:</strong> {{ $student->name ?? 'N/A' }}</div>
            <div><strong>Roll No:</strong> {{ $result->enrollment->roll_no ?? '-' }}</div>
            <div><strong>Class:</strong> {{ $result->enrollment->classRoom->name ?? '-' }}</div>
            <div><strong>Section:</strong> {{ $result->enrollment->section->name ?? '-' }}</div>
            <div><strong>Academic Session:</strong> {{ $sessionName }}</div>
            <div><strong>Birth Certificate:</strong> {{ $student->birth_certificate ?? '-' }}</div>
        </section>

        <table class="marksheet-table">
            <thead>
                <tr>
                    <th style="width: 32%">Subject</th>
                    <th>Full Marks</th>
                    <th>Pass Marks</th>
                    <th>Obtained</th>
                    <th>Grade</th>
                    <th>GPA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($examResults as $examResult)
                    <tr>
                        <td>{{ $examResult->examSubject->subject->name ?? '-' }}</td>
                        <td>{{ number_format($examResult->examSubject->full_marks, 0) }}</td>
                        <td>{{ number_format($examResult->examSubject->pass_marks, 0) }}</td>
                        <td>{{ number_format($examResult->obtained_marks, 2) }}</td>
                        <td>{{ $examResult->grade }}</td>
                        <td>{{ number_format($examResult->grade_point, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <section class="marksheet-summary">
            <div><strong>Total Marks</strong><br>{{ number_format($totalObtained, 2) }} / {{ number_format($totalFullMarks, 0) }}</div>
            <div><strong>Percentage</strong><br>{{ number_format($percentage, 2) }}%</div>
            <div><strong>Grade</strong><br>{{ $overallGrade }}</div>
            <div><strong>GPA</strong><br>{{ number_format($gradePoint, 2) }}</div>
        </section>

        <div class="marksheet-signatures">
            <div>Guardian / Student</div>
            <div>Class Teacher</div>
            <div>Head Teacher / Principal</div>
        </div>
    </article>

    <div class="page-heading no-print">
        <div class="page-heading-copy">
            <span class="page-icon"><i class="bi bi-award"></i></span>
            <div><h1 class="h3 mb-1">Marksheet Details</h1></div>
        </div>
        <div class="heading-actions">
            <button type="button" onclick="window.print()" class="btn btn-outline-dark btn-sm">
                <i class="bi bi-printer"></i> Print Marksheet
            </button>
            <a href="{{ route('results.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <section class="panel mt-3 no-print">
        <div class="card-body">
            <div class="marksheet-preview p-4 p-lg-5">
                <header class="marksheet-header">
                    <h1>{{ $schoolName }}</h1>
                    <h2>Bangladesh</h2>
                    <p>Academic Transcript / Marksheet</p>
                    <div class="marksheet-title">{{ strtoupper($examName) }}</div>
                </header>

                <section class="marksheet-info">
                    <div><strong>Student Name:</strong> {{ $student->name ?? 'N/A' }}</div>
                    <div><strong>Roll No:</strong> {{ $result->enrollment->roll_no ?? '-' }}</div>
                    <div><strong>Class:</strong> {{ $result->enrollment->classRoom->name ?? '-' }}</div>
                    <div><strong>Section:</strong> {{ $result->enrollment->section->name ?? '-' }}</div>
                    <div><strong>Academic Session:</strong> {{ $sessionName }}</div>
                    <div><strong>Birth Certificate:</strong> {{ $student->birth_certificate ?? '-' }}</div>
                </section>

                <table class="marksheet-table">
                    <thead>
                        <tr>
                            <th style="width: 32%">Subject</th>
                            <th>Full Marks</th>
                            <th>Pass Marks</th>
                            <th>Obtained</th>
                            <th>Grade</th>
                            <th>GPA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($examResults as $examResult)
                            <tr>
                                <td>{{ $examResult->examSubject->subject->name ?? '-' }}</td>
                                <td>{{ number_format($examResult->examSubject->full_marks, 0) }}</td>
                                <td>{{ number_format($examResult->examSubject->pass_marks, 0) }}</td>
                                <td>{{ number_format($examResult->obtained_marks, 2) }}</td>
                                <td>{{ $examResult->grade }}</td>
                                <td>{{ number_format($examResult->grade_point, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <section class="marksheet-summary">
                    <div><strong>Total Marks</strong><br>{{ number_format($totalObtained, 2) }} / {{ number_format($totalFullMarks, 0) }}</div>
                    <div><strong>Percentage</strong><br>{{ number_format($percentage, 2) }}%</div>
                    <div><strong>Grade</strong><br>{{ $overallGrade }}</div>
                    <div><strong>GPA</strong><br>{{ number_format($gradePoint, 2) }}</div>
                </section>

                <div class="marksheet-signatures">
                    <div>Guardian / Student</div>
                    <div>Class Teacher</div>
                    <div>Head Teacher / Principal</div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('results.edit', $result) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('results.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </section>
</div>
@endsection
