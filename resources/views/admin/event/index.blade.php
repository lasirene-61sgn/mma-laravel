@extends('admin.layout.app')

@section('content')
<div class="p-6 md:p-8">
    
    <div class="flex items-center space-x-3 mb-6">
        <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        <h2 class="text-2xl font-bold text-gray-800 tracking-tight">Event Management</h2>
    </div>

    <!-- Info Alert -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex">
            <svg class="h-5 w-5 text-blue-400 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <h4 class="text-sm font-medium text-blue-800">QR Code Attendance</h4>
                <p class="text-sm text-blue-700 mt-1">
                    Each event automatically generates a QR code for customer attendance. 
                    Customers can scan the QR code to mark their attendance for events.
                </p>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4" role="alert">
            <strong class="font-bold">Success!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    
    <div class="flex justify-between mb-4">
        <a href="{{ route('admin.event.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add New Event
        </a>
    </div>

    <div x-data="{ tab: 'upcoming' }">
        <div class="mb-4 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" :class="tab === 'upcoming' ? 'border-indigo-600 text-indigo-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300'" @click="tab = 'upcoming'" type="button" role="tab">Upcoming Events ({{ $upcomingEvents->total() }})</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" :class="tab === 'past' ? 'border-indigo-600 text-indigo-600' : 'border-transparent hover:text-gray-600 hover:border-gray-300'" @click="tab = 'past'" type="button" role="tab">Past Events ({{ $pastEvents->total() }})</button>
                </li>
            </ul>
        </div>

        <div x-show="tab === 'upcoming'">
            @include('admin.event.partials.events_table', ['eventsList' => $upcomingEvents])
        </div>
        
        <div x-show="tab === 'past'" style="display: none;" x-bind:style="tab === 'past' ? 'display: block;' : 'display: none;'">
            @include('admin.event.partials.events_table', ['eventsList' => $pastEvents])
        </div>
    </div>
</div>

{{-- IMPORTANT: Ensure you include Alpine.js in your admin layout for the dropdowns to function correctly and hide initially. --}}
@endsection