<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Analytics Report - {{ now()->format('Y-m-d') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
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
            font-size: 24px;
            margin: 0 0 10px 0;
        }
        
        .header .subtitle {
            color: #666;
            font-size: 14px;
        }
        
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .section-title {
            background: #f8fafc;
            padding: 10px;
            border-left: 4px solid #2D3E50;
            margin-bottom: 15px;
            color: #2D3E50;
            font-weight: bold;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stat-box {
            border: 1px solid #e2e8f0;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
        }
        
        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #2D3E50;
            display: block;
        }
        
        .stat-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th {
            background: #f8fafc;
            padding: 10px;
            text-align: left;
            border: 1px solid #e2e8f0;
            font-weight: bold;
            color: #2D3E50;
            font-size: 11px;
        }
        
        td {
            padding: 10px;
            border: 1px solid #e2e8f0;
            font-size: 11px;
        }
        
        .revenue {
            color: #065f46;
            font-weight: bold;
        }
        
        .growth-positive {
            color: #065f46;
        }
        
        .growth-negative {
            color: #dc2626;
        }
        
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #666;
            font-size: 10px;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Revenue Analytics Report</h1>
        <div class="subtitle">
            Generated on {{ now()->format('F d, Y') }} | 
            Period: {{ ucfirst($filter) }}
        </div>
    </div>
    
    <!-- Revenue Statistics -->
    <div class="section">
        <div class="section-title">Revenue Overview</div>
        <div class="stats-grid">
            <div class="stat-box">
                <span class="stat-value">${{ number_format($revenueStats['total_revenue'] ?? 0, 2) }}</span>
                <span class="stat-label">Total Revenue</span>
            </div>
            <div class="stat-box">
                <span class="stat-value">{{ number_format($revenueStats['total_enrollments'] ?? 0) }}</span>
                <span class="stat-label">Total Enrollments</span>
            </div>
            <div class="stat-box">
                <span class="stat-value">${{ number_format($revenueStats['average_ticket_size'] ?? 0, 2) }}</span>
                <span class="stat-label">Average Ticket Size</span>
            </div>
            <div class="stat-box">
                <span class="stat-value">{{ number_format($revenueStats['growth_rate'] ?? 0, 1) }}%</span>
                <span class="stat-label">Growth Rate</span>
            </div>
            <div class="stat-box">
                <span class="stat-value">${{ number_format($revenueStats['current_month_revenue'] ?? 0, 2) }}</span>
                <span class="stat-label">This Month Revenue</span>
            </div>
            <div class="stat-box">
                <span class="stat-value">${{ number_format($revenueStats['today_revenue'] ?? 0, 2) }}</span>
                <span class="stat-label">Today's Revenue</span>
            </div>
        </div>
    </div>
    
    <!-- Monthly Revenue Table -->
    <div class="section">
        <div class="section-title">Monthly Revenue Breakdown</div>
        <table>
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Revenue</th>
                    <th>Enrollments</th>
                    <th>Avg. Ticket</th>
                    <th>Growth</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlyRevenue as $month)
                @php
                    $avgTicket = $month['enrollments'] > 0 ? $month['revenue'] / $month['enrollments'] : 0;
                    $prevIndex = $loop->index - 1;
                    $prevMonthRevenue = isset($monthlyRevenue[$prevIndex]) ? $monthlyRevenue[$prevIndex]['revenue'] : 0;
                    $growth = $prevMonthRevenue > 0 
                        ? (($month['revenue'] - $prevMonthRevenue) / $prevMonthRevenue) * 100 
                        : ($month['revenue'] > 0 ? 100 : 0);
                @endphp
                <tr>
                    <td>{{ $month['month'] }}</td>
                    <td class="revenue">${{ number_format($month['revenue'], 2) }}</td>
                    <td>{{ $month['enrollments'] }}</td>
                    <td>${{ number_format($avgTicket, 2) }}</td>
                    <td class="{{ $growth > 0 ? 'growth-positive' : 'growth-negative' }}">
                        {{ $growth > 0 ? '+' : '' }}{{ number_format($growth, 1) }}%
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="page-break"></div>
    
    <!-- Payment Methods -->
    <div class="section">
        <div class="section-title">Revenue by Payment Method</div>
        <table>
            <thead>
                <tr>
                    <th>Payment Method</th>
                    <th>Revenue</th>
                    <th>Transactions</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalRevenue = $revenueStats['total_revenue'] ?? 1;
                @endphp
                @foreach($paymentMethods as $method)
                @php
                    $percentage = $totalRevenue > 0 ? ($method['total'] / $totalRevenue) * 100 : 0;
                @endphp
                <tr>
                    <td>{{ ucfirst(str_replace('_', ' ', $method['payment_method'])) }}</td>
                    <td class="revenue">${{ number_format($method['total'], 2) }}</td>
                    <td>{{ $method['count'] }}</td>
                    <td>{{ number_format($percentage, 1) }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Category Revenue -->
    <div class="section">
        <div class="section-title">Revenue by Category</div>
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Revenue</th>
                    <th>Courses</th>
                    <th>Enrollments</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($revenueByCategory as $category)
                @php
                    $percentage = $totalRevenue > 0 ? ($category['revenue'] / $totalRevenue) * 100 : 0;
                @endphp
                <tr>
                    <td>{{ $category['category'] }}</td>
                    <td class="revenue">${{ number_format($category['revenue'], 2) }}</td>
                    <td>{{ $category['courses'] }}</td>
                    <td>{{ $category['enrollments'] }}</td>
                    <td>{{ number_format($percentage, 1) }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="footer">
        <p>Shifra Training Center - Revenue Analytics Report</p>
        <p>Confidential - For internal use only</p>
        <p>Generated on: {{ now()->format('F d, Y H:i') }}</p>
    </div>
</body>
</html>