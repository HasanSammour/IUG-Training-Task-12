<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Students Analytics Report - {{ now()->format('Y-m-d') }}</title>
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
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Students Analytics Report</h1>
        <p>Shifra Training Center</p>
        <p>Generated on: {{ now()->format('F d, Y h:i A') }}</p>
        @if(!empty($search))
        <p>Search Filter: "{{ $search }}"</p>
        @endif
        @if(!empty($filter) && $filter !== 'all')
        <p>Time Filter: {{ ucfirst($filter) }}</p>
        @endif
    </div>

    <!-- Summary Statistics -->
    <div class="mb-20">
        <h2 class="section-title">Summary Statistics</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-value">{{ $studentStats['total'] ?? 0 }}</span>
                <span class="stat-label">Total Students</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">{{ $studentStats['active'] ?? 0 }}</span>
                <span class="stat-label">Active Students</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">{{ $studentStats['completed_courses'] ?? 0 }}</span>
                <span class="stat-label">Completed Courses</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">{{ number_format($studentStats['average_enrollments'] ?? 0, 1) }}</span>
                <span class="stat-label">Avg Enrollments</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">${{ number_format($studentStats['total_revenue'] ?? 0, 2) }}</span>
                <span class="stat-label">Total Revenue</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">${{ number_format($studentStats['average_revenue_per_student'] ?? 0, 2) }}</span>
                <span class="stat-label">Avg per Student</span>
            </div>
        </div>
    </div>

    <!-- Students List -->
    <div class="mb-20">
        <h2 class="section-title">Students List ({{ count($students) }})</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Enrollments</th>
                    <th>Learning Paths</th>
                    <th>Reviews</th>
                    <th>Total Spent</th>
                    <th>Join Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->enrollments_count ?? 0 }}</td>
                    <td>{{ $student->learning_paths_count ?? 0 }}</td>
                    <td>{{ $student->reviews_count ?? 0 }}</td>
                    <td>${{ number_format($student->enrollments_sum_amount_paid ?? 0, 2) }}</td>
                    <td>{{ $student->created_at->format('Y-m-d') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Top 10 Students by Revenue -->
    @php
        $topStudents = $students->sortByDesc('enrollments_sum_amount_paid')->take(10);
    @endphp
    @if($topStudents->count() > 0)
    <div class="mb-20">
        <h2 class="section-title">Top 10 Students by Revenue</h2>
        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Revenue</th>
                    <th>Enrollments</th>
                    <th>Avg per Course</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topStudents as $index => $student)
                <tr>
                    <td>#{{ $index + 1 }}</td>
                    <td>{{ $student->name }}</td>
                    <td>${{ number_format($student->enrollments_sum_amount_paid ?? 0, 2) }}</td>
                    <td>{{ $student->enrollments_count ?? 0 }}</td>
                    <td>
                        @if(($student->enrollments_count ?? 0) > 0)
                            ${{ number_format(($student->enrollments_sum_amount_paid ?? 0) / ($student->enrollments_count ?? 1), 2) }}
                        @else
                            $0.00
                        @endif
                    </td>
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