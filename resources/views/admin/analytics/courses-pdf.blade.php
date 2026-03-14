<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Course Analytics Report - {{ now()->format('Y-m-d') }}</title>
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
        <h1>Course Analytics Report</h1>
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
                <span class="stat-value">{{ $courseStats['total'] ?? 0 }}</span>
                <span class="stat-label">Total Courses</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">{{ $courseStats['active'] ?? 0 }}</span>
                <span class="stat-label">Active Courses</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">{{ $courseStats['featured'] ?? 0 }}</span>
                <span class="stat-label">Featured Courses</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">${{ number_format($courseStats['average_price'] ?? 0, 2) }}</span>
                <span class="stat-label">Average Price</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">{{ number_format($courseStats['average_rating'] ?? 0, 1) }}</span>
                <span class="stat-label">Average Rating</span>
            </div>
            <div class="stat-card">
                <span class="stat-value">${{ number_format($courseStats['total_revenue'] ?? 0, 2) }}</span>
                <span class="stat-label">Total Revenue</span>
            </div>
        </div>
    </div>

    <!-- Rating Distribution -->
    @if(isset($ratingDistribution) && count($ratingDistribution) > 0)
    <div class="mb-20">
        <h2 class="section-title">Rating Distribution</h2>
        <table>
            <thead>
                <tr>
                    <th>Rating Range</th>
                    <th>Number of Courses</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalRatingCount = 0;
                    foreach($ratingDistribution as $rating) {
                        $totalRatingCount += $rating['count'] ?? 0;
                    }
                @endphp
                @foreach($ratingDistribution as $rating)
                @php
                    $percentage = $totalRatingCount > 0 ? (($rating['count'] ?? 0) / $totalRatingCount) * 100 : 0;
                @endphp
                <tr>
                    <td>{{ $rating['range'] ?? '' }}</td>
                    <td>{{ $rating['count'] ?? 0 }}</td>
                    <td>{{ number_format($percentage, 1) }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Enrollment Trends -->
    @if(isset($enrollmentTrends) && count($enrollmentTrends) > 0)
    <div class="mb-20">
        <h2 class="section-title">Enrollment Trends (Last 7 Days)</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Enrollments</th>
                    <th>Revenue</th>
                </tr>
            </thead>
            <tbody>
                @foreach($enrollmentTrends as $trend)
                <tr>
                    <td>{{ $trend['full_date'] ?? $trend['date'] ?? '' }}</td>
                    <td>{{ $trend['enrollments'] ?? 0 }}</td>
                    <td>${{ number_format($trend['revenue'] ?? 0, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Revenue by Category -->
    @if(isset($revenueByCategory) && count($revenueByCategory) > 0)
    <div class="mb-20">
        <h2 class="section-title">Revenue by Category</h2>
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Revenue</th>
                    <th>Courses</th>
                    <th>Enrollments</th>
                </tr>
            </thead>
            <tbody>
                @foreach($revenueByCategory as $category)
                <tr>
                    <td>{{ $category['name'] ?? '' }}</td>
                    <td>${{ number_format($category['revenue'] ?? 0, 2) }}</td>
                    <td>{{ $category['courses'] ?? 0 }}</td>
                    <td>{{ $category['enrollments'] ?? 0 }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Course List -->
    <div class="mb-20">
        <h2 class="section-title">Course List</h2>
        <table>
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Category</th>
                    <th>Students</th>
                    <th>Rating</th>
                    <th>Price</th>
                    <th>Revenue</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                @php
                    $revenue = $course->enrollments_sum_amount_paid ?? 0;
                @endphp
                <tr>
                    <td>{{ $course->title }}</td>
                    <td>{{ $course->category->name ?? 'Uncategorized' }}</td>
                    <td>{{ $course->total_students }}</td>
                    <td>{{ number_format($course->rating, 1) }}</td>
                    <td>${{ number_format($course->final_price, 2) }}</td>
                    <td>${{ number_format($revenue, 2) }}</td>
                    <td>
                        @if($course->is_active && $course->is_featured)
                            Featured
                        @elseif($course->is_active)
                            Active
                        @else
                            Inactive
                        @endif
                    </td>
                </tr>
                @endforeach
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