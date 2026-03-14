@extends('layouts.app')

@section('title', 'About Us - Shifra Training Center')
@section('body-class', 'public-page')

@section('styles')
    <style>
        :root {
            --primary-navy: #2d3e50;
            --secondary-blue: #3182ce;
            --accent-green: #10b981;
            --accent-orange: #f59e0b;
            --accent-purple: #8b5cf6;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --text-light: #94a3b8;
            --bg-light: #f8fbff;
            --white: #ffffff;
            --border-color: #e2e8f0;
        }

        .about-page {
            background: linear-gradient(135deg, #f8fbff 0%, #f0f5fa 100%);
            min-height: 100vh;
            padding: 40px 20px 80px;
        }

        .about-container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Hero Section */
        .hero-section {
            text-align: center;
            margin-bottom: 60px;
            animation: fadeInDown 0.8s ease;
        }

        .hero-title {
            font-size: 48px;
            font-weight: 800;
            color: var(--primary-navy);
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .hero-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--secondary-blue), var(--accent-purple));
            border-radius: 2px;
        }

        .hero-subtitle {
            font-size: 18px;
            color: var(--text-gray);
            max-width: 900px;
            margin: 30px auto 0;
            line-height: 1.8;
        }

        /* Company Info Card */
        .company-card {
            background: white;
            border-radius: 30px;
            padding: 40px;
            margin-bottom: 60px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            animation: fadeInUp 0.8s ease;
        }

        .company-header {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .company-logo {
            width: 100px;
            height: 100px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(45, 62, 80, 0.2);
            border: 3px solid white;
        }

        .company-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .company-name h2 {
            font-size: 32px;
            color: var(--primary-navy);
            margin-bottom: 5px;
            font-weight: 700;
        }

        .company-name p {
            font-size: 18px;
            color: var(--text-gray);
        }

        /* Contact Row - Three Items */
        .contact-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .contact-row {
                grid-template-columns: 1fr;
            }
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            background: #f8fafc;
            border-radius: 15px;
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
        }

        .contact-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            border-color: var(--secondary-blue);
        }

        .contact-icon {
            width: 45px;
            height: 45px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary-blue);
            font-size: 18px;
        }

        .contact-content {
            flex: 1;
        }

        .contact-content h4 {
            font-size: 12px;
            color: var(--text-gray);
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .contact-content p,
        .contact-content a {
            font-size: 14px;
            color: var(--text-dark);
            font-weight: 500;
            text-decoration: none;
        }

        .contact-content a:hover {
            color: var(--secondary-blue);
            text-decoration: underline;
        }

        /* Location Row */
        .location-row {
            width: 100%;
            margin-bottom: 20px;
        }

        .location-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            background: #f8fafc;
            border-radius: 15px;
            transition: all 0.3s ease;
            border: 1px solid var(--border-color);
            width: 100%;
        }

        .location-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            border-color: var(--secondary-blue);
        }

        .location-icon {
            width: 45px;
            height: 45px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary-blue);
            font-size: 18px;
        }

        .location-content {
            flex: 1;
        }

        .location-content h4 {
            font-size: 12px;
            color: var(--text-gray);
            text-transform: uppercase;
            margin-bottom: 2px;
        }

        .location-content p {
            font-size: 14px;
            color: var(--text-dark);
            font-weight: 500;
        }

        .map-container {
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            margin-top: 30px;
        }

        .map-container iframe {
            width: 100%;
            height: 300px;
            border: none;
        }

        /* Stats Section */
        .stats-section {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-bottom: 60px;
        }

        @media (max-width: 992px) {
            .stats-section {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .stats-section {
                grid-template-columns: 1fr;
            }
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            animation: fadeInUp 0.8s ease;
            animation-fill-mode: both;
        }

        .stat-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .stat-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .stat-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .stat-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: var(--secondary-blue);
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary-navy), var(--secondary-blue));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin: 0 auto 20px;
            box-shadow: 0 10px 20px rgba(45, 62, 80, 0.2);
        }

        .stat-number {
            display: block;
            font-size: 36px;
            font-weight: 800;
            color: var(--primary-navy);
            margin-bottom: 5px;
            line-height: 1;
        }

        .stat-label {
            font-size: 14px;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* MISSION SECTION */
        .mission-container {
            background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
            border-radius: 40px;
            padding: 60px 40px;
            margin: 60px 0;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(49, 130, 206, 0.1);
            position: relative;
            overflow: hidden;
        }

        .mission-container::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(49, 130, 206, 0.03) 0%, transparent 70%);
            border-radius: 50%;
        }

        .mission-grid {
            display: flex;
            gap: 40px;
            position: relative;
            z-index: 2;
            flex-wrap: wrap;
        }

        /* Vertical Mission Text */
        .mission-vertical {
            width: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--secondary-blue), var(--accent-purple));
            padding: 15px 5px;
            border-radius: 50px;
            box-shadow: 0 20px 40px rgba(49, 130, 206, 0.3);
            animation: glowPulse 3s infinite;
            height: fit-content;
            align-self: center;
        }

        @media (max-width: 992px) {
            .mission-vertical {
                width: 100%;
                flex-direction: row;
                padding: 10px 20px;
                border-radius: 40px;
            }
        }

        @keyframes glowPulse {

            0%,
            100% {
                box-shadow: 0 20px 40px rgba(49, 130, 206, 0.3);
            }

            50% {
                box-shadow: 0 30px 60px rgba(139, 92, 246, 0.4);
            }
        }

        .vertical-letter {
            font-size: 28px;
            font-weight: 800;
            color: white;
            line-height: 1.3;
            text-transform: uppercase;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            animation: letterGlow 2s infinite;
        }

        .vertical-letter:nth-child(odd) {
            animation-delay: 0.2s;
        }

        @keyframes letterGlow {

            0%,
            100% {
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            }

            50% {
                text-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
            }
        }

        @media (max-width: 992px) {
            .vertical-letter {
                font-size: 24px;
                margin: 0 3px;
            }
        }

        /* Mission Center Content - Flexible */
        .mission-center {
            flex: 1;
            min-width: 300px;
        }

        .mission-headline {
            font-size: 38px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 30px;
            color: var(--primary-navy);
            background: linear-gradient(135deg, #2d3e50, #3182ce);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            display: inline-block;
            white-space: nowrap;
        }

        .mission-headline::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--secondary-blue), var(--accent-purple));
            border-radius: 2px;
        }

        @media (max-width: 1200px) {
            .mission-headline {
                font-size: 36px;
                white-space: normal;
            }
        }

        @media (max-width: 768px) {
            .mission-headline {
                font-size: 28px;
            }
        }

        .mission-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        @media (max-width: 480px) {
            .mission-cards {
                grid-template-columns: 1fr;
            }
        }

        .mission-card {
            background: white;
            padding: 20px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .mission-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 30px rgba(49, 130, 206, 0.1);
            border-color: #3182ce;
        }

        .card-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #3182ce, #8b5cf6);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            flex-shrink: 0;
        }

        .card-text h4 {
            font-size: 15px;
            color: #2d3e50;
            margin-bottom: 4px;
            font-weight: 700;
        }

        .card-text p {
            font-size: 12px;
            color: #64748b;
            line-height: 1.5;
            margin: 0;
        }

        /* Animated Dots Cycle */
        .mission-visual {
            width: 350px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 1200px) {
            .mission-visual {
                width: 100%;
                margin-top: 30px;
            }
        }

        .cycle-container {
            position: relative;
            width: 280px;
            height: 280px;
            margin: 0 auto;
        }

        .cycle-core {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 140px;
            height: 140px;
            background: linear-gradient(135deg, #3182ce, #8b5cf6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
            box-shadow: 0 20px 40px rgba(49, 130, 206, 0.3);
            z-index: 3;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(-50%, -50%) scale(1);
            }

            50% {
                transform: translate(-50%, -50%) scale(1.05);
            }
        }

        .cycle-ring {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 2px dashed rgba(49, 130, 206, 0.3);
            border-radius: 50%;
            animation: spin 20s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .cycle-dot {
            position: absolute;
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            border: 3px solid #3182ce;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #3182ce;
            transition: all 0.5s ease;
            cursor: pointer;
            z-index: 4;
        }

        .cycle-dot:hover {
            transform: scale(1.1);
            border-color: var(--accent-purple);
            color: var(--accent-purple);
        }

        .cycle-dot.dot-1 {
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
        }

        .cycle-dot.dot-2 {
            top: 50%;
            right: -15px;
            transform: translateY(-50%);
        }

        .cycle-dot.dot-3 {
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
        }

        .cycle-dot.dot-4 {
            top: 50%;
            left: -15px;
            transform: translateY(-50%);
        }

        .cycle-content {
            margin-top: 40px;
            text-align: center;
            min-height: 90px;
            width: 100%;
        }

        .cycle-step {
            display: none;
            animation: fadeStep 0.5s ease;
            background: white;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
        }

        .cycle-step.active {
            display: block;
        }

        @keyframes fadeStep {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .step-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-navy);
            margin-bottom: 8px;
        }

        .step-description {
            font-size: 13px;
            color: var(--text-gray);
            line-height: 1.5;
            max-width: 280px;
            margin: 0 auto;
        }

        /* Features Section */
        .features-section {
            margin-bottom: 60px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 32px;
            color: var(--primary-navy);
            font-weight: 700;
            margin-bottom: 10px;
        }

        .section-subtitle {
            color: var(--text-gray);
            font-size: 16px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }

        @media (max-width: 992px) {
            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .features-grid {
                grid-template-columns: 1fr;
            }
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 30px 25px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            animation: fadeInUp 0.8s ease;
            animation-fill-mode: both;
        }

        .feature-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .feature-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .feature-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .feature-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .feature-card:nth-child(5) {
            animation-delay: 0.5s;
        }

        .feature-card:nth-child(6) {
            animation-delay: 0.6s;
        }

        .feature-card:nth-child(7) {
            animation-delay: 0.7s;
        }

        .feature-card:nth-child(8) {
            animation-delay: 0.8s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: var(--accent-purple);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--accent-purple), var(--secondary-blue));
            color: white;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
            box-shadow: 0 10px 20px rgba(139, 92, 246, 0.2);
        }

        .feature-card h3 {
            font-size: 18px;
            color: var(--primary-navy);
            margin-bottom: 10px;
            font-weight: 600;
        }

        .feature-card p {
            color: var(--text-gray);
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
        }

        /* Designer Section */
        .designer-section {
            background: white;
            border-radius: 30px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--border-color);
            margin-bottom: 60px;
            animation: fadeInUp 0.8s ease;
        }

        .designer-header {
            display: flex;
            align-items: center;
            gap: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .designer-avatar {
            width: 120px;
            height: 120px;
            border-radius: 60px;
            background: linear-gradient(135deg, var(--primary-navy), var(--secondary-blue));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
            font-weight: 700;
            box-shadow: 0 20px 40px rgba(45, 62, 80, 0.2);
            border: 4px solid white;
            overflow: hidden;
        }

        .designer-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .designer-info h3 {
            font-size: 28px;
            color: var(--primary-navy);
            margin-bottom: 5px;
            font-weight: 700;
        }

        .designer-title {
            font-size: 16px;
            color: var(--text-gray);
            margin-bottom: 15px;
        }

        .designer-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .badge {
            padding: 6px 15px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .badge-university {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-faculty {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-department {
            background: #fef3c7;
            color: #92400e;
        }

        .github-badge {
            background: #1e293b;
            color: white;
            padding: 6px 15px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .github-badge:hover {
            background: var(--primary-navy);
            transform: translateY(-2px);
        }

        .designer-body {
            margin-top: 30px;
        }

        .designer-bio {
            margin-bottom: 30px;
        }

        .designer-bio h4 {
            font-size: 18px;
            color: var(--primary-navy);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .designer-bio p {
            color: var(--text-gray);
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 15px;
        }

        .project-details {
            background: #f8fafc;
            border-radius: 20px;
            padding: 25px;
            margin-top: 20px;
        }

        .project-details h4 {
            font-size: 18px;
            color: var(--primary-navy);
            margin-bottom: 20px;
            font-weight: 600;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        @media (max-width: 768px) {
            .details-grid {
                grid-template-columns: 1fr;
            }
        }

        .detail-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .detail-row i {
            width: 36px;
            height: 36px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary-blue);
            font-size: 16px;
        }

        .detail-row strong {
            font-size: 13px;
            color: var(--text-gray);
            font-weight: 600;
            display: block;
            margin-bottom: 2px;
        }

        .detail-row p {
            font-size: 14px;
            color: var(--text-dark);
            font-weight: 500;
            margin: 0;
        }

        .tech-stack {
            background: #f8fafc;
            border-radius: 20px;
            padding: 25px;
            height: 100%;
        }

        .tech-stack h4 {
            font-size: 18px;
            color: var(--primary-navy);
            margin-bottom: 20px;
            font-weight: 600;
        }

        .tech-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .tech-badge {
            background: white;
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-dark);
            border: 1px solid var(--border-color);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .tech-badge:hover {
            background: var(--primary-navy);
            color: white;
            border-color: var(--primary-navy);
            transform: translateY(-2px);
        }

        .tech-badge i {
            font-size: 16px;
        }

        .tools-section {
            margin-top: 20px;
        }

        .tools-section h5 {
            font-size: 14px;
            color: var(--text-gray);
            margin-bottom: 10px;
            font-weight: 600;
        }

        .tool-badge {
            background: #e2e8f0;
            color: var(--text-dark);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
            margin: 0 5px 5px 0;
        }

        /* Social Links */
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            justify-content: center;
        }

        .social-link {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: #f1f5f9;
            color: var(--text-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-link:hover {
            transform: translateY(-5px);
        }

        .social-link.whatsapp:hover {
            background: #25D366;
            color: white;
        }

        .social-link.instagram:hover {
            background: linear-gradient(45deg, #f09433, #d62976, #962fbf, #4f5bd5);
            color: white;
        }

        .social-link.email:hover {
            background: #ea4335;
            color: white;
        }

        .social-link.map:hover {
            background: #34a853;
            color: white;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animation delays for mission cards */
        .mission-card:nth-child(1) {
            animation: fadeInUp 0.5s ease 0.1s both;
        }

        .mission-card:nth-child(2) {
            animation: fadeInUp 0.5s ease 0.2s both;
        }

        .mission-card:nth-child(3) {
            animation: fadeInUp 0.5s ease 0.3s both;
        }

        .mission-card:nth-child(4) {
            animation: fadeInUp 0.5s ease 0.4s both;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 36px;
            }

            .company-header {
                flex-direction: column;
                text-align: center;
            }

            .designer-header {
                flex-direction: column;
                text-align: center;
            }

            .designer-badges {
                justify-content: center;
            }

            .stats-section {
                gap: 15px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="about-page">
        <div class="about-container">
            <!-- Hero Section -->
            <div class="hero-section">
                <h1 class="hero-title">About Shifra Training Center</h1>
                <p class="hero-subtitle">
                    Shifra Training Center is a leading educational institution dedicated to providing high-quality,
                    accessible learning opportunities for professionals and students worldwide. Our platform bridges the gap
                    between traditional education and modern technology, offering a comprehensive learning experience that
                    combines live sessions, interactive materials, and personalized learning paths.
                </p>
            </div>

            <!-- Company Information Card -->
            <div class="company-card">
                <div class="company-header">
                    <div class="company-logo">
                        <img src="{{ asset('images/logo-icon.jpeg') }}" alt="Shifra Logo">
                    </div>
                    <div class="company-name">
                        <h2>{{ $company['name'] }}</h2>
                        <p>{{ $company['name_en'] }}</p>
                    </div>
                </div>

                <!-- Contact Row - Three Items -->
                <div class="contact-row">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-content">
                            <h4>Email</h4>
                            <p><a href="mailto:{{ $company['email'] }}">{{ $company['email'] }}</a></p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="contact-content">
                            <h4>WhatsApp Channel</h4>
                            <p><a href="{{ $company['whatsapp'] }}" target="_blank">Family Channel</a></p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fab fa-instagram"></i>
                        </div>
                        <div class="contact-content">
                            <h4>Instagram</h4>
                            <p><a href="{{ $company['instagram'] }}" target="_blank">@shifra.center</a></p>
                        </div>
                    </div>
                </div>

                <!-- Location Row - Full Width -->
                <div class="location-row">
                    <div class="location-item">
                        <div class="location-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="location-content">
                            <h4>Location</h4>
                            <p>{{ $company['location'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Google Map -->
                <div class="map-container">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5405.944813507409!2d34.4353623!3d31.5243795!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14fd7f5a0b9b9b9b%3A0x9b9b9b9b9b9b9b9b!2sAl-Shifa%20Medical%20Complex!5e0!3m2!1sen!2s!4v1700000000000!5m2!1sen!2s"
                        allowfullscreen="" loading="lazy">
                    </iframe>
                </div>

                <!-- Social Links -->
                <div class="social-links">
                    <a href="mailto:{{ $company['email'] }}" class="social-link email" title="Email">
                        <i class="fas fa-envelope"></i>
                    </a>
                    <a href="{{ $company['whatsapp'] }}" target="_blank" class="social-link whatsapp" title="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="{{ $company['instagram'] }}" target="_blank" class="social-link instagram" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="{{ $company['map_url'] }}" target="_blank" class="social-link map" title="Location">
                        <i class="fas fa-map-marker-alt"></i>
                    </a>
                </div>
            </div>

            <!-- MISSION SECTION -->
            <div class="mission-container">
                <div class="mission-grid">
                    <!-- Vertical "OUR MISSION" -->
                    <div class="mission-vertical">
                        <span class="vertical-letter">O</span>
                        <span class="vertical-letter">U</span>
                        <span class="vertical-letter">R</span>
                        <span class="vertical-letter">&nbsp;</span>
                        <span class="vertical-letter">M</span>
                        <span class="vertical-letter">I</span>
                        <span class="vertical-letter">S</span>
                        <span class="vertical-letter">S</span>
                        <span class="vertical-letter">I</span>
                        <span class="vertical-letter">O</span>
                        <span class="vertical-letter">N</span>
                    </div>

                    <!-- Center Content -->
                    <div class="mission-center">
                        <h2 class="mission-headline">Empowering Learners, Transforming Futures</h2>

                        <div class="mission-cards">
                            <div class="mission-card">
                                <div class="card-icon">
                                    <i class="fas fa-microchip"></i>
                                </div>
                                <div class="card-text">
                                    <h4>Cutting-Edge Skills</h4>
                                    <p>Master the latest technologies with AI-powered learning paths</p>
                                </div>
                            </div>
                            <div class="mission-card">
                                <div class="card-icon">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div class="card-text">
                                    <h4>Expert Instructors</h4>
                                    <p>Learn from industry professionals with real-world experience</p>
                                </div>
                            </div>
                            <div class="mission-card">
                                <div class="card-icon">
                                    <i class="fas fa-globe-asia"></i>
                                </div>
                                <div class="card-text">
                                    <h4>Global Access</h4>
                                    <p>Quality education accessible anywhere, anytime</p>
                                </div>
                            </div>
                            <div class="mission-card">
                                <div class="card-icon">
                                    <i class="fas fa-robot"></i>
                                </div>
                                <div class="card-text">
                                    <h4>AI-Powered</h4>
                                    <p>Personalized learning journeys adapted to your goals</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Animated Dots Cycle -->
                    <div class="mission-visual">
                        <div class="cycle-container">
                            <div class="cycle-core">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="cycle-ring"></div>
                            <div class="cycle-dot dot-1" data-step="1">
                                <i class="fas fa-microchip"></i>
                            </div>
                            <div class="cycle-dot dot-2" data-step="2">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <div class="cycle-dot dot-3" data-step="3">
                                <i class="fas fa-globe-asia"></i>
                            </div>
                            <div class="cycle-dot dot-4" data-step="4">
                                <i class="fas fa-robot"></i>
                            </div>
                        </div>

                        <div class="cycle-content">
                            <div class="cycle-step" id="step-1">
                                <div class="step-title">Cutting-Edge Skills</div>
                                <div class="step-description">Master the latest technologies with AI-powered learning paths
                                </div>
                            </div>
                            <div class="cycle-step" id="step-2">
                                <div class="step-title">Expert Instructors</div>
                                <div class="step-description">Learn from industry professionals with real-world experience
                                </div>
                            </div>
                            <div class="cycle-step" id="step-3">
                                <div class="step-title">Global Access</div>
                                <div class="step-description">Quality education accessible anywhere, anytime</div>
                            </div>
                            <div class="cycle-step" id="step-4">
                                <div class="step-title">AI-Powered</div>
                                <div class="step-description">Personalized learning journeys adapted to your goals</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="stats-section">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <span class="stat-number">{{ $stats['total_courses'] }}</span>
                    <span class="stat-label">Courses</span>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <span class="stat-number">{{ $stats['total_students'] }}</span>
                    <span class="stat-label">Students</span>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <span class="stat-number">{{ $stats['instructors'] }}</span>
                    <span class="stat-label">Instructors</span>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <span class="stat-number">{{ $stats['success_rate'] }}%</span>
                    <span class="stat-label">Success Rate</span>
                </div>
            </div>

            <!-- Features Section -->
            <div class="features-section">
                <div class="section-header">
                    <h2 class="section-title">Why Choose Shifra?</h2>
                    <p class="section-subtitle">Discover what makes our learning platform unique</p>
                </div>
                <div class="features-grid">
                    @foreach($features as $feature)
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas {{ $feature['icon'] }}"></i>
                            </div>
                            <h3>{{ $feature['title'] }}</h3>
                            <p>{{ $feature['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Designer Information -->
            <div class="designer-section">
                <div class="designer-header">
                    <div class="designer-avatar">
                        @if(file_exists(public_path('images/hasan-sammour.jpeg')))
                            <img src="{{ asset('images/hasan-sammour.jpeg') }}" alt="Hasan Younis Sammour">
                        @else
                            HS
                        @endif
                    </div>
                    <div class="designer-info">
                        <h3>{{ $designer['name'] }}</h3>
                        <p class="designer-title">{{ $designer['title'] }}</p>
                        <div class="designer-badges">
                            <span class="badge badge-university">
                                <i class="fas fa-university"></i>
                                {{ $designer['university'] }}
                            </span>
                            <span class="badge badge-faculty">
                                <i class="fas fa-microchip"></i>
                                {{ $designer['faculty'] }}
                            </span>
                            <span class="badge badge-department">
                                <i class="fas fa-code"></i>
                                {{ $designer['department'] }}
                            </span>
                            <a href="{{ $designer['github'] }}" target="_blank" class="github-badge">
                                <i class="fab fa-github"></i>
                                GitHub
                            </a>
                        </div>
                    </div>
                </div>

                <div class="designer-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="designer-bio">
                                <h4>About the Developer</h4>
                                <p>{{ $designer['bio'] }}</p>
                            </div>

                            <div class="project-details">
                                <h4>Project Details</h4>
                                <div class="details-grid">
                                    <div class="detail-row">
                                        <i class="fas fa-calendar-alt"></i>
                                        <div>
                                            <strong>Duration</strong>
                                            <p>{{ $designer['project_duration'] }}</p>
                                        </div>
                                    </div>
                                    <div class="detail-row">
                                        <i class="fas fa-tag"></i>
                                        <div>
                                            <strong>Project Type</strong>
                                            <p>{{ $designer['project_type'] }}</p>
                                        </div>
                                    </div>
                                    <div class="detail-row">
                                        <i class="fas fa-calendar-check"></i>
                                        <div>
                                            <strong>Year</strong>
                                            <p>{{ $designer['year'] }}</p>
                                        </div>
                                    </div>
                                    <div class="detail-row">
                                        <i class="fas fa-check-circle"></i>
                                        <div>
                                            <strong>Status</strong>
                                            <p>{{ $designer['status'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="tech-stack">
                                <h4>Technical Stack</h4>
                                <div class="tech-list">
                                    @foreach($techStack as $tech)
                                        <span class="tech-badge">
                                            <i class="{{ $tech['icon'] }}"></i>
                                            {{ $tech['name'] }}
                                        </span>
                                    @endforeach
                                </div>

                                <div class="tools-section">
                                    <h5>Development Tools</h5>
                                    @foreach($tools as $tool)
                                        <span class="tool-badge">{{ $tool }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Animated Dots Cycle
            const dots = document.querySelectorAll('.cycle-dot');
            const steps = document.querySelectorAll('.cycle-step');
            let currentStep = 1;
            const totalSteps = steps.length;

            // Function to activate a step
            function activateStep(stepNumber) {
                // Remove active class from all steps
                steps.forEach(step => step.classList.remove('active'));

                // Add active class to current step
                const activeStep = document.getElementById(`step-${stepNumber}`);
                if (activeStep) {
                    activeStep.classList.add('active');
                }

                // Highlight the corresponding dot
                dots.forEach(dot => {
                    dot.style.transform = '';
                    dot.style.borderColor = '#3182ce';
                    dot.style.color = '#3182ce';
                });

                const activeDot = document.querySelector(`.cycle-dot[data-step="${stepNumber}"]`);
                if (activeDot) {
                    activeDot.style.transform = 'scale(1.2)';
                    activeDot.style.borderColor = '#8b5cf6';
                    activeDot.style.color = '#8b5cf6';
                }
            }

            // Initialize first step
            activateStep(1);

            // Cycle through steps every 2 seconds
            setInterval(() => {
                currentStep = (currentStep % totalSteps) + 1;
                activateStep(currentStep);
            }, 2000);

            // Allow clicking on dots to change step
            dots.forEach(dot => {
                dot.addEventListener('click', function () {
                    const stepNumber = parseInt(this.getAttribute('data-step'));
                    currentStep = stepNumber;
                    activateStep(stepNumber);
                });
            });

            // Intersection Observer for animations
            const animatedElements = document.querySelectorAll('.stat-card, .feature-card, .company-card, .designer-section');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px'
            });

            animatedElements.forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(30px)';
                element.style.transition = 'all 0.6s ease';
                observer.observe(element);
            });

            // Hover effects for cards
            document.querySelectorAll('.stat-card, .feature-card, .contact-item, .location-item, .mission-card').forEach(card => {
                card.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-5px)';
                });
                card.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Smooth scroll for any anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
@endsection