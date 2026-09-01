@extends('layouts.app')

@section('title', 'Facilities | Resources')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Resource Catalog</h2>
                <p class="text-sm text-gray-600">Browse available rooms and equipment.</p>
            </div>
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                Add Resource
            </button>
        </div>

        <!-- Resources Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($resources as $resource)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-all">
                <div class="h-48 bg-gray-200 relative">
                    <img src="{{ $resource->cover_url }}" alt="{{ $resource->name }}" class="w-full h-full object-cover">
                    <div class="absolute top-4 right-4">
                        <span class="{{ $resource->status === 'Available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} text-xs font-bold px-2 py-1 rounded-full">
                            {{ $resource->status }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $resource->name }}</h3>
                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                        @if($resource->capacity)
                        <div class="flex items-center gap-1"><i data-lucide="users" class="w-4 h-4"></i> {{ $resource->capacity }} Seats</div>
                        @endif
                        
                        @if(is_array($resource->amenities))
                            @foreach(array_slice($resource->amenities, 0, 2) as $amenity)
                            <div class="flex items-center gap-1"><i data-lucide="check" class="w-4 h-4"></i> {{ $amenity }}</div>
                            @endforeach
                        @endif
                    </div>
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ Str::limit($resource->description, 100) }}</p>
                    <div class="flex justify-between items-center border-t border-gray-100 pt-4">
                        <span class="text-lg font-bold text-gray-900">
                            @if($resource->price_per_hour > 0)
                                ${{ number_format($resource->price_per_hour, 2) }} <span class="text-xs font-normal text-gray-500">/ hour</span>
                            @else
                                Free <span class="text-xs font-normal text-gray-500">(Internal)</span>
                            @endif
                        </span>
                        @if($resource->status === 'Available')
                            <button class="text-blue-600 hover:text-blue-800 font-medium text-sm">Book Now</button>
                        @else
                            <button class="text-gray-400 cursor-not-allowed font-medium text-sm">Check Availability</button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center text-gray-500 py-12">
                No resources found.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
