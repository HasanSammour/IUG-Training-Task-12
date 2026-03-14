<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Completion - {{ $user->name }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        
        body {
            font-family: 'DejaVu Sans', 'Georgia', serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            color: #2D3E50;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .certificate-wrapper {
            width: 100%;
            max-width: 1100px;
            margin: 30px auto;
            position: relative;
        }
        
        .certificate {
            background: white;
            border: 20px solid #f1f5f9;
            padding: 50px;
            position: relative;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border-radius: 20px;
        }
        
        .certificate::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 2px solid #2D3E50;
            border-radius: 10px;
            pointer-events: none;
        }
        
        .certificate-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 3px solid #e2e8f0;
        }
        
        .logo {
            font-size: 48px;
            font-weight: 800;
            color: #2D3E50;
            letter-spacing: 5px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .logo-sub {
            font-size: 16px;
            color: #64748b;
            letter-spacing: 8px;
            text-transform: uppercase;
        }
        
        .certificate-title {
            text-align: center;
            font-size: 32px;
            color: #2D3E50;
            margin-bottom: 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 8px;
        }
        
        .award-text {
            text-align: center;
            font-size: 18px;
            color: #475569;
            margin-bottom: 20px;
        }
        
        .recipient-name {
            text-align: center;
            font-size: 48px;
            font-weight: 800;
            color: #2D3E50;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 4px;
            border-bottom: 2px solid #f1f5f9;
            border-top: 2px solid #f1f5f9;
            padding: 20px 0;
        }
        
        .course-name {
            text-align: center;
            font-size: 28px;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 20px;
            font-style: italic;
        }
        
        .completion-text {
            text-align: center;
            font-size: 16px;
            color: #64748b;
            margin-bottom: 30px;
            line-height: 1.8;
        }
        
        .details-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin: 40px 0;
        }
        
        .detail-item {
            text-align: center;
        }
        
        .detail-label {
            font-size: 14px;
            color: #64748b;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .detail-value {
            font-size: 18px;
            font-weight: 700;
            color: #2D3E50;
        }
        
        .signature-section {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 50px;
            margin-top: 60px;
            margin-bottom: 30px;
        }
        
        .signature-box {
            text-align: center;
        }
        
        .signature-line {
            width: 80%;
            margin: 0 auto 10px;
            border-bottom: 2px solid #2D3E50;
            padding-bottom: 10px;
        }
        
        .signature-name {
            font-weight: 700;
            color: #2D3E50;
            margin-bottom: 5px;
        }
        
        .signature-title {
            font-size: 12px;
            color: #64748b;
        }
        
        .certificate-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #94a3b8;
        }
        
        .seal {
            position: absolute;
            bottom: 60px;
            right: 60px;
            width: 100px;
            height: 100px;
            background: #2D3E50;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 40px;
            opacity: 0.9;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .verification {
            position: absolute;
            bottom: 60px;
            left: 60px;
            font-size: 11px;
            color: #94a3b8;
        }
        
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-25deg);
            font-size: 120px;
            color: rgba(45, 62, 80, 0.05);
            font-weight: 800;
            white-space: nowrap;
            z-index: 0;
        }
    </style>
</head>
<body>
    <div class="certificate-wrapper">
        <div class="certificate">
            <div class="watermark">SHIFRA</div>
            
            <div class="certificate-header">
                <div class="logo">shifra</div>
                <div class="logo-sub">TRAINING CENTER</div>
            </div>
            
            <div class="certificate-title">Certificate of Completion</div>
            
            <div class="award-text">This certificate is proudly presented to</div>
            
            <div class="recipient-name">{{ $user->name }}</div>
            
            <div class="award-text">for successfully completing the course</div>
            
            <div class="course-name">{{ $course->title }}</div>
            
            <div class="completion-text">
                This student has demonstrated exceptional dedication and mastery of the course material,
                completing all requirements with a final grade of <strong>{{ $enrollment->progress_percentage }}%</strong>.
            </div>
            
            <div class="details-grid">
                <div class="detail-item">
                    <div class="detail-label">Completion Date</div>
                    <div class="detail-value">{{ $enrollment->completed_at ? $enrollment->completed_at->format('F d, Y') : now()->format('F d, Y') }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Course Duration</div>
                    <div class="detail-value">{{ $course->duration ?? '4 weeks' }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Certificate ID</div>
                    <div class="detail-value">SHF-{{ str_pad($enrollment->id, 6, '0', STR_PAD_LEFT) }}-{{ $enrollment->completed_at ? $enrollment->completed_at->format('Ymd') : now()->format('Ymd') }}</div>
                </div>
            </div>
            
            <div class="signature-section">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-name">{{ $course->instructor_name }}</div>
                    <div class="signature-title">Course Instructor</div>
                </div>
                
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-name">Dr. Ahmed Al-Mansour</div>
                    <div class="signature-title">Academic Director</div>
                </div>
            </div>
            
            <div class="certificate-footer">
                <p>This certificate is verifiable at https://shifra-training.com/verify/{{ str_pad($enrollment->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p>© {{ date('Y') }} Shifra Training Center. All rights reserved.</p>
            </div>
            
            <div class="seal">
                <i class="fas fa-certificate"></i>
            </div>
            
            <div class="verification">
                <i class="fas fa-qrcode"></i> Scan to verify
            </div>
        </div>
    </div>
</body>
</html>