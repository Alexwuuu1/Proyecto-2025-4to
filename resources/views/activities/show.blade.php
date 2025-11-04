@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $activity->name }}</h1>

        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Description</h2>
            <p class="text-gray-600">{{ $activity->description ?? 'No description provided.' }}</p>
        </div>

        <div class="mb-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Details</h2>
            <p class="text-gray-600"><strong>Created:</strong> {{ $activity->created_at->format('F d, Y \a\t g:i A') }}</p>
            <p class="text-gray-600"><strong>Last Updated:</strong> {{ $activity->updated_at->format('F d, Y \a\t g:i A') }}</p>
        </div>

        <div class="flex space-x-4">
            <a href="{{ route('activities.edit', $activity) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Edit Activity
            </a>
            <a href="{{ route('activities.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Activities
            </a>
        </div>
    </div>
</div>
@endsection
