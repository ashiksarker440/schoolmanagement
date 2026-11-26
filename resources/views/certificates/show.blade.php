@extends('layouts.master')
@section('title', 'Certificate Details')

@section('content')
    <style>
        .certificate-print {
            display: none;
        }

        .certificate-screen {
            max-width: 920px;
            margin: 0 auto;
            border: 10px double #006a4e;
            outline: 2px solid #d20a11;
            outline-offset: -18px;
            background: #fffdf5;
            color: #1d211f;
            min-height: 360px;
        }

        .certificate-screen .govt-name {
            color: #006a4e;
        }

        .certificate-screen .certificate-title {
            color: #d20a11;
        }

        .certificate-screen strong {
            color: #006a4e;
        }

        .govt-seal {
            width: 82px;
            height: 82px;
            margin: 12px auto 0;
            border: 3px solid #006a4e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #d20a11;
            text-align: center;
            font-size: 10px;
            font-weight: 700;
            line-height: 1.25;
            box-shadow: inset 0 0 0 4px #fffdf5, inset 0 0 0 5px #d20a11;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 12mm;
            }

            body * {
                visibility: hidden !important;
            }

            #certificate-print,
            #certificate-print * {
                visibility: visible !important;
            }

            #certificate-print {
                display: block !important;
                position: absolute;
                inset: 0;
                width: 100%;
                min-height: 260mm;
                box-sizing: border-box;
                color: #1d211f;
                background: #fffdf5;
                border: 10px double #006a4e;
                outline: 2px solid #d20a11;
                outline-offset: -18px;
                padding: 18mm 16mm 12mm;
                font-family: "Times New Roman", "Noto Serif Bengali", serif;
            }

            #certificate-print h1,
            #certificate-print h2,
            #certificate-print h3,
            #certificate-print p {
                margin: 0;
            }

            .certificate-header {
                text-align: center;
                padding-bottom: 12px;
            }

            .certificate-header h1 {
                font-size: 28px;
                color: #006a4e;
                font-weight: 700;
            }

            .certificate-header h2 {
                margin-top: 5px;
                font-size: 17px;
                color: #d20a11;
            }

            .certificate-header p {
                margin-top: 4px;
                font-size: 13px;
                color: #4c554f;
            }

            .govt-seal {
                width: 82px;
                height: 82px;
                margin: 12px auto 0;
                border: 3px solid #006a4e;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #d20a11;
                text-align: center;
                font-size: 10px;
                font-weight: 700;
                line-height: 1.25;
                box-shadow: inset 0 0 0 4px #fffdf5, inset 0 0 0 5px #d20a11;
            }

            .certificate-title {
                width: 220px;
                margin: 18px auto 20px;
                text-align: center;
                border-bottom: 2px solid #d20a11;
                padding-bottom: 5px;
                color: #d20a11;
                font-size: 22px;
                font-weight: 700;
            }

            .certificate-number {
                display: flex;
                justify-content: space-between;
                font-size: 13px;
                margin-bottom: 16px;
            }

            .certificate-body {
                font-size: 17px;
                line-height: 2;
                text-align: justify;
            }

            .certificate-body strong {
                border-bottom: 1px dotted #006a4e;
                padding: 0 4px;
                color: #006a4e;
            }

            .certificate-remarks {
                margin-top: 12px;
                font-size: 15px;
                min-height: 25px;
            }

            .certificate-signatures {
                display: flex;
                justify-content: space-between;
                margin-top: 48px;
            }

            .certificate-signatures div {
                width: 35%;
                border-top: 1px solid #111;
                text-align: center;
                padding-top: 6px;
                font-size: 14px;
            }

            .no-print {
                display: none !important;
            }

            .certificate-print,
            .certificate-print * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>

    <div class="container-fluid px-3 px-lg-4 py-4">
        @php
            $student = $certificate->enrollment->student;
            $schoolName = config('app.name') === 'Laravel' ? 'School Management System' : config('app.name');
            $typeLabel = $types[$certificate->type] ?? $certificate->type;
            $certificateText = match ($certificate->type) {
                'character' => 'character and good conduct',
                'result' => 'satisfactory academic result',
                'transfer' => 'completion of the transfer formalities',
                default => 'good conduct and satisfactory academic performance',
            };
        @endphp

        <article id="certificate-print" class="certificate-print">
            <header class="certificate-header">
                <p style="font-size: 14px; color: #006a4e;">The Government of the People's Republic of Bangladesh</p>
                <h1>{{ $schoolName }}</h1>
                <h2>{{ strtoupper($typeLabel) }}</h2>
                <p>Government Recognized School &nbsp;|&nbsp; Bangladesh &nbsp;|&nbsp; Official Certificate</p>
            </header>

            
            <div class="certificate-title">{{ strtoupper($typeLabel) }}</div>

            <div class="certificate-number">
                <span><strong>Certificate No:</strong> {{ $certificate->certificate_no }}</span>
                <span><strong>Issue Date:</strong> {{ $certificate->issue_date?->format('d/m/Y') ?? '-' }}</span>
            </div>

            <div class="certificate-body">
                This is to certify that <strong>{{ $student->name ?? 'N/A' }}</strong>,
                @if($student && $student->father_name)
                    son/daughter of <strong>{{ $student->father_name }}</strong>,
                @endif
                bearing Roll No. <strong>{{ $certificate->enrollment->roll_no ?? '-' }}</strong>,
                was a student of <strong>Class {{ $certificate->enrollment->classRoom->name ?? '-' }}</strong>,
                Section <strong>{{ $certificate->enrollment->section->name ?? '-' }}</strong>,
                and Academic Session <strong>{{ $certificate->enrollment->studentSession->name ?? '-' }}</strong>.
                The student is found to be of <strong>{{ $certificateText }}</strong>.
                @if($student && $student->date_of_birth)
                    Date of Birth: <strong>{{ $student->date_of_birth->format('d/m/Y') }}</strong>.
                @endif
                We wish every success in the student's future life.
            </div>

            @if($certificate->remarks)
                <p class="certificate-remarks"><strong>Remarks:</strong> {{ $certificate->remarks }}</p>
            @endif

            <div class="certificate-signatures">
                <div>Guardian / Student</div>
                <div>Head Teacher / Principal</div>
            </div>
        </article>

        <div class="page-heading no-print">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-file-earmark-text"></i></span>
                <div>
                    <h1 class="h3 mb-1">Certificate Details</h1>
                </div>
            </div>
            <div class="heading-actions">
                <button onclick="window.print()" class="btn btn-outline-dark btn-sm">
                    <i class="bi bi-printer"></i> Print
                </button>
                <a href="{{ route('certificates.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <section class="panel mt-3 no-print">
            <div class="card-body">
                <div class="certificate-screen p-4 p-lg-5">
                    <div class="text-center mb-4">
                        <div class="fw-bold govt-name mb-1">The Government of the People's Republic of Bangladesh</div>
                        <h2 class="h4 govt-name mb-1">{{ $schoolName }}</h2>
                        <div class="text-danger">&nbsp;&nbsp; Bangladesh</div>
                        <h3 class="h5 mt-3 text-uppercase certificate-title" style="letter-spacing: 1px;">{{ $typeLabel }}</h3>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <span><strong>Certificate No:</strong> {{ $certificate->certificate_no }}</span>
                        <span><strong>Issue Date:</strong> {{ $certificate->issue_date?->format('d/m/Y') ?? '-' }}</span>
                    </div>
                    <p class="lh-lg fs-5">
                        This is to certify that <strong>{{ $student->name ?? 'N/A' }}</strong>,
                        bearing Roll No. <strong>{{ $certificate->enrollment->roll_no ?? '-' }}</strong>,
                        was a student of <strong>Class {{ $certificate->enrollment->classRoom->name ?? '-' }}</strong>,
                        Section <strong>{{ $certificate->enrollment->section->name ?? '-' }}</strong>,
                        and Academic Session <strong>{{ $certificate->enrollment->studentSession->name ?? '-' }}</strong>.
                        The student is found to be of <strong>{{ $certificateText }}</strong>.
                    </p>
                    @if($certificate->remarks)
                        <p class="mt-3"><strong>Remarks:</strong> {{ $certificate->remarks }}</p>
                    @endif
                    <div class="d-flex justify-content-between mt-5 pt-4">
                        <div class="border-top pt-2 px-4">Guardian / Student</div>
                        <div class="border-top pt-2 px-4">Head Teacher / Principal</div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('certificates.edit', $certificate) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('certificates.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </section>
    </div>
@endsection