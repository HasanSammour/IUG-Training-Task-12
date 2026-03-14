<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Peak Hours Analytics Report - {{ now()->format('Y-m-d') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
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
        
        .section-title {
            color: #2D3E50;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
            margin: 30px 0 15px;
            font-size: 16px;
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
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        .mb-20 { margin-bottom: 20px; }
        .mt-20 { margin-top: 20px; }
        
        .peak-indicator {
            background: #f0f7ff;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
            border: 1px solid #dbeafe;
        }
        
        .peak-title {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 5px;
        }
        
        .peak-value {
            font-size: 18px;
            font-weight: bold;
            color: #2D3E50;
        }
        
        .hour-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 8px;
            margin: 15px 0;
        }
        
        .hour-item {
            padding: 8px;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            text-align: center;
        }
        
        .hour-peak {
            background: #2D3E50;
            color: white;
            border-color: #2D3E50;
        }
        
        .hour-time {
            font-size: 10px;
            font-weight: bold;
        }
        
        .hour-count {
            font-size: 12px;
            font-weight: bold;
            margin-top: 5px;
        }
        
        .recommendations {
            background: #fef3c7;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #fcd34d;
        }
        
        .recommendations h4 {
            color: #92400e;
            margin: 0 0 10px 0;
        }
        
        .recommendations ul {
            margin: 0;
            padding-left: 20px;
            color: #92400e;
        }
        
        .recommendations li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Peak Hours Analytics Report</h1>
        <p>Shifra Training Center</p>
        <p>Generated on: {{ $generatedAt->format('F d, Y h:i A') }}</p>
    </div>

    <!-- Summary Statistics -->
    <div class="mb-20">
        <h2 class="section-title">Summary Statistics</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <span class="stat-value">{{ $stats['peak_hour'] }}</span>
                <span class="stat-label">Peak Hour</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">{{ $stats['avg_daily_logins'] }}</span>
                <span class="stat-label">Avg Daily Logins</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">{{ $stats['avg_enrollments_per_hour'] }}</span>
                <span class="stat-label">Avg Enrollments/Hour</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">{{ $stats['peak_day'] }}</span>
                <span class="stat-label">Most Active Day</span>
            </div>
        </div>
    </div>

    <!-- Peak Hours Analysis -->
    <div class="mb-20">
        <h2 class="section-title">Hourly Activity Analysis</h2>
        
        <div class="peak-indicator">
            <div class="peak-title">Peak Activity Time</div>
            <div class="peak-value">{{ $peakHour['hour'] ?? '15:00' }}</div>
            <div style="color: #64748b; font-size: 11px;">{{ $peakHour['count'] ?? 0 }} activities</div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Activities</th>
                    <th>Percentage</th>
                    <th>Trend</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $topHours = collect($peakHours)->sortByDesc('count')->take(10);
                    $totalActivities = collect($peakHours)->sum('count');
                @endphp
                @foreach($topHours as $hour)
                <tr>
                    <td>{{ $hour['hour_12'] }}</td>
                    <td>{{ $hour['count'] }}</td>
                    <td>
                        @php
                            $percentage = $totalActivities > 0 ? round(($hour['count'] / $totalActivities) * 100, 1) : 0;
                        @endphp
                        {{ $percentage }}%
                    </td>
                    <td>
                        @if($hour['hour_number'] >= 9 && $hour['hour_number'] <= 17)
                            Business Hours
                        @elseif($hour['hour_number'] >= 18 && $hour['hour_number'] <= 22)
                            Evening Peak
                        @else
                            Off Hours
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Hourly Grid -->
        <h3 style="font-size: 14px; margin: 20px 0 10px; color: #2D3E50;">24-Hour Activity Overview</h3>
        <div class="hour-grid">
            @foreach($peakHours as $hour)
                @php
                    $isPeakHour = ($peakHour['hour'] ?? '15:00') === $hour['hour'];
                @endphp
                <div class="hour-item {{ $isPeakHour ? 'hour-peak' : '' }}">
                    <div class="hour-time">{{ $hour['hour_12'] }}</div>
                    <div class="hour-count">{{ $hour['count'] }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Daily Activity Patterns -->
    <div class="mb-20">
        <h2 class="section-title">Daily Activity Patterns</h2>
        
        <div class="peak-indicator">
            <div class="peak-title">Most Active Day</div>
            <div class="peak-value">{{ $peakDay['day'] ?? 'Friday' }}</div>
            <div style="color: #64748b; font-size: 11px;">{{ $peakDay['count'] ?? 0 }} enrollments</div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Enrollments</th>
                    <th>Percentage</th>
                    <th>Activity Level</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalDailyEnrollments = collect($enrollmentsByDay)->sum('count');
                @endphp
                @foreach($enrollmentsByDay as $day)
                <tr>
                    <td>{{ $day['day'] }}</td>
                    <td>{{ $day['count'] }}</td>
                    <td>
                        @php
                            $percentage = $totalDailyEnrollments > 0 ? round(($day['count'] / $totalDailyEnrollments) * 100, 1) : 0;
                        @endphp
                        {{ $percentage }}%
                    </td>
                    <td>
                        @if($day['day'] === ($peakDay['day'] ?? 'Friday'))
                            <strong>Peak</strong>
                        @elseif($day['count'] >= ($totalDailyEnrollments / 7))
                            High
                        @elseif($day['count'] >= ($totalDailyEnrollments / 14))
                            Medium
                        @else
                            Low
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Recommendations -->
    <div class="recommendations">
        <h4>Optimization Recommendations</h4>
        <ul>
            <li><strong>Schedule Announcements:</strong> Post new content around <strong>{{ $stats['peak_hour'] }}</strong> for maximum visibility</li>
            <li><strong>Live Sessions:</strong> Schedule on <strong>{{ $stats['peak_day'] }}s</strong> at <strong>{{ $stats['peak_hour'] }}</strong> for best attendance</li>
            <li><strong>Marketing Campaigns:</strong> Send promotional emails on <strong>Thursday afternoons</strong> when engagement is highest</li>
            <li><strong>Support Staff:</strong> Increase availability during <strong>business hours (9AM-5PM)</strong> and <strong>evening peak (6PM-10PM)</strong></li>
            <li><strong>Content Delivery:</strong> Release new course modules on <strong>{{ $stats['peak_day'] }} mornings</strong> for weekend learners</li>
        </ul>
    </div>

    <!-- Activity Summary -->
    <div class="mb-20">
        <h2 class="section-title">Activity Summary</h2>
        <table>
            <tbody>
                <tr>
                    <td><strong>Total Activities Recorded:</strong></td>
                    <td>{{ $stats['total_enrollments'] }}</td>
                </tr>
                <tr>
                    <td><strong>Peak Hour Activities:</strong></td>
                    <td>{{ $stats['peak_hour_count'] }} (at {{ $stats['peak_hour'] }})</td>
                </tr>
                <tr>
                    <td><strong>Peak Day Activities:</strong></td>
                    <td>{{ $stats['peak_day_count'] }} (on {{ $stats['peak_day'] }}s)</td>
                </tr>
                <tr>
                    <td><strong>Average Daily Activities:</strong></td>
                    <td>{{ $stats['avg_daily_logins'] }}</td>
                </tr>
                <tr>
                    <td><strong>Average Hourly Activities:</strong></td>
                    <td>{{ $stats['avg_enrollments_per_hour'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Report generated by Shifra Training Center Analytics System</p>
        <p>For more information, contact: admin@shifra.com</p>
        <p>© {{ date('Y') }} Shifra Training Center. All rights reserved.</p>
    </div>
</body>
</html>