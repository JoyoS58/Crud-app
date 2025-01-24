@extends('layouts.appUser')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <!-- Page Header -->
        <div class="text-center mb-5">
            <h1 class="display-4 font-weight-bold text-primary">
                <i class="fas fa-edit"></i> Edit Activity: {{ $activity->activity_name }}
            </h1>
            <p class="lead text-muted">Update the activity details below.</p>
        </div>

        <form action="{{ route('userActivities.update', $activity->activity_id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Activity Name -->
            <div class="mb-4">
                <label for="activity_name" class="form-label font-weight-bold">Activity Name</label>
                <input type="text" class="form-control @error('activity_name') is-invalid @enderror" id="activity_name"
                    name="activity_name" value="{{ old('activity_name', $activity->activity_name) }}" required>
                @error('activity_name')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- Group Selection -->
            <div class="mb-4">
                <label for="group_id" class="form-label font-weight-bold">Group</label>
                <select class="form-select @error('group_id') is-invalid @enderror" id="group_id" name="group_id">
                    <option value="">Select Group</option>
                    @foreach ($groups as $group)
                        <option value="{{ $group->group_id }}"
                            {{ $group->group_id == $activity->group_id ? 'selected' : '' }}>
                            {{ $group->group_name }}
                        </option>
                    @endforeach
                </select>
                @error('group_id')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- User ID (Hidden) -->
            <input type="hidden" name="user_id" value="{{ auth()->user()->user_id }}">

            <!-- Activity Description -->
            <div class="mb-4">
                <label for="description" class="form-label font-weight-bold">Activity Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $activity->description) }}</textarea>
                @error('description')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>

            <!-- File Field -->
            <div class="mb-4">
                <label for="file" class="form-label font-weight-bold">File Attachment</label>
                <input type="file" name="file" id="file" accept=".pdf,.jpg,.jpeg,.png"
                    class="form-control @error('file') is-invalid @enderror">
                @error('file')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror

                <!-- Show Existing File -->
                @if (!empty($activity->file))
                    <div class="mt-3">
                        @if (in_array(pathinfo($activity->file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                            <img src="{{ $activity->file_path }}" alt="File Preview" class="img-fluid"
                                style="max-width: 200px;">
                        @else
                            <a href="{{ $activity->file_path }}" target="_blank">View Current File</a>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('userActivities.index') }}" class="btn btn-secondary px-4 py-2">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
                <button type="submit" class="btn btn-warning px-4 py-2">
                    <i class="fas fa-save"></i> Update Activity
                </button>
            </div>
        </form>
    </div>
    </div>
    </div>
@endsection

@section('styles')
    <style>
        /* Form and Card Styling */
        .form-control,
        .form-select {
            border-radius: 8px;
            font-size: 1rem;
            padding: 12px 16px;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.8);
            border-color: #007bff;
        }

        .card {
            border-radius: 12px;
            border: 1px solid #007bff;
        }

        .card-body {
            padding: 2rem;
        }

        /* Title and form heading */
        .display-4 {
            font-size: 2.5rem;
        }

        .form-label {
            font-size: 1.1rem;
            font-weight: bold;
        }

        /* Buttons */
        .btn {
            font-size: 1rem;
            font-weight: 600;
            padding: 12px 24px;
        }

        /* Error messages */
        .invalid-feedback {
            font-size: 0.9rem;
            color: #dc3545;
        }

        .text-danger {
            font-size: 0.9rem;
        }

        /* Spacing between fields */
        .mb-4 {
            margin-bottom: 1.5rem;
        }

        /* Adjust spacing for submit button */
        .btn-primary,
        .btn-secondary {
            font-size: 1rem;
            font-weight: 600;
            padding: 12px 30px;
        }

        /* Align form inputs and buttons for symmetry */
        .form-select,
        .form-control {
            width: 100%;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Align form container */
        .card-body {
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
@endsection
