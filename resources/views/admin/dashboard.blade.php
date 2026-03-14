@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('body-class', 'user-dashboard')

@section('styles')
<style>
    /* Admin Dashboard Specific Styles */
    .user-dashboard {
        background-color: #f8fbff;
        min-height: 100vh;
    }

    /* Main Content Padding */
    .dashboard-content {
        padding: 20px;
        max-width: 1100px;
        margin: 0 auto;
        width: 100%;
    }

    /* Welcome Section */
    .welcome-section {
        margin-bottom: 30px;
    }

    .welcome-card {
        background: linear-gradient(135deg, #2d3e50 0%, #3b4d63 100%);
        color: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(45, 62, 80, 0.1);
        position: relative;
        overflow: hidden;
    }

    .welcome-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .welcome-text h1 {
        font-size: 28px;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .welcome-text p {
        font-size: 16px;
        opacity: 0.9;
        max-width: 500px;
    }

    .date-time {
        position: absolute;
        bottom: 20px;
        right: 30px;
        text-align: right;
    }

    .current-date {
        font-size: 14px;
        opacity: 0.8;
        margin-bottom: 5px;
    }

    .current-time {
        font-size: 24px;
        font-weight: 600;
        font-family: 'Courier New', monospace;
    }

    /* Stats Grid - 3 per line */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    @media (max-width: 900px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #edf2f7;
        transition: all 0.3s ease;
        cursor: pointer;
        text-align: center;
        border-top: 4px solid #1e40af;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border-color: #1e40af;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        background: #f0f7ff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        color: #2d3e50;
        font-size: 20px;
    }

    .stat-value {
        display: block;
        font-size: 32px;
        font-weight: 700;
        color: #2d3e50;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 14px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Charts Section */
    .charts-section {
        margin-bottom: 30px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 20px;
        color: #2d3e50;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #3182ce;
    }

    .view-all {
        color: #64748b;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }

    .view-all:hover {
        color: #2d3e50;
    }

    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
        gap: 20px;
    }

    @media (max-width: 1100px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
    }

    .chart-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        border: 1px solid #edf2f7;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .chart-title {
        font-size: 16px;
        color: #2d3e50;
        font-weight: 600;
    }

    /* Chart Canvas */
    .chart-container {
        height: 250px;
        position: relative;
    }

    /* Recent Enrollments */
    .recent-section {
        margin-bottom: 30px;
    }

    .table-container {
        background: white;
        border-radius: 15px;
        border: 1px solid #edf2f7;
        overflow: hidden;
    }

    .table-responsive {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead {
        background: #f8fafc;
    }

    .data-table th {
        padding: 15px;
        text-align: left;
        font-size: 12px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 600;
    }

    .data-table td {
        padding: 15px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        color: #2d3e50;
    }

    .data-table tbody tr:hover {
        background: #f8fafc;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2d3e50, #3182ce);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        display: inline-block;
    }

    .status-active {
        background: #dcfce7;
        color: #15803d;
    }

    .status-pending {
        background: #fef3c7;
        color: #d97706;
    }

    .status-completed {
        background: #dbeafe;
        color: #1e40af;
    }

    /* Popular Courses */
    .popular-section {
        margin-bottom: 30px;
    }

    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .course-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        border: 1px solid #edf2f7;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border-color: #2d3e50;
    }

    .course-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .course-title {
        font-size: 16px;
        color: #2d3e50;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .course-category {
        font-size: 11px;
        color: #94a3b8;
        background: #f1f5f9;
        padding: 2px 8px;
        border-radius: 10px;
        display: inline-block;
    }

    .course-stats {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        padding-top: 15px;
        border-top: 1px solid #f1f5f9;
    }

    .course-stat {
        text-align: center;
        flex: 1;
    }

    .stat-number {
        display: block;
        font-size: 18px;
        font-weight: 700;
        color: #2d3e50;
        margin-bottom: 2px;
    }

    .stat-text {
        font-size: 10px;
        color: #94a3b8;
        text-transform: uppercase;
    }

    /* Active Students - Single Line Rectangles */
    .students-section {
        margin-bottom: 30px;
    }

    .students-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .student-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        border: 1px solid #edf2f7;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .student-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border-color: #2d3e50;
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
    }

    .student-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2d3e50, #3182ce);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 18px;
        flex-shrink: 0;
    }

    .student-details h4 {
        font-size: 16px;
        color: #2d3e50;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .student-details p {
        font-size: 12px;
        color: #94a3b8;
    }

    .student-stats {
        display: flex;
        gap: 20px;
        align-items: center;
    }

    .stat-enrollments {
        text-align: center;
        padding: 8px 15px;
        background: #f0f7ff;
        border-radius: 10px;
    }

    .enrollment-count {
        font-size: 16px;
        font-weight: 700;
        color: #2d3e50;
        display: block;
    }

    .enrollment-label {
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
    }

    .btn-view-profile {
        padding: 8px 15px;
        background: #2d3e50;
        color: white;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 12px;
    }

    .btn-view-profile:hover {
        background: #1a252f;
        transform: translateY(-2px);
    }

    /* Quick Actions */
    .quick-actions-section {
        margin-bottom: 30px;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
    }

    .action-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        border: 1px solid #edf2f7;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
    }

    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border-color: #2d3e50;
    }

    .action-icon {
        width: 50px;
        height: 50px;
        background: #f0f7ff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        color: #2d3e50;
        font-size: 20px;
    }

    .action-title {
        font-size: 14px;
        color: #2d3e50;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .action-desc {
        font-size: 12px;
        color: #64748b;
        line-height: 1.4;
    }

    /* Empty States */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #64748b;
        background: white;
        border-radius: 15px;
        border: 1px solid #edf2f7;
    }

    .empty-state i {
        font-size: 48px;
        color: #cbd5e0;
        margin-bottom: 15px;
    }

    .empty-state p {
        font-size: 14px;
        margin-bottom: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-content {
            padding: 15px;
        }
        
        .courses-grid {
            grid-template-columns: 1fr;
        }
        
        .actions-grid {
            grid-template-columns: 1fr 1fr;
        }
        
        .welcome-card {
            padding: 20px;
        }
        
        .date-time {
            position: relative;
            text-align: left;
            margin-top: 15px;
        }
        
        .student-card {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
        
        .student-info {
            flex-direction: column;
            text-align: center;
        }
        
        .student-stats {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-content">
    
    <!-- Welcome Section -->
    <section class="welcome-section">
        <div class="welcome-card">
            <div class="welcome-text">
                <h1>Welcome back, {{ Auth::user()->name }}!</h1>
                <p>Monitor system performance and manage platform activities.</p>
            </div>
            <div class="date-time">
                <div class="current-date" id="currentDate"></div>
                <div class="current-time" id="currentTime"></div>
            </div>
        </div>
    </section>

    <!-- Stats Grid - 3 per line -->
    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-card" onclick="window.location.href='{{ route('admin.students.index') }}'">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <span class="stat-value">{{ $stats['total_students'] ?? 0 }}</span>
                <span class="stat-label">Total Students</span>
            </div>
            
            <div class="stat-card" onclick="window.location.href='{{ route('admin.students.index') }}'">
                <div class="stat-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <span class="stat-value">{{ $stats['total_instructors'] ?? 0 }}</span>
                <span class="stat-label">Instructors</span>
            </div>
            
            <div class="stat-card" onclick="window.location.href='{{ route('admin.courses.index') }}'">
                <div class="stat-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <span class="stat-value">{{ $stats['total_courses'] ?? 0 }}</span>
                <span class="stat-label">Total Courses</span>
            </div>
            
            <div class="stat-card" onclick="window.location.href='{{ route('admin.enrollments.index') }}'">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <span class="stat-value">{{ $stats['total_enrollments'] ?? 0 }}</span>
                <span class="stat-label">Enrollments</span>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <span class="stat-value">${{ number_format($stats['total_revenue'] ?? 0) }}</span>
                <span class="stat-label">Total Revenue</span>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-money-bill-trend-up"></i>
                </div>
                <span class="stat-value">${{ number_format($stats['monthly_revenue'] ?? 0) }}</span>
                <span class="stat-label">Monthly Revenue</span>
            </div>
        </div>
    </section>

    <!-- Charts Section -->
    <section class="charts-section">
        <div class="section-header">
            <h2 class="section-title"><i class="fas fa-chart-area"></i> Platform Analytics</h2>
        </div>
        
        <div class="charts-grid">
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title">Revenue (Last 7 Days)</div>
                    <a href="{{ route('admin.analytics.revenue') }}" class="view-all">Details →</a>
                </div>
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
            
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title">Enrollments (Last 7 Days)</div>
                    <a href="{{ route('admin.analytics.enrollments') }}" class="view-all">Details →</a>
                </div>
                <div class="chart-container">
                    <canvas id="enrollmentChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Enrollments -->
    <section class="recent-section">
        <div class="section-header">
            <h2 class="section-title"><i class="fas fa-history"></i> Recent Enrollments</h2>
            <a href="{{ route('admin.enrollments.index') }}" class="view-all">View All →</a>
        </div>
        
        @if($recentEnrollments->count() > 0)
            <div class="table-container">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentEnrollments as $enrollment)
                                <tr onclick="window.location.href='{{ route('admin.enrollments.show', $enrollment) }}'" style="cursor: pointer;">
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                {{ $enrollment->user->initials }}
                                            </div>
                                            <div>
                                                <div>{{ $enrollment->user->name }}</div>
                                                <div style="font-size: 11px; color: #94a3b8;">{{ $enrollment->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ Str::limit($enrollment->course->title, 40) }}</td>
                                    <td>${{ number_format($enrollment->amount_paid, 2) }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $enrollment->status }}">
                                            {{ ucfirst($enrollment->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $enrollment->created_at->format('M d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-history"></i>
                <p>No recent enrollments found.</p>
            </div>
        @endif
    </section>

    <!-- Popular Courses -->
    <section class="popular-section">
        <div class="section-header">
            <h2 class="section-title"><i class="fas fa-star"></i> Popular Courses</h2>
            <a href="{{ route('admin.courses.index') }}" class="view-all">View All →</a>
        </div>
        
        @if($popularCourses->count() > 0)
            <div class="courses-grid">
                @foreach($popularCourses as $course)
                    <div class="course-card" onclick="window.location.href='{{ route('admin.courses.edit', $course) }}'">
                        <div class="course-header">
                            <div>
                                <div class="course-title">{{ $course->title }}</div>
                                @if($course->category)
                                    <span class="course-category">{{ $course->category->name }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="course-stats">
                            <div class="course-stat">
                                <span class="stat-number">{{ $course->total_students }}</span>
                                <span class="stat-text">Students</span>
                            </div>
                            <div class="course-stat">
                                <span class="stat-number">{{ $course->rating }}</span>
                                <span class="stat-text">Rating</span>
                            </div>
                            <div class="course-stat">
                                <span class="stat-number">${{ number_format($course->final_price, 0) }}</span>
                                <span class="stat-text">Price</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-star"></i>
                <p>No popular courses found.</p>
            </div>
        @endif
    </section>

    <!-- Active Students - Single Line Rectangles -->
    <section class="students-section">
        <div class="section-header">
            <h2 class="section-title"><i class="fas fa-user-check"></i> Active Students</h2>
            <a href="{{ route('admin.students.index') }}" class="view-all">View All →</a>
        </div>
        
        @if($activeStudents->count() > 0)
            <div class="students-list">
                @foreach($activeStudents as $student)
                    <div class="student-card" onclick="window.location.href='{{ route('admin.students.show', $student) }}'">
                        <div class="student-info">
                            <div class="student-avatar">
                                {{ $student->initials }}
                            </div>
                            <div class="student-details">
                                <h4>{{ $student->name }}</h4>
                                <p>{{ $student->email }}</p>
                            </div>
                        </div>
                        
                        <div class="student-stats">
                            <div class="stat-enrollments">
                                <span class="enrollment-count">{{ $student->enrollments_count }}</span>
                                <span class="enrollment-label">Active Enrollments</span>
                            </div>
                            <button class="btn-view-profile" onclick="event.stopPropagation(); window.location.href='{{ route('admin.students.show', $student) }}'">
                                View Profile
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-user-check"></i>
                <p>No active students found.</p>
            </div>
        @endif
    </section>

    <!-- Quick Actions -->
    <section class="quick-actions-section">
        <div class="section-header">
            <h2 class="section-title"><i class="fas fa-bolt"></i> Quick Actions</h2>
        </div>
        
        <div class="actions-grid">
            <a href="{{ route('admin.courses.create') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div class="action-title">New Course</div>
                <div class="action-desc">Create a new course</div>
            </a>
            
            <a href="{{ route('admin.students.create') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="action-title">Add Student</div>
                <div class="action-desc">Register new student</div>
            </a>
            
            <a href="{{ route('admin.enrollments.create') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-bookmark"></i>
                </div>
                <div class="action-title">New Enrollment</div>
                <div class="action-desc">Enroll student to course</div>
            </a>
            
            <a href="{{ route('admin.analytics.index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="action-title">Analytics</div>
                <div class="action-desc">View detailed reports</div>
            </a>
        </div>
    </section>

</div>
@endsection

@section('scripts')
<script src="{{ asset('chartjs/chart.umd.js') }}"></script>
<script>
    // Update current date and time
    function updateDateTime() {
        const now = new Date();
        
        // Format date
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateString = now.toLocaleDateString('en-US', options);
        document.getElementById('currentDate').textContent = dateString;
        
        // Format time
        const timeString = now.toLocaleTimeString('en-US', { 
            hour: '2-digit', 
            minute: '2-digit',
            hour12: true 
        });
        document.getElementById('currentTime').textContent = timeString;
    }
    
    // Update time every second
    updateDateTime();
    setInterval(updateDateTime, 1000);
    
    // Initialize Revenue Chart
    @if(isset($revenueData))
    document.addEventListener('DOMContentLoaded', function() {
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($revenueData, 'date')) !!},
                datasets: [{
                    label: 'Revenue ($)',
                    data: {!! json_encode(array_column($revenueData, 'revenue')) !!},
                    borderColor: '#2d3e50',
                    backgroundColor: 'rgba(45, 62, 80, 0.1)',
                    borderWidth: 2,
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
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
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
        
        // Initialize Enrollment Chart
        const enrollmentCtx = document.getElementById('enrollmentChart').getContext('2d');
        const enrollmentChart = new Chart(enrollmentCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_column($enrollmentData, 'date')) !!},
                datasets: [{
                    label: 'Enrollments',
                    data: {!! json_encode(array_column($enrollmentData, 'enrollments')) !!},
                    backgroundColor: 'rgba(45, 62, 80, 0.8)',
                    borderColor: '#2d3e50',
                    borderWidth: 1
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
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            stepSize: 1
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
    });
    @endif
    
    // Card hover effects
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.stat-card, .course-card, .student-card, .action-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Student card hover effects
        document.querySelectorAll('.student-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
        
        // Table row hover effects
        document.querySelectorAll('.data-table tbody tr').forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.background = '#f8fafc';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.background = '';
            });
        });
        
        // View profile button hover
        document.querySelectorAll('.btn-view-profile').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endsection