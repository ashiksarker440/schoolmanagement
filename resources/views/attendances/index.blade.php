@extends('layouts.master')

@section('title', 'Index Attendance')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Attendance Management</h3>
            <a href="{{ route('attendances.create') }}" class="btn btn-primary">
                + Add Attendance
            </a>
        </div>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('attendances.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Attendance Date</label>

                            <input type="date" name="attendance_date" class="form-control"
                                value="{{ request('attendance_date') }}">
                        </div>
                        <div class="col-md-4">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="1" @selected(request('status') === '1')>
                                    Present
                                </option>
                                <option value="0" @selected(request('status') === '0')>
                                    Absent
                                </option>
                                <option value="2" @selected(request('status') === '2')>
                                    Late
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4 mt-4">
                            <button class="btn btn-primary">
                                Filter
                            </button>
                            <a href="{{ route('attendances.index') }}" class="btn btn-secondary">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Student Name</th>
                                <th>Roll</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Marked By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $key => $attendance)
                                <tr>
                                    <td>
                                        {{ $attendances->firstItem() + $key }}
                                    </td>

                                    <td>
                                        {{ $attendance->enrollment->student->name ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $attendance->enrollment->roll_no ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $attendance->attendance_date->format('d-m-Y') }}
                                    </td>
                                    <td>
                                        @if($attendance->status == 1)
                                            <span class="badge bg-success">
                                                Present
                                            </span>
                                        @elseif($attendance->status == 0)
                                            <span class="badge bg-danger">
                                                Absent
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                Late
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $attendance->markedBy->name ?? 'N/A' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('attendances.show', $attendance->id) }}" class="btn btn-info btn-sm">
                                            Show
                                        </a>
                                        <a href="{{ route('attendances.edit', $attendance->id) }}"
                                            class="btn btn-warning btn-sm">
                                            Edit
                                        </a>
                                        <form action="{{ route('attendances.destroy', $attendance->id) }}" method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this attendance?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        No Attendance Records Found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $attendances->links() }}
            </div>
        </div>
    </div>
@endsection