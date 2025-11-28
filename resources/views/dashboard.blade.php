@extends('layouts.agency')

@section('content')
    @php
        $metrics = [
            ['label' => 'Active properties', 'value' => 24, 'hint' => 'Managed and available units'],
            ['label' => 'Active applicants', 'value' => 58, 'hint' => 'Applicants progressing through the funnel'],
            ['label' => "Viewings today", 'value' => 7, 'hint' => 'Scheduled viewings across all negotiators'],
            ['label' => 'Tasks due', 'value' => 12, 'hint' => 'Follow-ups and reminders for today'],
        ];

        $viewings = [
            ['time' => '09:30', 'property' => 'Flat 2, Park Avenue', 'applicant' => 'Sam Spencer', 'status' => 'Confirmed'],
            ['time' => '11:15', 'property' => '12 Riverside Close', 'applicant' => 'Priya Shah', 'status' => 'Pending access'],
            ['time' => '15:00', 'property' => '74 High Street', 'applicant' => 'Jordan West', 'status' => 'Confirmed'],
        ];

        $activities = [
            ['title' => 'Added new applicant record', 'detail' => 'Claire Wilson • Applicant pipeline', 'time' => '5 mins ago'],
            ['title' => 'Updated tenancy offer', 'detail' => 'Flat 2, Park Avenue • Offer accepted', 'time' => '1 hr ago'],
            ['title' => 'Logged maintenance request', 'detail' => '74 High Street • Boiler pressure low', 'time' => 'Today 08:10'],
        ];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        @foreach ($metrics as $metric)
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
                <div class="text-sm text-gray-500">{{ $metric['label'] }}</div>
                <div class="mt-2 flex items-baseline space-x-2">
                    <div class="text-3xl font-semibold text-gray-900">{{ $metric['value'] }}</div>
                    <span class="text-xs text-gray-500">{{ $metric['hint'] }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Today&apos;s viewings</h3>
                        <p class="text-sm text-gray-500">Schedule across negotiators for {{ now()->format('l jS F') }}.</p>
                    </div>
                    <a href="{{ url('diary') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">Open diary</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse ($viewings as $viewing)
                        <div class="px-5 py-4 flex items-center justify-between">
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $viewing['property'] }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $viewing['applicant'] }}</div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">{{ $viewing['status'] }}</span>
                                <span class="text-sm text-gray-700">{{ $viewing['time'] }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="px-5 py-6 text-sm text-gray-500">No viewings scheduled for today.</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Recent activity</h3>
                        <p class="text-sm text-gray-500">Latest updates across lettings, offers and maintenance.</p>
                    </div>
                    <a href="{{ url('reports') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">View reports</a>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse ($activities as $activity)
                        <div class="px-5 py-4 flex items-center justify-between">
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $activity['title'] }}</div>
                                <div class="text-xs text-gray-500 mt-1">{{ $activity['detail'] }}</div>
                            </div>
                            <div class="text-xs text-gray-500">{{ $activity['time'] }}</div>
                        </div>
                    @empty
                        <div class="px-5 py-6 text-sm text-gray-500">No recent activity logged yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Quick actions</h3>
                    <p class="text-sm text-gray-500">Shortcuts for busy agency teams.</p>
                </div>
                <div class="p-5 space-y-3">
                    <a href="{{ url('leads/create') }}" class="flex items-center justify-between px-4 py-3 rounded-md border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50">
                        <div>
                            <div class="text-sm font-semibold text-gray-900">Add applicant</div>
                            <div class="text-xs text-gray-500">Create a new applicant record</div>
                        </div>
                        <span class="text-indigo-600 font-bold text-lg">+</span>
                    </a>
                    <a href="{{ url('properties/create') }}" class="flex items-center justify-between px-4 py-3 rounded-md border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50">
                        <div>
                            <div class="text-sm font-semibold text-gray-900">Add property</div>
                            <div class="text-xs text-gray-500">Market a new property</div>
                        </div>
                        <span class="text-indigo-600 font-bold text-lg">+</span>
                    </a>
                    <a href="{{ url('diary/create') }}" class="flex items-center justify-between px-4 py-3 rounded-md border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50">
                        <div>
                            <div class="text-sm font-semibold text-gray-900">Book viewing</div>
                            <div class="text-xs text-gray-500">Schedule a new diary event</div>
                        </div>
                        <span class="text-indigo-600 font-bold text-lg">+</span>
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900">Team focus</h3>
                    <p class="text-sm text-gray-500">Who&apos;s online and working today.</p>
                </div>
                <div class="p-5 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm font-semibold text-gray-900">Alex Martin</div>
                            <div class="text-xs text-gray-500">Negotiator • Viewings</div>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700">Online</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm font-semibold text-gray-900">Sophia Lee</div>
                            <div class="text-xs text-gray-500">Property manager • Maintenance</div>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-50 text-yellow-700">In field</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm font-semibold text-gray-900">Jamie Patel</div>
                            <div class="text-xs text-gray-500">Accounts • Payments</div>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">Offline</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
