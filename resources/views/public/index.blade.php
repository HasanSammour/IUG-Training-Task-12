@extends('layouts.app')

@section('title', 'Shifra - Training Center')
@section('body-class', 'public-page')

@section('styles')
    <style>
        :root {
            --primary-navy: #2d3e50;
            --secondary-blue: #3182ce;
            --success-green: #10b981;
            --warning-orange: #f59e0b;
            --danger-red: #ef4444;
            --text-dark: #1e293b;
            --text-gray: #64748b;
            --text-light: #94a3b8;
            --bg-light: #f8fbff;
            --white: #ffffff;
            --border-color: #e2e8f0;
        }

        /* Hero Section */
        .hero-banner {
            background-image: linear-gradient(rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.7)),
                url('{{ asset("images/IMG_5843.jpeg") }}');
            background-size: cover !important;
            background-position: center center !important;
            background-repeat: no-repeat !important;
            min-height: 450px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border: none !important;
            width: 100%;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .hero-text {
            background: transparent !important;
            text-align: center !important;
            max-width: 600px;
            margin: 0 auto;
        }

        .hero-text h1 {
            font-size: 42px;
            color: #2D3E50;
            margin-bottom: 20px;
            font-weight: 700;
            line-height: 1.2;
        }

        .hero-text p {
            font-size: 16px;
            color: #64748b;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .btn-get-started {
            background: #2D3E50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-get-started:hover {
            background: #1a252f;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Button variations */
        .btn-admin {
            background: linear-gradient(135deg, #1e40af, #3730a3);
        }

        .btn-admin:hover {
            background: linear-gradient(135deg, #3730a3, #1e40af);
        }

        .btn-instructor {
            background: linear-gradient(135deg, #065f46, #047857);
        }

        .btn-instructor:hover {
            background: linear-gradient(135deg, #047857, #065f46);
        }

        .btn-student {
            background: linear-gradient(135deg, #7c3aed, #6d28d9);
        }

        .btn-student:hover {
            background: linear-gradient(135deg, #6d28d9, #7c3aed);
        }

        /* Section Styling */
        .section-padding {
            padding: 80px 0;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-header-text {
            text-align: center;
            margin-bottom: 40px;
            padding: 0 20px;
        }

        .section-title {
            font-size: 32px;
            color: #2D3E50;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .section-subtitle {
            color: #718096;
            font-size: 16px;
        }

        /* Stats Section - Role Based */
        .stats-section {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin: 40px auto;
            padding: 0 20px;
            max-width: 1400px;
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
            border-radius: 16px;
            padding: 25px;
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-color: var(--primary-navy);
        }

        .stat-card.admin {
            border-top: 4px solid #1e40af;
        }

        .stat-card.instructor {
            border-top: 4px solid #065f46;
        }

        .stat-card.student {
            border-top: 4px solid #7c3aed;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 20px;
        }

        .stat-card.admin .stat-icon {
            background: rgba(30, 64, 175, 0.1);
            color: #1e40af;
        }

        .stat-card.instructor .stat-icon {
            background: rgba(6, 95, 70, 0.1);
            color: #065f46;
        }

        .stat-card.student .stat-icon {
            background: rgba(124, 58, 237, 0.1);
            color: #7c3aed;
        }

        .stat-number {
            display: block;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 13px;
            color: var(--text-gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Quick Access Section */
        .quick-access-section {
            background: #f8fafc;
            border-radius: 20px;
            padding: 40px;
            margin: 40px auto;
            width: 100%;
            max-width: 1400px;
        }

        @media (max-width: 768px) {
            .quick-access-section {
                padding: 20px;
                margin: 20px;
                border-radius: 15px;
            }
        }

        .quick-access-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-top: 40px;
        }

        @media (max-width: 1024px) {
            .quick-access-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .quick-access-grid {
                grid-template-columns: 1fr;
            }
        }

        .qa-item {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            border: 1px solid #f1f5f9;
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }

        .qa-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            border-color: var(--primary-navy);
        }

        .qa-item.admin {
            border-top: 4px solid #1e40af;
        }

        .qa-item.instructor {
            border-top: 4px solid #065f46;
        }

        .qa-item.student {
            border-top: 4px solid #7c3aed;
        }

        .qa-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .qa-item.admin .qa-icon {
            background: rgba(30, 64, 175, 0.1);
            color: #1e40af;
        }

        .qa-item.instructor .qa-icon {
            background: rgba(6, 95, 70, 0.1);
            color: #065f46;
        }

        .qa-item.student .qa-icon {
            background: rgba(124, 58, 237, 0.1);
            color: #7c3aed;
        }

        .qa-item h3 {
            font-size: 18px;
            color: #2D3E50;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .qa-item p {
            font-size: 14px;
            color: #718096;
            line-height: 1.5;
            margin-bottom: 0;
        }

        /* Recent Activity Card */
        .recent-activity-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            border: 1px solid var(--border-color);
            margin: 40px auto;
            max-width: 1400px;
        }

        .activity-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            color: var(--primary-navy);
        }

        .activity-header i {
            color: var(--secondary-blue);
        }

        .activity-list {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        @media (max-width: 992px) {
            .activity-list {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .activity-list {
                grid-template-columns: 1fr;
            }
        }

        .activity-item {
            padding: 15px;
            background: #f8fafc;
            border-radius: 12px;
            border-left: 3px solid var(--secondary-blue);
        }

        .activity-label {
            font-size: 12px;
            color: var(--text-gray);
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .activity-value {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .activity-value i {
            color: var(--secondary-blue);
        }

        /* Courses Grid */
        .courses-grid-home {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 30px;
            padding: 0 20px;
        }

        .course-card-wide {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .course-card-wide:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .course-card-wide img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-body {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-body h3 {
            font-size: 18px;
            color: #2D3E50;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .card-body p {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 20px;
            line-height: 1.5;
            flex: 1;
        }

        .card-footer-btns {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }

        .btn-outline {
            flex: 1;
            padding: 10px;
            background: #ffffff;
            border: 1.5px solid #2D3E50;
            color: #2D3E50;
            border-radius: 6px;
            text-decoration: none;
            text-align: center;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
        }

        .btn-outline:hover {
            background: #2D3E50;
            color: white;
        }

        .btn-fill {
            flex: 1;
            padding: 10px;
            background: #2D3E50;
            border: none;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            text-align: center;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
        }

        .btn-fill:hover {
            background: #1a252f;
        }

        .btn-fill.admin:hover {
            background: #1e40af;
        }

        .btn-fill.instructor:hover {
            background: #065f46;
        }

        .btn-fill.student:hover {
            background: #7c3aed;
        }

        /* Upcoming Events */
        .upcoming-events {
            margin-top: 20px;
        }

        .event-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px;
            background: #f8fafc;
            border-radius: 10px;
            margin-bottom: 10px;
            border-left: 3px solid var(--secondary-blue);
        }

        .event-time {
            font-size: 13px;
            font-weight: 600;
            color: var(--secondary-blue);
        }

        .event-title {
            font-size: 14px;
            color: var(--text-dark);
        }
    </style>
@endsection

@section('content')
    <section class="hero-banner">
        <div class="hero-grid">
            <div class="hero-text">
                <h1>Learning Path AI</h1>
                <p>Discover personalized training courses powered by artificial intelligence. Build your skills with
                    expert-led sessions tailored to your career goals.</p>

                @auth
                    @can('access_admin_dashboard')
                        <a href="{{ route('admin.dashboard') }}" class="btn-get-started btn-admin">Go to Admin Panel</a>
                    @elsecan('access_instructor_dashboard')
                        <a href="{{ route('instructor.dashboard') }}" class="btn-get-started btn-instructor">Go to Instructor Dashboard</a>
                    @elsecan('access_student_dashboard')
                        <a href="{{ route('dashboard') }}" class="btn-get-started btn-student">Go to Student Dashboard</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn-get-started">Go to Dashboard</a>
                    @endcan
                @else
                    <a href="{{ route('register') }}" class="btn-get-started">Get Started</a>
                @endauth
            </div>
        </div>
    </section>

    <div class="container-center">
        @auth
            <!-- Stats Section - Role Based -->
            <section class="stats-section">
                @can('access_admin_dashboard')
                    <a href="{{ route('admin.courses.index') }}" class="stat-card admin">
                        <div class="stat-icon"><i class="fas fa-book-open"></i></div>
                        <span class="stat-number">{{ $userData['total_courses'] ?? 0 }}</span>
                        <span class="stat-label">Total Courses</span>
                    </a>
                    <a href="{{ route('admin.courses.index') }}?status=active" class="stat-card admin">
                        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                        <span class="stat-number">{{ $userData['active_courses'] ?? 0 }}</span>
                        <span class="stat-label">Active Courses</span>
                    </a>
                    <a href="{{ route('admin.students.index') }}" class="stat-card admin">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <span class="stat-number">{{ $userData['total_students'] ?? 0 }}</span>
                        <span class="stat-label">Students</span>
                    </a>
                    <a href="{{ route('admin.staff.index') }}" class="stat-card admin">
                        <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <span class="stat-number">{{ $userData['total_instructors'] ?? 0 }}</span>
                        <span class="stat-label">Instructors</span>
                    </a>
                @endcan

                @can('access_instructor_dashboard')
                    <a href="{{ route('instructor.courses') }}" class="stat-card instructor">
                        <div class="stat-icon"><i class="fas fa-book-open"></i></div>
                        <span class="stat-number">{{ $userData['my_courses'] ?? 0 }}</span>
                        <span class="stat-label">My Courses</span>
                    </a>
                    <a href="{{ route('instructor.courses') }}?status=active" class="stat-card instructor">
                        <div class="stat-icon"><i class="fas fa-play-circle"></i></div>
                        <span class="stat-number">{{ $userData['active_courses'] ?? 0 }}</span>
                        <span class="stat-label">Active</span>
                    </a>
                    <a href="{{ route('instructor.courses') }}" class="stat-card instructor">
                        <div class="stat-icon"><i class="fas fa-users"></i></div>
                        <span class="stat-number">{{ $userData['total_students'] ?? 0 }}</span>
                        <span class="stat-label">Students</span>
                    </a>
                    <a href="{{ route('instructor.courses') }}" class="stat-card instructor">
                        <div class="stat-icon"><i class="fas fa-tasks"></i></div>
                        <span class="stat-number">{{ $userData['pending_assignments'] ?? 0 }}</span>
                        <span class="stat-label">To Grade</span>
                    </a>
                @endcan

                @can('access_student_dashboard')
                    <a href="{{ route('courses.my-courses') }}" class="stat-card student">
                        <div class="stat-icon"><i class="fas fa-book-open"></i></div>
                        <span class="stat-number">{{ $userData['enrolled_courses'] ?? 0 }}</span>
                        <span class="stat-label">Enrolled</span>
                    </a>
                    <a href="{{ route('courses.my-courses') }}?status=completed" class="stat-card student">
                        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
                        <span class="stat-number">{{ $userData['completed_courses'] ?? 0 }}</span>
                        <span class="stat-label">Completed</span>
                    </a>
                    <a href="{{ route('courses.my-courses') }}" class="stat-card student">
                        <div class="stat-icon"><i class="fas fa-clock"></i></div>
                        <span class="stat-number">{{ $userData['learning_hours'] ?? 0 }}h</span>
                        <span class="stat-label">Hours</span>
                    </a>
                    <a href="{{ route('learning-path.index') }}" class="stat-card student">
                        <div class="stat-icon"><i class="fas fa-fire"></i></div>
                        <span class="stat-number">{{ $userData['current_streak'] ?? 0 }}</span>
                        <span class="stat-label">Day Streak</span>
                    </a>
                @endcan
            </section>

            <!-- Quick Access Section - 4 items per role -->
            <section class="quick-access-section">
                <h2 class="section-title text-center">Quick Access</h2>
                <div class="quick-access-grid">
                    @can('access_admin_dashboard')
                        <a href="{{ route('admin.dashboard') }}" class="qa-item admin">
                            <div class="qa-icon"><i class="fas fa-chart-line"></i></div>
                            <h3>Dashboard</h3>
                            <p>System overview</p>
                        </a>
                        <a href="{{ route('admin.courses.create') }}" class="qa-item admin">
                            <div class="qa-icon"><i class="fas fa-plus-circle"></i></div>
                            <h3>New Course</h3>
                            <p>Create course</p>
                        </a>
                        <a href="{{ route('admin.students.index') }}" class="qa-item admin">
                            <div class="qa-icon"><i class="fas fa-users"></i></div>
                            <h3>Students</h3>
                            <p>Manage users</p>
                        </a>
                        <a href="{{ route('admin.analytics.index') }}" class="qa-item admin">
                            <div class="qa-icon"><i class="fas fa-chart-pie"></i></div>
                            <h3>Analytics</h3>
                            <p>View reports</p>
                        </a>
                    @endcan

                    @can('access_instructor_dashboard')
                        <a href="{{ route('instructor.dashboard') }}" class="qa-item instructor">
                            <div class="qa-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                            <h3>Dashboard</h3>
                            <p>Teaching overview</p>
                        </a>
                        <a href="{{ route('instructor.courses') }}" class="qa-item instructor">
                            <div class="qa-icon"><i class="fas fa-book"></i></div>
                            <h3>My Courses</h3>
                            <p>Manage courses</p>
                        </a>
                        <a href="{{ route('instructor.courses.create') }}" class="qa-item instructor">
                            <div class="qa-icon"><i class="fas fa-plus-circle"></i></div>
                            <h3>Create Course</h3>
                            <p>Add new course</p>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="qa-item instructor">
                            <div class="qa-icon"><i class="fas fa-user-cog"></i></div>
                            <h3>Profile</h3>
                            <p>Account settings</p>
                        </a>
                    @endcan

                    @can('access_student_dashboard')
                        <a href="{{ route('dashboard') }}" class="qa-item student">
                            <div class="qa-icon"><i class="fas fa-home"></i></div>
                            <h3>Dashboard</h3>
                            <p>Learning overview</p>
                        </a>
                        <a href="{{ route('courses.public') }}" class="qa-item student">
                            <div class="qa-icon"><i class="fas fa-search"></i></div>
                            <h3>Browse</h3>
                            <p>Find courses</p>
                        </a>
                        <a href="{{ route('learning-path.index') }}" class="qa-item student">
                            <div class="qa-icon"><i class="fas fa-route"></i></div>
                            <h3>My Path</h3>
                            <p>Track progress</p>
                        </a>
                        <a href="{{ route('notifications.index') }}" class="qa-item student">
                            <div class="qa-icon"><i class="fas fa-bell"></i></div>
                            <h3>Alerts</h3>
                            <p>Notifications</p>
                        </a>
                    @endcan
                </div>
            </section>

            <!-- Recent Activity Card -->
            <div class="recent-activity-card">
                <div class="activity-header">
                    <i class="fas fa-history fa-lg"></i>
                    <h3>Recent Activity</h3>
                </div>
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-label">Last Login</div>
                        <div class="activity-value">
                            <i class="fas fa-sign-in-alt"></i>
                            {{ $recentActivity['last_login'] ?? 'Today' }}
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-label">Messages</div>
                        <div class="activity-value">
                            <i class="fas fa-envelope"></i>
                            {{ $recentActivity['unread_messages'] ?? 0 }} unread
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-label">Upcoming</div>
                        <div class="activity-value">
                            <i class="fas fa-calendar-alt"></i>
                            {{ $recentActivity['upcoming_events'] ?? 'No events' }}
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-label">Tasks</div>
                        <div class="activity-value">
                            <i class="fas fa-tasks"></i>
                            {{ $recentActivity['pending_tasks'] ?? 0 }} pending
                        </div>
                    </div>
                </div>

                @if(isset($upcomingEvents) && $upcomingEvents->count() > 0)
                    <div class="upcoming-events">
                        <h4 style="margin: 20px 0 10px; color: var(--primary-navy);">Upcoming Sessions</h4>
                        @foreach($upcomingEvents as $event)
                            <div class="event-item">
                                <span class="event-time">{{ \Carbon\Carbon::parse($event->start_time)->format('M d, h:i A') }}</span>
                                <span class="event-title">{{ $event->title }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endauth

        <!-- Featured Courses Section (Visible to All) -->
        <section class="section-padding">
            <div class="section-header-text">
                <h2 class="section-title">
                    @auth
                        @canany(['access_admin_dashboard', 'access_instructor_dashboard'])
                            Featured Platform Courses
                        @else
                            Recommended For You
                        @endcan
                    @else
                        Featured Courses
                    @endauth
                </h2>
                <p class="section-subtitle">
                    @auth
                        @canany(['access_admin_dashboard', 'access_instructor_dashboard'])
                            Popular courses in the training center
                        @else
                            Courses recommended based on your interests
                        @endcan
                    @else
                        Explore our most popular training programs
                    @endauth
                </p>
            </div>

            <div class="courses-grid-home">
                @forelse($featuredCourses as $course)
                    <div class="course-card-wide">
                        <img src="{{ $course->image_url }}" alt="{{ $course->title }}">
                        <div class="card-body">
                            <h3>{{ $course->title }}</h3>
                            <p>{{ $course->short_description }}</p>
                            <div class="card-footer-btns">
                                <a href="{{ route('courses.show', $course->slug) }}" class="btn-outline">Details</a>
                                
                                @auth
                                    @can('access_admin_dashboard')
                                        <a href="{{ route('admin.courses.edit', $course) }}" class="btn-fill btn-admin">Manage</a>
                                    @elsecan('access_instructor_dashboard')
                                        <a href="{{ route('courses.show', $course->slug) }}" class="btn-fill btn-instructor">View</a>
                                    @else
                                        <a href="{{ route('courses.registration', $course->slug) }}" class="btn-fill btn-student">Enroll</a>
                                    @endcan
                                @else
                                    <a href="{{ route('login') }}" class="btn-fill">Login to Enroll</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No featured courses available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Quick Access for Guests -->
        @guest
            <section class="quick-access-section">
                <h2 class="section-title text-center">Get Started</h2>
                <div class="quick-access-grid">
                    <a href="{{ route('courses.public') }}" class="qa-item">
                        <div class="qa-icon"><i class="fas fa-th-large"></i></div>
                        <h3>Browse Courses</h3>
                        <p>Explore training catalog</p>
                    </a>
                    <a href="{{ route('register') }}" class="qa-item">
                        <div class="qa-icon"><i class="fas fa-user-plus"></i></div>
                        <h3>Create Account</h3>
                        <p>Start learning journey</p>
                    </a>
                    <a href="{{ route('login') }}" class="qa-item">
                        <div class="qa-icon"><i class="fas fa-sign-in-alt"></i></div>
                        <h3>Login</h3>
                        <p>Access dashboard</p>
                    </a>
                    <a href="{{ route('about') }}" class="qa-item">
                        <div class="qa-icon"><i class="fas fa-info-circle"></i></div>
                        <h3>About Us</h3>
                        <p>Learn about us</p>
                    </a>
                </div>
            </section>

            <!-- Public Stats -->
            <section class="stats-section">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-book-open"></i></div>
                    <span class="stat-number">{{ $stats['total_courses'] ?? 0 }}</span>
                    <span class="stat-label">Courses</span>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <span class="stat-number">{{ $stats['total_students'] ?? 0 }}</span>
                    <span class="stat-label">Students</span>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <span class="stat-number">{{ $stats['instructors'] ?? 0 }}</span>
                    <span class="stat-label">Instructors</span>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
                    <span class="stat-number">{{ $stats['success_rate'] ?? 95 }}%</span>
                    <span class="stat-label">Success Rate</span>
                </div>
            </section>
        @endguest
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Card hover effects
            document.querySelectorAll('.course-card-wide, .stat-card, .qa-item').forEach(card => {
                card.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-5px)';
                });
                card.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
@endsection