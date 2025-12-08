<x-admin-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Analytics & Reports</h1>
                <p class="mt-2 text-lg text-gray-600">Monitor system performance and business insights</p>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Users</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalUsers ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Appointments -->
                <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Appointments</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalAppointments ?? 0 }}</p>
                        </div>
                    </div>
                </div>
        <!-- Total Revenue -->
        <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Revenue (Paid)</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        ₱{{ number_format($totalRevenue ?? 0, 2) }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        Today: ₱{{ number_format($dailyRevenue ?? 0, 2) }}<br>
                        This Week: ₱{{ number_format($weeklyRevenue ?? 0, 2) }}<br>
                        This Month: ₱{{ number_format($monthlyRevenueTotal ?? 0, 2) }}
                    </p>
                </div>
            </div>
        </div>


                <!-- Active Services -->
                <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Active Services</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $activeServices ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Revenue Chart -->
                <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Revenue Trend</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="revenueChart" height="200"></canvas>
                    </div>
                </div>

                <!-- Appointment Status Chart -->
                <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Appointment Status</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="appointmentStatusChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Additional Analytics -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Top Services -->
                <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Top Services</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="topServicesChart" height="200"></canvas>
                    </div>
                </div>

                <!-- Customer Feedback -->
                <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Customer Feedback</h3>
                    </div>
                    <div class="p-6">
                        <div class="text-center mb-4">
                            <div class="text-3xl font-bold text-green-600">{{ number_format($averageRating ?? 0, 1) }}</div>
                            <div class="text-sm text-gray-500">Average Rating</div>
                        </div>
                        <div class="mb-4">
                            <canvas id="ratingDistributionChart" height="150"></canvas>
                        </div>
                        @if(isset($recentFeedback) && $recentFeedback->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentFeedback->take(3) as $feedback)
                                    <div class="border-l-4 border-green-400 pl-3">
                                        <div class="flex items-center space-x-2">
                                            <div class="flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg class="w-4 h-4 {{ $i <= $feedback->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                    </svg>
                                                @endfor
                                            </div>
                                            <span class="text-sm text-gray-500">{{ $feedback->user->name ?? 'Anonymous' }}</span>
                                        </div>
                                        <p class="text-sm text-gray-700 mt-1">{{ \Illuminate\Support\Str::limit($feedback->comment ?? '', 100) }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500">No feedback available</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Additional Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Customer Growth Chart -->
                <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Customer Growth</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="customerGrowthChart" height="200"></canvas>
                    </div>
                </div>

                <!-- Specialist Performance Chart -->
                <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Specialist Performance</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="specialistPerformanceChart" height="200"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-gradient-to-br from-pink-100 via-purple-50 to-indigo-100 rounded-lg shadow-md border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @if(isset($recentFeedback) && $recentFeedback->count() > 0)
                            @foreach($recentFeedback->take(5) as $feedback)
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-gray-900">New feedback from {{ $feedback->user->name ?? 'Anonymous' }}</p>
                                        <p class="text-xs text-gray-500">{{ $feedback->created_at ? $feedback->created_at->diffForHumans() : 'Recently' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-900">System initialized</p>
                                    <p class="text-xs text-gray-500">Just now</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Chart.js configuration
        Chart.defaults.font.family = 'Inter, system-ui, sans-serif';
        Chart.defaults.color = '#6B7280';

        // Revenue Chart (Line Chart)
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyRevenue->pluck('month')->map(function($month) { return \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M Y'); })) !!},
                datasets: [{
                label: 'Paid Revenue (₱)',
                data: {!! json_encode($monthlyRevenue->pluck('revenue')) !!},
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Appointment Status Chart (Doughnut Chart)
        const appointmentStatusCtx = document.getElementById('appointmentStatusChart').getContext('2d');
        new Chart(appointmentStatusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($appointmentStatus->pluck('status')->map(function($status) { return ucfirst($status); })) !!},
                datasets: [{
                    data: {!! json_encode($appointmentStatus->pluck('count')) !!},
                    backgroundColor: [
                        '#10B981', // Green for confirmed
                        '#F59E0B', // Amber for pending
                        '#3B82F6', // Blue for completed
                        '#EF4444', // Red for cancelled
                        '#8B5CF6'  // Purple for other
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        // Top Services Chart (Bar Chart)
        const topServicesCtx = document.getElementById('topServicesChart').getContext('2d');
        new Chart(topServicesCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($topServices->pluck('name')) !!},
                datasets: [{
                    label: 'Bookings',
                    data: {!! json_encode($topServices->pluck('appointments_count')) !!},
                    backgroundColor: '#10B981',
                    borderColor: '#059669',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Rating Distribution Chart (Bar Chart)
        const ratingDistributionCtx = document.getElementById('ratingDistributionChart').getContext('2d');

        // Calculate rating distribution
        const ratingData = {!! json_encode($recentFeedback->groupBy('rating')->map->count()) !!};
        const ratingLabels = ['1 Star', '2 Stars', '3 Stars', '4 Stars', '5 Stars'];
        const ratingCounts = [0, 0, 0, 0, 0];

        Object.keys(ratingData).forEach(rating => {
            if (rating >= 1 && rating <= 5) {
                ratingCounts[rating - 1] = ratingData[rating];
            }
        });

        new Chart(ratingDistributionCtx, {
            type: 'bar',
            data: {
                labels: ratingLabels,
                datasets: [{
                    label: 'Count',
                    data: ratingCounts,
                    backgroundColor: [
                        '#EF4444', // Red for 1 star
                        '#F59E0B', // Amber for 2 stars
                        '#3B82F6', // Blue for 3 stars
                        '#10B981', // Green for 4 stars
                        '#059669'  // Dark green for 5 stars
                    ],
                    borderWidth: 0,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Customer Growth Chart (Line Chart)
        const customerGrowthCtx = document.getElementById('customerGrowthChart').getContext('2d');
        new Chart(customerGrowthCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($customerGrowth->pluck('month')->map(function($month) { return \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M Y'); })) !!},
                datasets: [{
                    label: 'New Customers',
                    data: {!! json_encode($customerGrowth->pluck('count')) !!},
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Specialist Performance Chart (Bar Chart)
        const specialistPerformanceCtx = document.getElementById('specialistPerformanceChart').getContext('2d');
        new Chart(specialistPerformanceCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($specialistPerformance->pluck('name')) !!},
                datasets: [{
                    label: 'Completed Appointments',
                    data: {!! json_encode($specialistPerformance->pluck('appointments_count')) !!},
                    backgroundColor: '#10B981',
                    borderColor: '#059669',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F3F4F6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</x-admin-layout>
