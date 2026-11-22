@extends('layouts.master')
@section('title', 'Show Attendance')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <h3>Attendance Details</h3>
            <a href="{{ route('attendances.index') }}" class="btn btn-secondary">
                Back
            </a>
        </div>
        <div class="card">
            <div class="card-header">
                Attendance Information
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Student Name</th>
                        <td>
                            {{ $attendance->enrollment->student->name ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Admission Number</th>
                        <td>
                            {{ $attendance->enrollment->student->admission_number ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Roll Number</th>
                        <td>
                            {{ $attendance->enrollment->roll_no ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Attendance Date</th>
                        <td>
                            {{ $attendance->attendance_date->format('d-m-Y') }}
                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            {{ $attendance->status_label }}
                        </td>
                    </tr>
                    <tr>
                        <th>Remarks</th>
                        <td>
                            {{ $attendance->remarks ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Marked By</th>
                        <td>
                            {{ $attendance->markedBy->name ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Updated By</th>
                        <td>
                            {{ $attendance->updatedBy->name ?? 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>
                            {{ $attendance->created_at->format('d-m-Y h:i A') }}
                        </td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>
                            {{ $attendance->updated_at->format('d-m-Y h:i A') }}
                        </td>
                    </tr>
                </table>
                <a href="{{ route('attendances.edit', $attendance->id) }}" class="btn btn-warning">
                    Edit Attendance
                </a>
            </div>
        </div>
    </div>
@endsection