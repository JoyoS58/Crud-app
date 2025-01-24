@extends('layouts.appUser')

@section('content')
    <div class="card p-4 shadow-lg border-1">
        <!-- Page Title -->
        <div class="text-center mb-4">
            <h1 class="display-4 font-weight-bold text-primary">{{ $activity->activity_name }}</h1>
            <p class="text-muted">{{ $activity->description ?? 'No description available.' }}</p>
            <hr class="my-4" style="border-top: 2px solid #007bff; width: 50%;">
        </div>

        <!-- Activity Details -->
        <h3 class="mb-3">Activity Details</h3>
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Group:</strong> {{ $activity->group ? $activity->group->group_name : 'N/A' }}
            </li>
            <li class="list-group-item">
                <strong>User:</strong> {{ $activity->user->name }}
            </li>
            <li class="list-group-item">
                <strong>Created At:</strong> {{ $activity->created_at->format('d M, Y H:i') }}
            </li>
            <li class="list-group-item">
                @if (!empty($activity->file))
                <div class="">
                    <strong>File Attachment:</strong>
                    <br>
                    @if (in_array(pathinfo($activity->file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                        <img src="{{ $activity->file_path }}" alt="File Preview" class="img-fluid"
                            style="max-width: 200px;">
                    @else
                        <a href="{{ $activity->file_path }}" target="_blank">View Current File</a>
                    @endif
                </div>
            @endif
            </li>
        </ul>

        <!-- Back Button -->
        <div class="mt-4 text-center">
            <a href="{{ route('userActivities.index') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-arrow-left"></i> Back to Activities
            </a>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* Page Title Styling */
        .text-center h1 {
            font-size: 2.5rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-shadow: 2px 2px 4px rgba(0, 123, 255, 0.3);
        }

        /* Button Styling */
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-lg {
            font-size: 1.2rem;
            padding: 10px 20px;
        }

        /* List Group Item Styling */
        .list-group-item {
            font-size: 1rem;
            padding: 15px;
        }

        /* Margin and Spacing */
        .mb-4 {
            margin-bottom: 2rem;
        }

        .mb-3 {
            margin-bottom: 1.5rem;
        }
    </style>
@endsection
