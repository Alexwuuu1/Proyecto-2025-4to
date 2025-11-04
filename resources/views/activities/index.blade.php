@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">My Activities</h1>
        <a href="{{ route('activities.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Create New Activity
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($activities->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($activities as $activity)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $activity->name }}</h2>
                    <p class="text-gray-600 mb-4">{{ $activity->description ?? 'No description' }}</p>
                    <div class="flex justify-between items-center">
                        <small class="text-gray-500">Created: {{ $activity->created_at->format('M d, Y') }}</small>
                        <div class="space-x-2">
                            <a href="{{ route('activities.show', $activity) }}" class="text-blue-500 hover:text-blue-700">View</a>
                            <a href="{{ route('activities.edit', $activity) }}" class="text-green-500 hover:text-green-700">Edit</a>
                            <form action="{{ route('activities.destroy', $activity) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500 text-lg">No activities found. <a href="{{ route('activities.create') }}" class="text-blue-500 hover:text-blue-700">Create your first activity</a></p>
        </div>
    @endif
</div>
@endsection
