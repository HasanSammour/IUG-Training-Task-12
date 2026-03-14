<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shifra - Training Center')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon - Complete Set -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- Bootstrap CSS (Local) -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Font Awesome (Local) -->
    <link href="{{ asset('font-awesome/css/all.min.css') }}" rel="stylesheet">

    <!-- SweetAlert2 CSS (Local) -->
    <link href="{{ asset('sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">

    <!-- Full Calender CSS (Local) -->
    <link href="{{ asset('fullcalendar/main.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-navy: #2d3e50;
            --secondary-blue: #3182ce;
            --text-dark: #333;
            --text-gray: #777;
            --bg-light: #f8fbff;
            --white: #ffffff;
            --border-color: #eee;
            --hover-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
            --active-shadow: 0 2px 8px rgba(45, 62, 80, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            line-height: 1.6;
            background-color: var(--bg-light);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .desktop-header {
            background: var(--white);
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-icon {
            width: 35px;
            height: 35px;
            background: var(--primary-navy);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            overflow: hidden;
        }

        .logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-navy);
        }

        .main-nav {
            display: flex;
            align-items: center;
        }

        .nav-links-row {
            display: flex;
            list-style: none;
            gap: 32px;
            margin: 0;
            padding: 0;
            align-items: center;
        }

        .nav-links-row li {
            position: relative;
        }

        .nav-links-row a {
            text-decoration: none;
            color: #475569;
            font-size: 15px;
            font-weight: 500;
            position: relative;
            padding: 8px 12px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            border-radius: 6px;
            background: transparent;
        }

        .nav-links-row a:hover {
            color: var(--primary-navy);
            background: rgba(45, 62, 80, 0.04);
            transform: translateY(-1px);
        }

        .nav-links-row a:hover::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 2px;
            background: var(--secondary-blue);
            border-radius: 1px;
            animation: underlineSlide 0.3s ease;
        }

        @keyframes underlineSlide {
            from {
                width: 0;
                left: 50%;
            }

            to {
                width: 60%;
                left: 50%;
            }
        }

        .nav-links-row a.active {
            color: var(--primary-navy);
            font-weight: 600;
            background: rgba(45, 62, 80, 0.08);
            box-shadow: var(--active-shadow);
            position: relative;
            z-index: 1;
        }

        .nav-links-row a.active::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, rgba(45, 62, 80, 0.1), rgba(49, 130, 206, 0.1));
            border-radius: 8px;
            z-index: -1;
            animation: pulseGlow 2s infinite;
        }

        @keyframes pulseGlow {

            0%,
            100% {
                opacity: 0.5;
            }

            50% {
                opacity: 0.8;
            }
        }

        .nav-links-row a.active i {
            color: var(--secondary-blue);
        }

        .dashboard-link {
            display: flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #f0f7ff, #e1effe);
            color: #1e40af;
            padding: 8px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid rgba(30, 64, 175, 0.1);
            position: relative;
            overflow: hidden;
        }

        .dashboard-link:hover {
            background: linear-gradient(135deg, #1e40af, #3730a3);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30, 64, 175, 0.2);
        }

        .dashboard-link::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }

        .dashboard-link:hover::after {
            left: 100%;
        }

        .auth-btns {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .link-login {
            text-decoration: none;
            color: var(--primary-navy);
            font-weight: 600;
            font-size: 15px;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.3s ease;
            position: relative;
        }

        .link-login:hover {
            color: var(--secondary-blue);
            background: rgba(49, 130, 206, 0.05);
        }

        .link-login::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--secondary-blue);
            border-radius: 1px;
            transition: width 0.3s ease;
        }

        .link-login:hover::after {
            width: 70%;
        }

        .btn-signup {
            background: linear-gradient(135deg, var(--primary-navy), #1a252f);
            color: var(--white);
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
            position: relative;
            overflow: hidden;
        }

        .btn-signup:hover {
            background: linear-gradient(135deg, #1a252f, #2d3e50);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(45, 62, 80, 0.25);
        }

        .btn-signup::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s;
        }

        .btn-signup:hover::before {
            left: 100%;
        }

        .user-dropdown {
            position: relative;
            display: inline-block;
        }

        .user-dropdown-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--primary-navy);
            font-weight: 600;
            font-size: 15px;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .user-dropdown-btn:hover {
            background: rgba(45, 62, 80, 0.05);
            transform: translateY(-1px);
        }

        .user-dropdown-btn::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--secondary-blue);
            border-radius: 1px;
            transition: width 0.3s ease;
        }

        .user-dropdown-btn:hover::after {
            width: 80%;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-navy), var(--secondary-blue));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            box-shadow: 0 2px 6px rgba(45, 62, 80, 0.2);
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-avatar-wrapper {
            background: none;
            padding: 0;
            overflow: hidden;
        }

        .user-avatar-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            overflow: hidden;
        }

        .user-avatar-img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            min-width: 220px;
            display: none;
            z-index: 1001;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .dropdown-menu.show {
            display: block;
            animation: fadeInDropdown 0.3s ease;
        }

        @keyframes fadeInDropdown {
            from {
                opacity: 0;
                transform: translateY(-10px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            text-decoration: none;
            color: var(--text-dark);
            transition: all 0.3s ease;
            border-bottom: 1px solid #f8fafc;
            position: relative;
            overflow: hidden;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item::before {
            content: '';
            position: absolute;
            left: -100%;
            top: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(45, 62, 80, 0.05), transparent);
            transition: left 0.5s;
        }

        .dropdown-item:hover::before {
            left: 100%;
        }

        .dropdown-item:hover {
            background: #f8fafc;
            color: var(--primary-navy);
            padding-left: 22px;
        }

        .dropdown-item.logout {
            color: #dc2626;
            border-top: 1px solid #f1f5f9;
        }

        .dropdown-item.logout:hover {
            background: #fee2e2;
            color: #b91c1c;
        }

        .dropdown-user-info {
            background: #f8fafc;
            color: #64748b;
            font-size: 12px;
            cursor: default;
        }
        .dropdown-user-info:hover {
            background: #f8fafc;
            padding-left: 18px;
        }
        .dropdown-user-info i {
            color: #64748b;
        }

        .logout-btn {
            background: none;
            border: none;
            cursor: pointer;
            width: 100%;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            color: #dc2626;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #fee2e2;
            color: #b91c1c;
            padding-left: 22px;
        }

        .role-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 700;
            margin-left: 6px;
            text-transform: uppercase;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .role-admin {
            background: linear-gradient(135deg, #1e40af, #3730a3);
            color: white;
        }

        .role-instructor {
            background: linear-gradient(135deg, #065f46, #047857);
            color: white;
        }

        .role-student {
            background: linear-gradient(135deg, #7c3aed, #6d28d9);
            color: white;
        }

        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: var(--white);
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            border-top: 1px solid var(--border-color);
            padding: 12px 0;
            z-index: 1000;
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
            box-shadow: 0 -2px 15px rgba(0, 0, 0, 0.08);
            justify-content: space-around;
        }

        .bottom-nav::-webkit-scrollbar {
            display: none;
        }

        .nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            text-decoration: none;
            color: #94a3b8;
            gap: 4px;
            padding: 8px 0;
            border-radius: 8px;
            margin: 0 2px;
            transition: all 0.3s ease;
            position: relative;
            flex: 1;
            max-width: 80px;
        }

        .nav-item:hover {
            background: rgba(45, 62, 80, 0.05);
            color: var(--primary-navy);
        }

        .nav-item.active {
            color: var(--primary-navy);
            font-weight: bold;
            background: rgba(45, 62, 80, 0.08);
            transform: translateY(-2px);
        }

        .nav-item i {
            font-size: 20px;
            margin-bottom: 4px;
            transition: all 0.3s ease;
        }

        .nav-item.active i {
            color: var(--secondary-blue);
            transform: scale(1.1);
        }

        .nav-item span {
            font-size: 10px;
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .nav-badge {
            position: absolute;
            top: -2px;
            right: 8px;
            background: #ef4444;
            color: white;
            font-size: 9px;
            font-weight: 600;
            min-width: 16px;
            height: 16px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            border: 1px solid white;
            z-index: 2;
        }

        .active-line {
            width: 20px;
            height: 3px;
            background: linear-gradient(90deg, var(--secondary-blue), var(--primary-navy));
            border-radius: 10px;
            margin-bottom: 4px;
            animation: linePulse 2s infinite;
        }

        @keyframes linePulse {

            0%,
            100% {
                opacity: 1;
                transform: scaleX(1);
            }

            50% {
                opacity: 0.8;
                transform: scaleX(1.1);
            }
        }

        .main-footer {
            background: #f8fafc;
            padding: 60px 0 20px;
            border-top: 1px solid #eee;
            margin-top: auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 50px;
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
        }

        @media (max-width: 768px) {
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }

        .footer-brand {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .footer-brand .logo-container {
            justify-content: flex-start;
        }

        .footer-brand p {
            max-width: 300px;
            font-size: 14px;
            color: var(--text-gray);
            line-height: 1.6;
        }

        .footer-links h4 {
            font-size: 16px;
            margin-bottom: 20px;
            color: var(--primary-navy);
        }

        .footer-links ul {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            text-decoration: none;
            color: var(--text-dark);
            font-size: 14px;
            transition: all 0.3s ease;
            padding: 4px 0;
            position: relative;
            display: inline-block;
        }

        .footer-links a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--secondary-blue);
            transition: width 0.3s ease;
        }

        .footer-links a:hover {
            color: var(--primary-navy);
            padding-left: 8px;
        }

        .footer-links a:hover::after {
            width: 100%;
        }

        .social-icons {
            display: flex;
            gap: 15px;
        }

        .social-icons a {
            color: var(--primary-navy);
            font-size: 18px;
            transition: all 0.3s ease;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .social-icons a:hover {
            color: var(--secondary-blue);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            margin-top: 40px;
            border-top: 1px solid var(--border-color);
        }

        .footer-bottom p {
            font-size: 14px;
            color: var(--text-gray);
        }

        .flash-messages {
            position: fixed;
            top: 80px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 10px;
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            animation: slideInRight 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .alert-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .alert-error {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .alert-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }

        .alert-info {
            background: linear-gradient(135deg, var(--secondary-blue), #2563eb);
            color: white;
        }

        .contacts-dropdown {
            position: relative;
            display: inline-block;
        }

        .contacts-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: none;
            border: none;
            cursor: pointer;
            color: #475569;
            font-weight: 500;
            font-size: 15px;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .contacts-btn:hover {
            color: var(--primary-navy);
            background: rgba(45, 62, 80, 0.04);
            transform: translateY(-1px);
        }

        .contacts-menu {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            min-width: 280px;
            display: none;
            z-index: 1001;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .contacts-menu.show {
            display: block;
            animation: fadeInDropdown 0.3s ease;
        }

        .contacts-header {
            padding: 12px 16px;
            background: #f8fafc;
            border-bottom: 1px solid var(--border-color);
            font-weight: 600;
            color: var(--primary-navy);
            font-size: 14px;
        }

        .contacts-search {
            padding: 10px;
            border-bottom: 1px solid #f1f5f9;
        }

        .contacts-search input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            font-size: 13px;
            outline: none;
        }

        .contacts-search input:focus {
            border-color: var(--primary-navy);
        }

        .contacts-list {
            max-height: 300px;
            overflow-y: auto;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s ease;
            border-bottom: 1px solid #f8fafc;
        }

        .contact-item:hover {
            background: #f1f5f9;
        }

        .contact-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-navy), var(--secondary-blue));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            flex-shrink: 0;
        }

        .contact-info {
            flex: 1;
        }

        .contact-name {
            font-weight: 600;
            color: var(--primary-navy);
            font-size: 14px;
            margin-bottom: 2px;
        }

        .contact-role {
            font-size: 11px;
            color: var(--text-gray);
        }

        .contact-message {
            color: var(--secondary-blue);
            font-size: 12px;
        }

        .contacts-footer {
            padding: 12px 16px;
            border-top: 1px solid #f1f5f9;
            text-align: center;
        }

        .contacts-footer a {
            color: var(--secondary-blue);
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }

        .contacts-footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .main-nav {
                display: none;
            }

            .desktop-header .auth-btns {
                display: none;
            }

            .mobile-menu-btn {
                display: block;
                font-size: 24px;
                color: var(--primary-navy);
                background: none;
                border: none;
                cursor: pointer;
                width: 40px;
                height: 40px;
                border-radius: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease;
            }

            .mobile-menu-btn:hover {
                background: rgba(45, 62, 80, 0.05);
            }

            .bottom-nav {
                padding: 8px 5px;
            }

            .nav-item {
                padding: 6px 0;
                max-width: 70px;
            }

            .nav-item span {
                font-size: 9px;
            }

            .nav-badge {
                right: 4px;
                font-size: 8px;
                min-width: 14px;
                height: 14px;
            }
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 20px;
            width: 100%;
        }

        a,
        button {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        html {
            scroll-behavior: smooth;
        }

        /* Mobile Navigation Menu */
        .mobile-nav-menu {
            position: fixed;
            top: 0;
            left: -100%;
            width: 85%;
            max-width: 320px;
            height: 100vh;
            background: white;
            z-index: 2000;
            box-shadow: 2px 0 20px rgba(0,0,0,0.2);
            transition: left 0.3s ease;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .mobile-nav-menu.show {
            left: 0;
        }

        .mobile-nav-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: linear-gradient(135deg, var(--primary-navy), #1a252f);
            color: white;
        }

        .mobile-user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mobile-user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: white;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }

        .mobile-user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mobile-user-avatar i {
            font-size: 40px;
            color: var(--primary-navy);
        }

        .mobile-user-details {
            flex: 1;
        }

        .mobile-user-name {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .mobile-user-email {
            font-size: 12px;
            opacity: 0.8;
        }

        .mobile-nav-close {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .mobile-nav-close:hover {
            background: rgba(255,255,255,0.3);
            transform: scale(1.1);
        }

        .mobile-nav-links {
            flex: 1;
            padding: 20px 0;
        }

        .mobile-nav-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px 20px;
            text-decoration: none;
            color: var(--text-dark);
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            position: relative;
        }

        .mobile-nav-item:hover {
            background: #f8fafc;
            border-left-color: var(--secondary-blue);
            padding-left: 25px;
        }

        .mobile-nav-item.active {
            background: #f0f7ff;
            border-left-color: var(--primary-navy);
            font-weight: 600;
        }

        .mobile-nav-item i {
            width: 24px;
            color: var(--secondary-blue);
            font-size: 18px;
        }

        .mobile-nav-item.active i {
            color: var(--primary-navy);
        }

        .mobile-nav-badge {
            position: absolute;
            right: 20px;
            background: #ef4444;
            color: white;
            font-size: 11px;
            min-width: 20px;
            height: 20px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 6px;
        }

        .mobile-nav-divider {
            height: 1px;
            background: #e2e8f0;
            margin: 15px 20px;
        }

        .mobile-nav-footer {
            padding: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .mobile-logout-btn {
            width: 100%;
            padding: 12px;
            background: #fee2e2;
            color: #dc2626;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .mobile-logout-btn:hover {
            background: #fecaca;
            transform: translateY(-2px);
        }

        .mobile-login-btn {
            background: linear-gradient(135deg, var(--primary-navy), #1a252f);
            color: white !important;
            border-radius: 8px;
            margin: 10px 20px;
        }

        .mobile-signup-btn {
            background: linear-gradient(135deg, var(--secondary-blue), #2563eb);
            color: white !important;
            border-radius: 8px;
            margin: 0 20px 20px;
        }

        /* Overlay when menu is open */
        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1999;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .mobile-menu-overlay.show {
            display: block;
            opacity: 1;
        }

        /* Hide desktop nav on mobile */
        @media (max-width: 768px) {
            .main-nav {
                display: none !important;
            }

            .desktop-header .auth-btns {
                display: none !important;
            }

            .mobile-menu-btn {
                display: block !important;
            }
        }
    </style>

    @yield('styles')
</head>

<body class="@yield('body-class', 'public-page')">

    <div class="flash-messages">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> {{ session('info') }}
            </div>
        @endif
    </div>

    @if(auth()->check() && (request()->routeIs('dashboard') || request()->routeIs('learning-path.*') || request()->routeIs('profile.*') || request()->routeIs('notifications.*') || request()->routeIs('courses.my-courses') || request()->routeIs('admin.*') || request()->routeIs('instructor.*')))
        @php $user = auth()->user(); @endphp
        <header class="desktop-header">
            <div class="header-flex">
                <a href="{{ route('home') }}" class="logo-container">
                    <div class="logo-icon">
                        <img src="{{ asset('images/logo-icon.jpeg') }}" alt="Shifra Logo">
                    </div>
                    <span class="logo-text">shifra</span>
                </a>

                <nav class="main-nav">
                    <ul class="nav-links-row">
                        <!-- Dashboard Link with Role Badge -->
                        @if($user->hasRole('admin'))
                            <li><a href="{{ route('admin.dashboard') }}"
                                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-chart-bar"></i> Dashboard
                                    <span class="role-badge role-admin">Admin</span>
                                </a></li>
                        @elseif($user->hasRole('instructor'))
                            <li><a href="{{ route('instructor.dashboard') }}"
                                    class="{{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-chalkboard-teacher"></i> Dashboard
                                    <span class="role-badge role-instructor">Instructor</span>
                                </a></li>
                        @else
                            <li><a href="{{ route('dashboard') }}"
                                    class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                    <span class="role-badge role-student">Student</span>
                                </a></li>
                        @endif

                        <!-- Home Link -->
                        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                                <i class="fas fa-home"></i> Home
                            </a></li>
                    </ul>
                </nav>

                <div class="auth-btns">
                    <div class="contacts-dropdown">
                        <button class="contacts-btn" id="contactsBtn">
                            <i class="fas fa-address-book"></i>
                            <span>Contacts</span>
                        </button>
                        <div class="contacts-menu" id="contactsMenu">
                            <div class="contacts-header">
                                <i class="fas fa-users"></i> Quick Contacts
                            </div>
                            <div class="contacts-search">
                                <input type="text" placeholder="Search contacts..." id="contactSearch">
                            </div>
                            <div class="contacts-list" id="contactsList">
                                @foreach($recentContacts->take(5) as $contact)
                                    <a href="{{ route('messages.conversation', $contact->id) }}" class="contact-item">
                                        <div class="contact-avatar">
                                            {{ substr($contact->name, 0, 1) }}
                                        </div>
                                        <div class="contact-info">
                                            <div class="contact-name">{{ $contact->name }}</div>
                                            <div class="contact-role">
                                                @if($contact->hasRole('admin')) Administrator
                                                @elseif($contact->hasRole('instructor')) Instructor
                                                @else Student @endif
                                            </div>
                                        </div>
                                        <i class="fas fa-comment contact-message"></i>
                                    </a>
                                @endforeach
                            </div>
                            <div class="contacts-footer">
                                <a href="{{ route('contacts.index') }}">View All Contacts →</a>
                            </div>
                        </div>
                    </div>

                    <div class="user-dropdown">
                        <button class="user-dropdown-btn">
                            <div class="user-avatar-wrapper">
                                <div class="user-avatar-circle">
                                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="user-avatar-img">
                                </div>
                            </div>
                            <span>{{ $user->name }}</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" id="userDropdown">
                            <div class="dropdown-item dropdown-user-info">
                                <i class="fas fa-user-circle"></i>
                                <div>
                                    <strong>{{ $user->name }}</strong><br>
                                    {{ $user->email }}
                                </div>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <i class="fas fa-user"></i> Profile
                            </a>
                            <a href="{{ route('profile.settings') }}" class="dropdown-item">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            @if($user->hasRole('admin'))
                                <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                    <i class="fas fa-shield-alt"></i> Admin Panel
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                                @csrf
                                <button type="submit" class="dropdown-item logout-btn">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <button class="mobile-menu-btn d-lg-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </header>
    @else
        <header class="desktop-header">
            <div class="header-flex">
                <a href="{{ route('home') }}" class="logo-container">
                    <div class="logo-icon">
                        <img src="{{ asset('images/logo-icon.jpeg') }}" alt="Shifra Logo">
                    </div>
                    <span class="logo-text">shifra</span>
                </a>

                <nav class="main-nav">
                    <ul class="nav-links-row">
                        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                                <i class="fas fa-home"></i> Home
                            </a></li>
                        <li><a href="{{ route('courses.public') }}"
                                class="{{ request()->routeIs('courses.public') ? 'active' : '' }}">
                                <i class="fas fa-book-open"></i> Courses
                            </a></li>
                        @auth
                            @if(auth()->user()->hasRole('admin'))
                                <li><a href="{{ route('admin.dashboard') }}" class="dashboard-link">
                                        <i class="fas fa-shield-alt"></i> Admin Panel
                                    </a></li>
                            @elseif(auth()->user()->hasRole('instructor'))
                                <li><a href="{{ route('instructor.dashboard') }}" class="dashboard-link">
                                        <i class="fas fa-chalkboard-teacher"></i> Instructor Panel
                                    </a></li>
                            @else
                                <li><a href="{{ route('dashboard') }}" class="dashboard-link">
                                        <i class="fas fa-tachometer-alt"></i> Student Panel
                                    </a></li>
                            @endif
                        @endauth
                        <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">
                                <i class="fas fa-info-circle"></i> About
                            </a></li>
                        <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                                <i class="fas fa-envelope"></i> Contact
                            </a></li>
                    </ul>
                </nav>

                <div class="auth-btns">
                    @auth
                        <div class="user-dropdown">
                            <button class="user-dropdown-btn">
                                <div class="user-avatar-wrapper">
                                    <div class="user-avatar-circle">
                                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="user-avatar-img">
                                    </div>
                                </div>
                                <span>My Account</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu" id="userDropdown">
                                <a href="{{ auth()->user()->hasRole('admin') ? route('admin.dashboard') : (auth()->user()->hasRole('instructor') ? route('instructor.dashboard') : route('dashboard')) }}"
                                    class="dropdown-item">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                    <i class="fas fa-user"></i> Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                                    @csrf
                                    <button type="submit" class="dropdown-item logout w-100 text-left"
                                        style="background: none; border: none; cursor: pointer;">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="link-login">Login</a>
                        <a href="{{ route('register') }}" class="btn-signup">Sign Up</a>
                    @endauth
                </div>

                <button class="mobile-menu-btn d-lg-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </header>
    @endif

    <!-- Mobile Navigation Menu -->
    <div class="mobile-nav-menu" id="mobileNavMenu">
        <div class="mobile-nav-header">
            <div class="mobile-user-info">
                <div class="mobile-user-avatar">
                    @auth
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}">
                    @else
                        <i class="fas fa-user-circle"></i>
                    @endauth
                </div>
                @auth
                    <div class="mobile-user-details">
                        <div class="mobile-user-name">{{ auth()->user()->name }}</div>
                        <div class="mobile-user-email">{{ auth()->user()->email }}</div>
                    </div>
                @else
                    <div class="mobile-user-details">
                        <div class="mobile-user-name">Guest</div>
                        <div class="mobile-user-email">Sign in to access all features</div>
                    </div>
                @endauth
            </div>
            <button class="mobile-nav-close" id="mobileNavClose">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="mobile-nav-links">
            @auth
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" class="mobile-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i>
                        <span>Admin Dashboard</span>
                    </a>
                    <a href="{{ route('admin.students.index') }}" class="mobile-nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i>
                        <span>Students</span>
                    </a>
                    <a href="{{ route('admin.courses.index') }}" class="mobile-nav-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i>
                        <span>Courses</span>
                    </a>
                @elseif(auth()->user()->hasRole('instructor'))
                    <a href="{{ route('instructor.dashboard') }}" class="mobile-nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Instructor Dashboard</span>
                    </a>
                    <a href="{{ route('instructor.courses') }}" class="mobile-nav-item {{ request()->routeIs('instructor.courses') ? 'active' : '' }}">
                        <i class="fas fa-book"></i>
                        <span>My Courses</span>
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="mobile-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Student Dashboard</span>
                    </a>
                    <a href="{{ route('courses.my-courses') }}" class="mobile-nav-item {{ request()->routeIs('courses.my-courses') ? 'active' : '' }}">
                        <i class="fas fa-graduation-cap"></i>
                        <span>My Courses</span>
                    </a>
                    <a href="{{ route('learning-path.index') }}" class="mobile-nav-item {{ request()->routeIs('learning-path.*') ? 'active' : '' }}">
                        <i class="fas fa-route"></i>
                        <span>Learning Path</span>
                    </a>
                @endif

                <a href="{{ route('notifications.index') }}" class="mobile-nav-item {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                    <i class="fas fa-bell"></i>
                    <span>Notifications</span>
                    @php $unreadCount = auth()->user()->notifications()->where('is_read', false)->count(); @endphp
                    @if($unreadCount > 0)
                        <span class="mobile-nav-badge">{{ $unreadCount }}</span>
                    @endif
                </a>

                <a href="{{ route('profile.edit') }}" class="mobile-nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>

                <a href="{{ route('contacts.index') }}" class="mobile-nav-item {{ request()->routeIs('contacts.*') ? 'active' : '' }}">
                    <i class="fas fa-address-book"></i>
                    <span>Contacts</span>
                </a>

                <div class="mobile-nav-divider"></div>

                <a href="{{ route('home') }}" class="mobile-nav-item">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('courses.public') }}" class="mobile-nav-item">
                    <i class="fas fa-book-open"></i>
                    <span>Browse Courses</span>
                </a>
                <a href="{{ route('about') }}" class="mobile-nav-item">
                    <i class="fas fa-info-circle"></i>
                    <span>About</span>
                </a>
                <a href="{{ route('contact') }}" class="mobile-nav-item">
                    <i class="fas fa-envelope"></i>
                    <span>Contact</span>
                </a>
            @else
                <a href="{{ route('home') }}" class="mobile-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </a>
                <a href="{{ route('courses.public') }}" class="mobile-nav-item {{ request()->routeIs('courses.public') ? 'active' : '' }}">
                    <i class="fas fa-book-open"></i>
                    <span>Courses</span>
                </a>
                <a href="{{ route('about') }}" class="mobile-nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                    <i class="fas fa-info-circle"></i>
                    <span>About</span>
                </a>
                <a href="{{ route('contact') }}" class="mobile-nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i>
                    <span>Contact</span>
                </a>

                <div class="mobile-nav-divider"></div>

                <a href="{{ route('login') }}" class="mobile-nav-item mobile-login-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Login</span>
                </a>
                <a href="{{ route('register') }}" class="mobile-nav-item mobile-signup-btn">
                    <i class="fas fa-user-plus"></i>
                    <span>Sign Up</span>
                </a>
            @endauth
        </div>

        @auth
            <div class="mobile-nav-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mobile-logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        @endauth
    </div>

    <div class="main-content">
        @yield('content')
    </div>

    @if(!auth()->check() || request()->routeIs('home') || request()->routeIs('courses.public') || request()->routeIs('about') || request()->routeIs('contact'))
        <footer class="main-footer">
            <div class="container footer-grid">
                <div class="footer-brand">
                    <a href="{{ route('home') }}" class="logo-container">
                        <div class="logo-icon">
                            <img src="{{ asset('images/logo-icon.jpeg') }}" alt="Shifra Logo">
                        </div>
                        <span class="logo-text">shifra</span>
                    </a>
                    <p>Empowering your learning journey with AI-driven course recommendations and personalized training
                        paths.</p>
                </div>
                <div class="footer-links">
                    <h4>QUICK LINKS</h4>
                    <ul>
                        <li><a href="{{ route('courses.public') }}">All Courses</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-social">
                    <h4>FOLLOW US</h4>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-google"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© {{ date('Y') }} Shifra Training Center. All rights reserved.</p>
            </div>
        </footer>
    @endif

    @auth
        @php
            $unreadNotifications = auth()->user()->notifications()->where('is_read', false)->count();
        @endphp
        
        @php
            // Define pages that should show bottom navigation
            $bottomNavPages = [
                'dashboard',
                'learning-path.index',
                'learning-path.show',
                'courses.my-courses',
                'notifications.index',
                'admin.dashboard',
                'profile.edit',
                'admin.menu',
                'admin.students.*',
                'admin.staff.*',
                'admin.courses.*',
                'admin.analytics.*',
                'instructor.dashboard',
                'instructor.courses',
                'contacts.index',
            ];

            $shouldShowBottomNav = false;
            foreach ($bottomNavPages as $pattern) {
                if (request()->routeIs($pattern)) {
                    $shouldShowBottomNav = true;
                    break;
                }
            }
        @endphp

        @if($shouldShowBottomNav)
            @if(auth()->user()->hasRole('admin'))
                <!-- Admin Bottom Nav - 7 items -->
                <nav class="bottom-nav">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        @if(request()->routeIs('admin.dashboard'))
                        <div class="active-line"></div>@endif
                        <i class="fas fa-chart-bar"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('admin.menu') }}" class="nav-item {{ request()->routeIs('admin.menu') ? 'active' : '' }}">
                        @if(request()->routeIs('admin.menu'))
                        <div class="active-line"></div>@endif
                        <i class="fas fa-bars"></i>
                        <span>Menu</span>
                    </a>
                    <a href="{{ route('admin.students.index') }}"
                        class="nav-item {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                        @if(request()->routeIs('admin.students.*'))
                        <div class="active-line"></div>@endif
                        <i class="fas fa-users"></i>
                        <span>Students</span>
                    </a>
                    <a href="{{ route('admin.staff.index') }}"
                        class="nav-item {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                        @if(request()->routeIs('admin.staff.*'))
                        <div class="active-line"></div>@endif
                        <i class="fas fa-users-cog"></i>
                        <span>Staff</span>
                    </a>
                    <a href="{{ route('admin.courses.index') }}"
                        class="nav-item {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                        @if(request()->routeIs('admin.courses.*'))
                        <div class="active-line"></div>@endif
                        <i class="fas fa-book"></i>
                        <span>Courses</span>
                    </a>
                    <a href="{{ route('admin.analytics.index') }}"
                        class="nav-item {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">
                        @if(request()->routeIs('admin.analytics.*'))
                        <div class="active-line"></div>@endif
                        <i class="fas fa-chart-line"></i>
                        <span>Analytics</span>
                    </a>
                    <a href="{{ route('notifications.index') }}"
                        class="nav-item {{ request()->routeIs('notifications.*') ? 'active' : '' }}" id="notification-item">
                        @if(request()->routeIs('notifications.*'))
                        <div class="active-line"></div>@endif
                        <i class="fas fa-bell"></i>
                        <span>Alerts</span>
                        @if($unreadNotifications > 0)
                            <span class="nav-badge" id="notification-badge">{{ $unreadNotifications }}</span>
                        @endif
                    </a>
                </nav>

            @elseif(auth()->user()->hasRole('instructor'))
                <!-- Instructor Bottom Nav - 5 items -->
                <nav class="bottom-nav">
                    <a href="{{ route('instructor.dashboard') }}"
                        class="nav-item {{ request()->routeIs('instructor.dashboard') ? 'active' : '' }}">
                        @if(request()->routeIs('instructor.dashboard'))
                        <div class="active-line"></div>@endif
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('instructor.courses') }}"
                        class="nav-item {{ request()->routeIs('instructor.courses') ? 'active' : '' }}">
                        @if(request()->routeIs('instructor.courses'))
                        <div class="active-line"></div>@endif
                        <i class="fas fa-book"></i>
                        <span>My Courses</span>
                    </a>
                    <a href="{{ route('notifications.index') }}"
                        class="nav-item {{ request()->routeIs('notifications.*') ? 'active' : '' }}" id="notification-item">
                        @if(request()->routeIs('notifications.*'))
                        <div class="active-line"></div>@endif
                        <i class="fas fa-bell"></i>
                        <span>Alerts</span>
                        @if($unreadNotifications > 0)
                            <span class="nav-badge" id="notification-badge">{{ $unreadNotifications }}</span>
                        @endif
                    </a>
                    <a href="{{ route('contacts.index') }}" class="nav-item {{ request()->routeIs('contacts.*') ? 'active' : '' }}">
                        @if(request()->routeIs('contacts.*'))
                        <div class="active-line"></div>@endif
                        <i class="fas fa-address-book"></i>
                        <span>Contacts</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        @if(request()->routeIs('profile.*'))
                        <div class="active-line"></div>@endif
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </nav>

            @else
                <!-- Student Bottom Nav - 5 items -->
                <nav class="bottom-nav">
                    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        @if(request()->routeIs('dashboard'))
                        <div class="active-line"></div>@endif
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('courses.my-courses') }}" class="nav-item {{ request()->routeIs('courses.my-courses') ? 'active' : '' }}">
                        @if(request()->routeIs('courses.my-courses'))
                        <div class="active-line"></div>@endif
                        <i class="fas fa-graduation-cap"></i>
                        <span>My Courses</span>
                    </a>
                    <a href="{{ route('learning-path.index') }}"
                        class="nav-item {{ request()->routeIs('learning-path.*') ? 'active' : '' }}">
                        @if(request()->routeIs('learning-path.*'))
                        <div class="active-line"></div>@endif
                        <i class="fas fa-route"></i>
                        <span>My Path</span>
                    </a>
                    <a href="{{ route('notifications.index') }}"
                        class="nav-item {{ request()->routeIs('notifications.*') ? 'active' : '' }}" id="notification-item">
                        @if(request()->routeIs('notifications.*'))
                        <div class="active-line"></div>@endif
                        <i class="fas fa-bell"></i>
                        <span>Alerts</span>
                        @if($unreadNotifications > 0)
                            <span class="nav-badge" id="notification-badge">{{ $unreadNotifications }}</span>
                        @endif
                    </a>
                    <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        @if(request()->routeIs('profile.*'))
                        <div class="active-line"></div>@endif
                        <i class="fas fa-user"></i>
                        <span>Profile</span>
                    </a>
                </nav>
            @endif

            <style>
                .main-content {
                    padding-bottom: 70px;
                }
            </style>
        @endif
    @endauth

    <!-- Notification Service -->
    <script src="{{ asset('js/notification-service.js') }}"></script>
    
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('fullcalendar/main.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);
        });

        // User dropdown toggle
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownBtn = document.querySelector('.user-dropdown-btn');
            const dropdownMenu = document.querySelector('#userDropdown');

            if (dropdownBtn && dropdownMenu) {
                dropdownBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdownMenu.classList.toggle('show');
                });

                document.addEventListener('click', function () {
                    dropdownMenu.classList.remove('show');
                });

                dropdownMenu.addEventListener('click', function (e) {
                    e.stopPropagation();
                });
            }
        });

        // Contacts dropdown toggle
        document.addEventListener('DOMContentLoaded', function () {
            const contactsBtn = document.getElementById('contactsBtn');
            const contactsMenu = document.getElementById('contactsMenu');

            if (contactsBtn && contactsMenu) {
                contactsBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    contactsMenu.classList.toggle('show');
                });

                document.addEventListener('click', function () {
                    contactsMenu.classList.remove('show');
                });

                contactsMenu.addEventListener('click', function (e) {
                    e.stopPropagation();
                });
            }
        });

        // Logout confirmation
        document.addEventListener('DOMContentLoaded', function () {
            const logoutButtons = document.querySelectorAll('.dropdown-item.logout');
            logoutButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You will be logged out of your account",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#2d3e50',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, logout!',
                        background: 'var(--white)',
                        color: 'var(--text-dark)',
                        customClass: {
                            popup: 'shadow-lg rounded-xl'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.closest('form').submit();
                        }
                    });
                });
            });
        });

        // Mobile menu functionality
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            const mobileNavMenu = document.getElementById('mobileNavMenu');
            const mobileNavClose = document.getElementById('mobileNavClose');

            // Create overlay
            const overlay = document.createElement('div');
            overlay.className = 'mobile-menu-overlay';
            document.body.appendChild(overlay);

            if (mobileMenuBtn && mobileNavMenu) {
                // Open menu
                mobileMenuBtn.addEventListener('click', function () {
                    mobileNavMenu.classList.add('show');
                    overlay.classList.add('show');
                    document.body.style.overflow = 'hidden'; // Prevent scrolling
                });

                // Close menu with close button
                if (mobileNavClose) {
                    mobileNavClose.addEventListener('click', closeMobileMenu);
                }

                // Close menu when clicking overlay
                overlay.addEventListener('click', closeMobileMenu);

                function closeMobileMenu() {
                    mobileNavMenu.classList.remove('show');
                    overlay.classList.remove('show');
                    document.body.style.overflow = ''; // Restore scrolling
                }

                // Close menu with ESC key
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && mobileNavMenu.classList.contains('show')) {
                        closeMobileMenu();
                    }
                });
            }
        });

        // Smooth scrolling for anchor links
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

        // Contact search
        const searchInput = document.getElementById('contactSearch');
        if (searchInput) {
            const contactsList = document.getElementById('contactsList');
            const contactItems = document.querySelectorAll('.contact-item');

            // Create no results message if it doesn't exist
            let noResultsMsg = document.getElementById('noSearchResults');
            if (!noResultsMsg && contactsList) {
                noResultsMsg = document.createElement('div');
                noResultsMsg.id = 'noSearchResults';
                noResultsMsg.className = 'no-search-results';
                noResultsMsg.innerHTML = '<i class="fas fa-user-slash"></i> No contacts found';
                contactsList.appendChild(noResultsMsg);
            }

            searchInput.addEventListener('keyup', function () {
                const filter = this.value.toLowerCase().trim();
                let visibleCount = 0;

                contactItems.forEach(item => {
                    const name = item.querySelector('.contact-name').textContent.toLowerCase();
                    if (filter === '' || name.includes(filter)) {
                        item.style.display = 'flex';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Show/hide no results message
                if (noResultsMsg) {
                    if (filter !== '' && visibleCount === 0) {
                        noResultsMsg.style.display = 'block';
                    } else {
                        noResultsMsg.style.display = 'none';
                    }
                }
            });

            // Clear search when dropdown closes
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.contacts-dropdown')) {
                    if (searchInput) {
                        searchInput.value = '';
                        contactItems.forEach(item => {
                            item.style.display = 'flex';
                        });
                        if (noResultsMsg) {
                            noResultsMsg.style.display = 'none';
                        }
                    }
                }
            });
        }

        // Use centralized notification service
        NotificationService.onCountChange(function(count) {
            const badge = document.getElementById('notification-badge');
            const notificationItem = document.getElementById('notification-item');

            if (!notificationItem) return;

            if (count > 0) {
                if (badge) {
                    badge.textContent = count;
                } else {
                    // Create badge if it doesn't exist
                    const newBadge = document.createElement('span');
                    newBadge.className = 'nav-badge';
                    newBadge.id = 'notification-badge';
                    newBadge.textContent = count;
                    notificationItem.appendChild(newBadge);
                }
            } else {
                // Remove badge if count is 0
                if (badge) {
                    badge.remove();
                }
            }
        });
    </script>
    @yield('scripts')
</body>

</html>