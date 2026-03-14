<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Enrollments Analytics Report - {{ now()->format('Y-m-d') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2D3E50;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #2D3E50;
            margin: 0;
            font-size: 24px;
        }
        
        .header p {
            color: #64748b;
            margin: 5px 0;
        }
        
        .stats-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            flex: 1;
            min-width: 150px;
            border: 1px solid #e2e8f0;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
        }
        
        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #2D3E50;
            display: block;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10px;
        }
        
        th {
            background-color: #f8fafc;
            text-align: left;
            padding: 8px;
            border: 1px solid #e2e8f0;
            font-weight: bold;
        }
        
        td {
            padding: 8px;
            border: 1px solid #e2e8f0;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            color: #94a3b8;
            font-size: 10px;
        }
        
        .section-title {
            color: #2D3E50;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
            margin: 30px 0 15px;
            font-size: 16px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .mb-20 { margin-bottom: 20px; }
        .mt-20 { margin-top: 20px; }
        
        .status-badge {
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            display: inline-block;
        }
        
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-active { background: #d1fae5; color: #065f46; }
        .status-completed { background: #dbeafe; color: #1e40af; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Enrollments Analytics Report</h1>
        <p>Shifra Training Center</p>
        <p>Generated on: {{ now()->format('F d, Y h:i A') }}</p>
    </div>

    <!-- Summary Statistics -->
    <div class="mb-20">
        <h2 class="section-title">Summary Statistics</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-value">{{ $enrollmentStats['total'] ?? 0 }}</span>
                <span class="stat-label">Total Enrollments</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">{{ $enrollmentStats['active'] ?? 0 }}</span>
                <span class="stat-label">Active Enrollments</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">{{ $enrollmentStats['completed'] ?? 0 }}</span>
                <span class="stat-label">Completed</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">{{ $enrollmentStats['pending'] ?? 0 }}</span>
                <span class="stat-label">Pending</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">{{ $enrollmentStats['cancelled'] ?? 0 }}</span>
                <span class="stat-label">Cancelled</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">{{ $enrollmentStats['average_progress'] ?? 0 }}%</span>
                <span class="stat-label">Avg Progress</span>
            </div>
        </div>
    </div>

    <!-- Status Distribution -->
    <div class="mb-20">
        <h2 class="section-title">Status Distribution</h2>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Count</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($enrollmentsByStatus as $status)
                <tr>
                    <td>
                        <span class="status-badge status-{{ $status->status }}">
                            {{ ucfirst($status->status) }}
                        </span>
                    </td>
                    <td>{{ $status->count }}</td>
                    <td>
                        @php
                            $percentage = $enrollmentStats['total'] > 0 ? round(($status->count / $enrollmentStats['total']) * 100, 1) : 0;
                        @endphp
                        {{ $percentage }}%
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Recent Enrollments -->
    <div class="mb-20">
        <h2 class="section-title">Recent Enrollments ({{ count($enrollments) }})</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Enrollment Date</th>
                    <th>Status</th>
                    <th>Progress</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($enrollments as $enrollment)
                <tr>
                    <td>{{ $enrollment->enrollment_id }}</td>
                    <td>{{ $enrollment->user->name }}</td>
                    <td>{{ $enrollment->course->title }}</td>
                    <td>{{ $enrollment->enrolled_at->format('Y-m-d') }}</td>
                    <td>
                        <span class="status-badge status-{{ $enrollment->status }}">
                            {{ ucfirst($enrollment->status) }}
                        </span>
                    </td>
                    <td>{{ $enrollment->progress_percentage }}%</td>
                    <td>${{ number_format($enrollment->amount_paid, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Daily Enrollment Trends -->
    @php
        $topDays = array_slice($dailyEnrollments, -7); // Last 7 days
    @endphp
    @if(count($topDays) > 0)
    <div class="mb-20">
        <h2 class="section-title">Last 7 Days Enrollment Trends</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Enrollments</th>
                    <th>Trend</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topDays as $day)
                <tr>
                    <td>{{ $day['date'] }}</td>
                    <td>{{ $day['count'] }}</td>
                    <td>
                        @if($loop->index > 0 && $day['count'] > $topDays[$loop->index - 1]['count'])
                            ↑ Increased
                        @elseif($loop->index > 0 && $day['count'] < $topDays[$loop->index - 1]['count'])
                            ↓ Decreased
                        @else
                            → Stable
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Top 10 Courses by Enrollment -->
    @php
        $enrollmentsByCourse = $enrollments->groupBy('course_id')->sortByDesc(function($group) {
            return count($group);
        })->take(10);
    @endphp
    @if($enrollmentsByCourse->count() > 0)
    <div class="mb-20">
        <h2 class="section-title">Top 10 Courses by Enrollment</h2>
        <table>
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Enrollments</th>
                    <th>Completion Rate</th>
                    <th>Avg Progress</th>
                </tr>
            </thead>
            <tbody>
                @foreach($enrollmentsByCourse as $courseId => $courseEnrollments)
                @php
                    $course = $courseEnrollments->first()->course;
                    $completedCount = $courseEnrollments->where('status', 'completed')->count();
                    $avgProgress = $courseEnrollments->avg('progress_percentage');
                @endphp
                <tr>
                    <td>{{ $course->title }}</td>
                    <td>{{ count($courseEnrollments) }}</td>
                    <td>{{ count($courseEnrollments) > 0 ? round(($completedCount / count($courseEnrollments)) * 100, 1) : 0 }}%</td>
                    <td>{{ round($avgProgress ?? 0, 1) }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Report generated by Shifra Training Center Analytics System</p>
        <p>For more information, contact: admin@shifra.com</p>
        <p>© {{ date('Y') }} Shifra Training Center. All rights reserved.</p>
    </div>
</body>
</html>