    <div class="bg-white shadow-lg rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image(s)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Count</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">RSVP</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden xl:table-cell">Adults/Children</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden xl:table-cell">Attendance</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden xl:table-cell">QR Code</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden 2xl:table-cell">Created</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($eventsList as $event)
                    <tr class="hover:bg-gray-50">
                        {{-- Image Column (Single Image on small screens) --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex flex-wrap -space-x-2">
                                @if($event->image_paths)
                                    @foreach (array_slice($event->image_paths, 0, 1) as $imagePath)
                                        <img src="{{ asset('storage/' . $imagePath) }}" alt="{{ $event->name }}" class="w-10 h-10 object-cover rounded-md border-2 border-white shadow-sm">
                                    @endforeach
                                @else
                                    <div class="flex items-center justify-center w-10 h-10 rounded-md border-2 border-dashed border-gray-300 bg-gray-50 text-gray-400 text-xs">
                                        N/A
                                    </div>
                                @endif
                            </div>
                        </td>
                        
                        {{-- Name/Description Column --}}
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">{{ $event->name }}</div>
                            <div class="text-xs text-gray-500">{{ Str::limit($event->description, 30) }}</div>
                        </td>
                        
                        {{-- Image Count (Hidden on mobile) --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                            {{ $event->image_paths ? count($event->image_paths) : 0 }}
                        </td>
                        
                        {{-- Posted Date (Hidden on XS) --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden sm:table-cell">
                            {{ $event->posted_date ? $event->posted_date->format('Y-m-d') : 'N/A' }}
                        </td>
                        
                        {{-- Status Badge (Hidden on XS) --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm hidden sm:table-cell">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($event->status == 'active') 
                                    bg-green-100 text-green-800 
                                @else 
                                    bg-yellow-100 text-yellow-800 
                                @endif">
                                {{ ucfirst($event->status) }}
                            </span>
                        </td>
                        
                        {{-- RSVP Accepted Count (Hidden on mobile/tablet) --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium hidden lg:table-cell">
                            {{ $event->acceptedRsvpCount() }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden xl:table-cell">
                            A: {{ $event->totalAdultsCount() }} / C: {{ $event->totalChildrenCount() }}
                        </td>

                        {{-- Attendance Count --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium hidden xl:table-cell">
                            <a href="{{ route('admin.event.attendance', $event->id) }}" class="text-green-600 hover:text-green-900 underline">
                                {{ $event->attendanceCount() }}
                            </a>
                        </td>

                        {{-- QR Code Preview --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden xl:table-cell">
                            <div class="flex items-center justify-center">
                                <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 001 1zm0 10h2a1 1 0 001-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 001 1zm0 10h2a1 1 0 001-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 001 1zM9 4h.01M9 20h.01"></path></svg>
                                </div>
                            </div>
                        </td>
                        
                        {{-- Created At (Hidden on most screens) --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden 2xl:table-cell">
                            {{ $event->created_at ? $event->created_at->format('Y-m-d H:i') : 'N/A' }}
                        </td>
                        
                        {{-- Actions Column: Grouped actions for mobile, detailed actions for large screens --}}
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            {{-- Actions for Mobile (MD screen size and down) --}}
                            <div class="flex space-x-2 md:hidden justify-end">
                                {{-- Primary Action for Mobile --}}
                                <a href="{{ route('admin.event.rsvp-details', $event->id) }}" class="p-2 text-xs font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600">RSVPs</a>
                                
                                {{-- Grouped Actions Dropdown for Mobile --}}
                                <div x-data="{ open: false }" @click.away="open = false" class="relative inline-block text-left">
                                    <button @click="open = !open" type="button" class="p-2 inline-flex justify-center rounded-md border border-gray-300 shadow-sm bg-white text-xs font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z" />
                                        </svg>
                                    </button>
                                    
                                    {{-- FIX: Use x-show and add 'hidden' as initial state --}}
                                    <div x-show="open" 
                                         class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10 hidden" 
                                         x-bind:class="{ 'hidden': !open }" {{-- This line ensures it's hidden when JS fails/before init --}}
                                         x-transition:enter="transition ease-out duration-100" 
                                         x-transition:enter-start="transform opacity-0 scale-95" 
                                         x-transition:enter-end="transform opacity-100 scale-100" 
                                         x-transition:leave="transition ease-in duration-75" 
                                         x-transition:leave-start="transform opacity-100 scale-100" 
                                         x-transition:leave-end="transform opacity-0 scale-95" 
                                         role="menu">
                                        <div class="py-1" role="none">
                                            <a href="{{ route('admin.event.edit', $event->id) }}" class="text-gray-700 block px-4 py-2 text-xs hover:bg-gray-100">Edit Event</a>
                                            <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full text-left text-red-600 block px-4 py-2 text-xs hover:bg-gray-100">Delete Event</button>
                                            </form>
                                            <div class="border-t border-gray-100 my-1"></div>
                                            <span class="text-gray-900 block px-4 py-1 text-xs font-semibold">Reports:</span>
                                            <a href="{{ route('admin.event.rsvp-reports', ['event' => $event->id, 'type' => 'accepted']) }}" class="text-gray-700 block px-4 py-1 text-xs hover:bg-gray-100">Accepted ({{ $event->acceptedRsvpCount() }})</a>
                                            <a href="{{ route('admin.event.rsvp-reports', ['event' => $event->id, 'type' => 'rejected']) }}" class="text-gray-700 block px-4 py-1 text-xs hover:bg-gray-100">Rejected ({{ $event->rejectedRsvpCount() }})</a>
                                            <a href="{{ route('admin.event.rsvp-reports', ['event' => $event->id, 'type' => 'not-seen']) }}" class="text-gray-700 block px-4 py-1 text-xs hover:bg-gray-100">Not Seen ({{ $event->notSeenRsvpCount() }})</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Actions for Tablet/PC (MD screen size and up) --}}
                            <div class="hidden md:flex flex-col space-y-1 items-center">
                                {{-- Reports Dropdown --}}
                                <div x-data="{ open: false }" @click.away="open = false" class="relative inline-block text-left w-full">
                                    <button @click="open = !open" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-3 py-1.5 bg-white text-xs font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Reports
                                        <svg class="-mr-1 ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    </button>
                                    
                                    {{-- FIX: Use x-show and add 'hidden' as initial state --}}
                                    <div x-show="open" 
                                         class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10 hidden" 
                                         x-bind:class="{ 'hidden': !open }" {{-- This line ensures it's hidden when JS fails/before init --}}
                                         x-transition:enter="transition ease-out duration-100" 
                                         x-transition:enter-start="transform opacity-0 scale-95" 
                                         x-transition:enter-end="transform opacity-100 scale-100" 
                                         x-transition:leave="transition ease-in duration-75" 
                                         x-transition:leave-start="transform opacity-100 scale-100" 
                                         x-transition:leave-end="transform opacity-0 scale-95" 
                                         role="menu">
                                        <div class="py-1" role="none">
                                            <a href="{{ route('admin.event.rsvp-reports', ['event' => $event->id, 'type' => 'accepted']) }}" class="text-gray-700 block px-4 py-2 text-xs hover:bg-gray-100">All Accepted ({{ $event->acceptedRsvpCount() }})</a>
                                            <a href="{{ route('admin.event.rsvp-reports', ['event' => $event->id, 'type' => 'rejected']) }}" class="text-gray-700 block px-4 py-2 text-xs hover:bg-gray-100">Rejected ({{ $event->rejectedRsvpCount() }})</a>
                                            <a href="{{ route('admin.event.rsvp-reports', ['event' => $event->id, 'type' => 'not-seen']) }}" class="text-gray-700 block px-4 py-2 text-xs hover:bg-gray-100">Not Seen ({{ $event->notSeenRsvpCount() }})</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <a href="{{ route('admin.event.rsvp-details', $event->id) }}" class="w-full px-3 py-1.5 text-xs font-medium text-white bg-blue-500 rounded-md hover:bg-blue-600 transition duration-150 ease-in-out text-center">RSVPs</a>
                                <a href="{{ route('admin.event.attendance', $event->id) }}" class="w-full px-3 py-1.5 text-xs font-medium text-white bg-green-500 rounded-md hover:bg-green-600 transition duration-150 ease-in-out text-center">Attendance</a>
                                <a href="{{ route('admin.event.edit', $event->id) }}" class="w-full px-3 py-1.5 text-xs font-medium text-white bg-yellow-500 rounded-md hover:bg-yellow-600 transition duration-150 ease-in-out text-center">Edit</a>
                                
                                <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-3 py-1.5 text-xs font-medium text-white bg-red-600 rounded-md hover:bg-red-700 transition duration-150 ease-in-out text-center">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">No events found. Click "Add New Event" to start.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-6">
        {{ $eventsList->links() }}
    </div>
