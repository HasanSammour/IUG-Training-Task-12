<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Report - {{ $course->title }}</title>
    <style>
        /* PDF Styles */
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 30px;
            color: #2D3E50;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #2D3E50;
        }
        
        .logo {
            font-size: 32px;
            font-weight: 700;
            color: #2D3E50;
            margin-bottom: 5px;
        }
        
        .subtitle {
            color: #64748b;
            font-size: 14px;
        }
        
        .course-info {
            background: #f8fafc;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            border: 1px solid #e2e8f0;
        }
        
        .course-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-top: 15px;
        }
        
        .meta-item {
            text-align: center;
        }
        
        .meta-label {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
        }
        
        .meta-value {
            font-size: 16px;
            font-weight: 600;
            color: #2D3E50;
        }
        
        .stats-section {
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f1f5f9;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }
        
        .stat-number {
            display: block;
            font-size: 28px;
            font-weight: 700;
            color: #2D3E50;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
        }
        
        .students-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .students-table th {
            background: #f1f5f9;
            padding: 12px;
            font-size: 12px;
            text-transform: uppercase;
            color: #2D3E50;
            border-bottom: 2px solid #cbd5e0;
        }
        
        .students-table td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
        }
        
        .progress-bar {
            width: 100%;
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            position: relative;
        }
        
        .progress-fill {
            height: 6px;
            background: #2D3E50;
            border-radius: 3px;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .status-active {
            background: #dcfce7;
            color: #15803d;
        }
        
        .status-completed {
            background: #dbeafe;
            color: #1e40af;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }
        
        .watermark {
            position: fixed;
            bottom: 30px;
            right: 30px;
            opacity: 0.1;
            font-size: 60px;
            color: #2D3E50;
            transform: rotate(-15deg);
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="watermark">SHIFRA</div>
    
    <div class="header">
        <div class="logo">shifra</div>
        <div class="subtitle">Training Center</div>
        <div style="margin-top: 10px;">Course Student Report • {{ now()->format('F d, Y') }}</div>
    </div>
    
    <div class="course-info">
        <div class="course-title">{{ $course->title }}</div>
        <p style="color: #64748b; margin-bottom: 15px;">{{ $course->short_description ?? '' }}</p>
        
        <div class="meta-grid">
            <div class="meta-item">
                <div class="meta-label">Instructor</div>
                <div class="meta-value">{{ $course->instructor_name }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Duration</div>
                <div class="meta-value">{{ $course->duration ?? '4 weeks' }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Level</div>
                <div class="meta-value">{{ ucfirst($course->level) }}</div>
            </div>
            <div class="meta-item">
                <div class="meta-label">Format</div>
                <div class="meta-value">{{ ucfirst($course->format) }}</div>
            </div>
        </div>
    </div>
    
    @if($includeStats)
    <div class="stats-section">
        <div class="section-title">Course Statistics</div>
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-number">{{ $stats['total'] }}</span>
                <span class="stat-label">Total Students</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $stats['active'] }}</span>
                <span class="stat-label">Active</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $stats['completed'] }}</span>
                <span class="stat-label">Completed</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $stats['average_progress'] }}%</span>
                <span class="stat-label">Avg Progress</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $stats['pending'] }}</span>
                <span class="stat-label">Pending</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $stats['recent_enrollments'] }}</span>
                <span class="stat-label">New (7d)</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $stats['retention_rate'] }}%</span>
                <span class="stat-label">Retention</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">${{ number_format($stats['total_revenue'], 0) }}</span>
                <span class="stat-label">Revenue</span>
            </div>
        </div>
    </div>
    @endif
    
    @if($includeStudents)
    <div class="stats-section">
        <div class="section-title">Enrolled Students ({{ $enrollments->count() }})</div>
        
        <table class="students-table">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Enrolled</th>
                    @if($includeProgress)
                    <th>Progress</th>
                    @endif
                    <th>Status</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($enrollments as $enrollment)
                <tr>
                    <td>
                        <div style="font-weight: 600;">{{ $enrollment->user->name }}</div>
                        <div style="font-size: 11px; color: #64748b;">{{ $enrollment->user->email }}</div>
                    </td>
                    <td>
                        <div>{{ $enrollment->enrolled_at->format('M d, Y') }}</div>
                    </td>
                    @if($includeProgress)
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 80px;">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $enrollment->progress_percentage }}%"></div>
                                </div>
                            </div>
                            <span style="font-weight: 600;">{{ $enrollment->progress_percentage }}%</span>
                        </div>
                    </td>
                    @endif
                    <td>
                        <span class="status-badge status-{{ $enrollment->status }}">
                            {{ ucfirst($enrollment->status) }}
                        </span>
                    </td>
                    <td>
                        <span style="font-weight: 600;">${{ number_format($enrollment->amount_paid, 0) }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
    
    <div class="footer">
        <p>Shifra Training Center © {{ date('Y') }}. All rights reserved.</p>
        <p style="margin-top: 5px;">This report was generated on {{ now()->format('F d, Y \a\t h:i A') }}</p>
    </div>
</body>
</html>