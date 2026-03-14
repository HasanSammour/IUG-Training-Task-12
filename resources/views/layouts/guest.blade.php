<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Shifra - Authentication')</title>
    
    <!-- Local Assets -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        :root {
            --primary-navy: #2d3e50;
            --secondary-blue: #3182ce;
            --text-dark: #333;
            --text-gray: #777;
            --bg-light: #f8fbff;
            --white: #ffffff;
            --border-color: #eee;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff !important;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        /* Loader Screen */
        #loaderScreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 10000;
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .loader-content {
            text-align: center;
        }

        .hexagon-logo img {
            width: 100px;
            margin-bottom: 30px;
        }

        .dots-loader {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
        }

        .dot {
            width: 10px;
            height: 10px;
            background-color: #2d3e50;
            border-radius: 50%;
            opacity: 0.3;
            animation: dotPulse 1.2s infinite ease-in-out;
        }

        .dot:nth-child(2) { animation-delay: 0.4s; }
        .dot:nth-child(3) { animation-delay: 0.8s; }

        @keyframes dotPulse {
            0%, 100% { opacity: 0.3; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.2); }
        }

        /* Main Auth Container */
        .auth-main-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            min-height: 100vh;
        }

        .auth-box {
            width: 100%;
            max-width: 420px;
            text-align: center;
            animation: fadeIn 0.5s ease;
        }

        .auth-logo-icon {
            margin-bottom: 20px;
        }

        .auth-logo-icon img {
            width: 70px;
            height: auto;
            margin: 0 auto;
            display: block;
        }

        .auth-heading {
            color: #2D3E50;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .auth-subheading {
            color: #718096;
            font-size: 15px;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        /* Auth Form */
        .auth-form {
            text-align: left;
        }

        .input-field {
            margin-bottom: 18px;
        }

        .input-field label {
            display: block;
            color: #2D3E50;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 6px;
        }

        .input-field input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            background-color: #ffffff;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        .input-field input:focus {
            border-color: #2D3E50;
            outline: none;
            box-shadow: 0 0 0 2px rgba(45, 62, 80, 0.1);
        }

        .input-row {
            display: flex;
            gap: 15px;
            width: 100%;
        }

        .input-row .input-field {
            flex: 1;
        }

        /* Terms Checkbox */
        .terms-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #718096;
            text-align: left;
        }

        .terms-check input {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        /* Social Auth */
        .social-auth {
            margin-top: 25px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .social-btn {
            width: 100%;
            padding: 12px;
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 14px;
            color: #4A5568;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            background: #f7fafc;
            border-color: #cbd5e0;
        }

        .social-btn i {
            font-size: 16px;
        }

        .social-btn.google i {
            color: #DB4437;
        }

        .social-btn.facebook i {
            color: #4267B2;
        }

        /* Divider */
        .divider {
            margin: 30px 0;
            position: relative;
            text-align: center;
        }

        .divider::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background-color: #e2e8f0;
            z-index: 1;
        }

        .divider span {
            background-color: white;
            padding: 0 15px;
            color: #a0aec0;
            font-size: 13px;
            position: relative;
            z-index: 2;
        }

        /* Social Buttons Row */
        .social-auth-row {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .social-btn-small {
            flex: 1;
            padding: 10px;
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 13px;
            color: #4A5568;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .social-btn-small:hover {
            background: #f7fafc;
        }

        /* Auth Links */
        .auth-links {
            margin-top: 20px;
            text-align: center;
        }

        .auth-links a {
            color: #2D3E50;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }

        .auth-links p {
            color: #718096;
            font-size: 14px;
            margin-top: 10px;
        }

        /* Back Link */
        .back-link {
            text-align: left;
            margin-bottom: 20px;
        }

        .back-link a {
            color: #718096;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
        }

        .back-link a:hover {
            color: #2D3E50;
        }

        /* Primary Button */
        .btn-navy {
            width: 100%;
            padding: 14px;
            background-color: #2D3E50;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .btn-navy:hover {
            background-color: #1a252f;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(45, 62, 80, 0.15);
        }

        /* Form Options */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .remember-me {
            color: #718096;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }

        .forgot-pass {
            color: #718096;
            text-decoration: none;
        }

        .forgot-pass:hover {
            color: #2D3E50;
            text-decoration: underline;
        }

        /* Error Messages */
        .text-danger {
            color: #e53e3e;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        /* Flash Messages */
        .flash-messages {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 10px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
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
            background: #10b981;
            color: white;
        }

        .alert-error {
            background: #ef4444;
            color: white;
        }

        .alert-warning {
            background: #f59e0b;
            color: white;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    
    @yield('styles')
</head>
<body class="auth-page-bg">

    <!-- Flash Messages -->
    <div class="flash-messages">
        @if(session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
        @endif
    </div>

    <!-- Loader Screen -->
    <div id="loaderScreen">
        <div class="loader-content">
            <div class="hexagon-logo">
                <img src="{{ asset('images/logo-icon.jpeg') }}" alt="Shifra Logo">
            </div>
            <div style="width: 200px; height: 6px; background: #e2e8f0; border-radius: 10px; overflow: hidden; position: relative;">
                <div id="loaderBar" style="width: 0%; height: 100%; background: #2D3E50; transition: width 0.3s;"></div>
            </div>
            <p style="margin-top: 10px; color: #2D3E50; font-family: sans-serif;">Processing...</p>
        </div>
    </div>

    <!-- Main Auth Content -->
    <div class="auth-main-container">
        @yield('content')
    </div>

    <!-- Local Scripts -->
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
    
    <!-- Auth Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-hide flash messages
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateX(100%)';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);

            // Initialize auth section switching
            initializeAuthPages();
        });

        console.log('Auth debugging enabled');
        
        // Auth form submission with loader
        async function handleAuthFormSubmit(formId, event) {
            event.preventDefault();
            
            console.log('Form submit triggered for:', formId);
            
            const form = document.getElementById(formId);
            if (!form) {
                console.error('Form not found:', formId);
                return false;
            }
            
            const loader = document.getElementById('loaderScreen');
            const bar = document.getElementById('loaderBar');
            
            if (loader && bar) {
                loader.style.display = 'flex';
                let progress = 0;
                
                const interval = setInterval(() => {
                    progress += 10;
                    bar.style.width = progress + '%';
                    
                    if (progress >= 100) {
                        clearInterval(interval);
                        
                        console.log('Submitting form to:', form.action);
                        
                        fetch(form.action, {
                            method: 'POST',
                            body: new FormData(form),
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => {
                            console.log('Response status:', response.status);
                            
                            const contentType = response.headers.get('content-type');
                            
                            if (contentType && contentType.includes('application/json')) {
                                return response.json();
                            } else {
                                return response.text().then(text => {
                                    console.error('Non-JSON response:', text.substring(0, 200));
                                    throw new Error('Server returned non-JSON response');
                                });
                            }
                        })
                        .then(data => {
                            console.log('JSON response data:', data);
                            loader.style.display = 'none';
                            
                            if (data && data.redirect) {
                                console.log('Redirect URL:', data.redirect);
                                window.location.href = data.redirect;
                            } else if (data && data.errors) {
                                console.log('Validation errors:', data.errors);
                                alert(Object.values(data.errors)[0][0]);
                            } else {
                                console.error('No redirect in response');
                                alert('Login failed. Please try again.');
                            }
                        })
                        .catch(error => {
                            console.error('Fetch error:', error);
                            loader.style.display = 'none';
                            
                            // Fallback to normal form submission
                            console.log('Falling back to normal form submission');
                            form.submit();
                        });
                    }
                }, 80);
            } else {
                console.log('No loader found, submitting normally');
                form.submit();
            }
            
            return false;
        }

        // Initialize section switching for login page
        function initializeAuthPages() {
            const toSignup = document.getElementById('toSignup');
            const toLogin = document.getElementById('toLogin');
            const toForgot = document.getElementById('toForgot');
            const backToLoginFromForgot = document.getElementById('backToLoginFromForgot');

            function showSection(sectionToShow) {
                const sections = ['loginSection', 'signupSection', 'forgotSection'];
                sections.forEach(sectionId => {
                    const section = document.getElementById(sectionId);
                    if (section) {
                        section.style.display = 'none';
                    }
                });

                if (sectionToShow) {
                    sectionToShow.style.display = 'block';
                }
            }

            if (toSignup) {
                const signupSection = document.getElementById('signupSection');
                if (signupSection) {
                    toSignup.onclick = (e) => {
                        e.preventDefault();
                        showSection(signupSection);
                    };
                }
            }

            if (toLogin) {
                const loginSection = document.getElementById('loginSection');
                if (loginSection) {
                    toLogin.onclick = (e) => {
                        e.preventDefault();
                        showSection(loginSection);
                    };
                }
            }

            if (toForgot) {
                const forgotSection = document.getElementById('forgotSection');
                if (forgotSection) {
                    toForgot.onclick = (e) => {
                        e.preventDefault();
                        showSection(forgotSection);
                    };
                }
            }

            if (backToLoginFromForgot) {
                const loginSection = document.getElementById('loginSection');
                if (loginSection) {
                    backToLoginFromForgot.onclick = (e) => {
                        e.preventDefault();
                        showSection(loginSection);
                    };
                }
            }
        }
    </script>
    
    @yield('scripts')
</body>
</html>