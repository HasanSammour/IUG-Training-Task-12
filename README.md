<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About The Project
# Shifra Training Center - Learning Management System (LMS) *last training task*

## 📋 Project Overview

Shifra Training Center is a comprehensive Learning Management System (LMS) developed as a university training project. It demonstrates a complete web application with role-based access control, course management, live session scheduling, assignment handling, and AI-powered learning paths.

**Project Type:** University Training Project  
**Year:** 2025/2026  
**Developer:** Hasan Sammour - Computer Engineering Student, Islamic University of Gaza (IUG)

---

## 🎯 Key Features

### 👥 Multi-Role System
- **Admin:** Full system control, user management, analytics, course approval
- **Instructor:** Course creation, student management, grading, live sessions
- **Student:** Course enrollment, learning paths, assignments, certificates

### 📚 Course Management
- Create and manage courses with rich content
- Categories and tags organization
- Pricing and discount management
- Course image upload and preview

### 🎥 Live Sessions Integration
- Schedule live sessions with Google Meet/Zoom links
- Real-time attendance tracking
- Session recording management
- Calendar integration with drag-and-drop scheduling

### 📝 Assignment System
- Create assignments with due dates and points
- File upload support (PDF, DOC, DOCX, ZIP)
- Grade submissions with feedback
- Late submission detection

### 🤖 AI-Powered Learning Paths
- Personalized course recommendations
- Progress tracking with visual timeline
- Milestone notifications
- Adaptive learning journey

### 💬 Messaging System
- Real-time messaging between users
- WhatsApp-style conversation interface
- Read receipts and notifications
- Course context in messages

### 📊 Analytics Dashboard
- Revenue tracking and charts
- Enrollment statistics
- Peak hours analysis
- Student progress reports
- PDF report generation

---

## 🛠️ Technology Stack

### Backend
| Technology | Purpose |
|------------|---------|
| **PHP 8.2+** | Core programming language |
| **Laravel 12** | PHP Framework |
| **MySQL** | Database |
| **Spatie Permission** | Role & Permission management |
| **Laravel Sanctum** | API authentication *This is only for learning it's not have a big usage in the app* |
| **Barryvdh/DomPDF** | PDF generation |

### Frontend
| Technology | Purpose |
|------------|---------|
| **HTML5/CSS3** | Structure and styling |
| **Bootstrap 5** | Responsive design |
| **JavaScript (ES6+)** | Client-side logic |
| **AJAX** | Asynchronous requests |
| **Font Awesome 6** | Icons |
| **SweetAlert2** | Beautiful modals |
| **Chart.js** | Analytics charts |
| **FullCalendar** | Calendar integration |

### Development Tools
| Tool | Purpose |
|------|---------|
| **VS Code** | Code editor |
| **Git & GitHub** | Version control |
| **Chrome DevTools** | Debugging |
| **XAMPP** | Local development environment |

---

## 📁 Project Structure

```
shifra-training/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       └── ResetUserOnboarding.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AnalyticsController.php
│   │   │   │   ├── CategoriesController.php
│   │   │   │   ├── CourseController.php
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── EnrollmentController.php
│   │   │   │   ├── StaffController.php
│   │   │   │   └── StudentController.php
│   │   │   ├── Auth/
│   │   │   │   ├── AuthenticatedSessionController.php
│   │   │   │   └── RegisteredUserController.php
│   │   │   ├── Instructor/
│   │   │   │   ├── BulkActionController.php
│   │   │   │   ├── CourseAssignmentController.php
│   │   │   │   ├── CourseMaterialController.php
│   │   │   │   ├── CourseSessionController.php
│   │   │   │   └── DashboardController.php
│   │   │   ├── Public/
│   │   │   │   ├── AboutController.php
│   │   │   │   ├── ContactController.php
│   │   │   │   ├── CourseController.php
│   │   │   │   └── HomeController.php
│   │   │   └── User/
│   │   │       ├── AssignmentController.php
│   │   │       ├── ContactsController.php
│   │   │       ├── CourseMaterialController.php
│   │   │       ├── CourseProgressController.php
│   │   │       ├── DashboardController.php
│   │   │       ├── LearningPathController.php
│   │   │       ├── MessageController.php
│   │   │       ├── NotificationController.php
│   │   │       ├── ProfileController.php
│   │   │       └── SessionController.php
│   │   ├── Middleware/
│   │   │   ├── EnsureEssentialData.php
│   │   │   └── RoleMiddleware.php
│   │   └── Requests/ ..
│   ├── Models/
│   │   ├── AssignmentSubmission.php
│   │   ├── Category.php
│   │   ├── ContactMessage.php
│   │   ├── Course.php
│   │   ├── CourseAssignment.php
│   │   ├── CourseMaterial.php
│   │   ├── CourseReview.php
│   │   ├── CourseSession.php
│   │   ├── Enrollment.php
│   │   ├── LearningPath.php
│   │   ├── LearningPathItem.php
│   │   ├── Message.php
│   │   ├── Notification.php
│   │   ├── SessionAttendance.php
│   │   ├── StudentNote.php
│   │   ├── User.php
│   │   └── Wishlist.php
│   ├── Policies/
│   │   └── CoursePolicy.php
│   ├── Providers/
│   │   ├── AppServiceProvider.php
│   │   └── EssentialDataServiceProvider.php
│   └── Traits/
│       └── ChecksCourseStatus.php
├── bootstrap/
│   ├── app.php
│   └── cache/ ... 
├── database/
│   ├── migrations/
│   │   ├── xxxx_xx_xx_xxxxxx_create_users_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_cache_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_jobs_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_permission_tables.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_categories_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_courses_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_enrollments_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_learning_paths_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_learning_path_items_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_notifications_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_course_reviews_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_wishlists_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_contact_messages_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_personal_access_tokens_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_student_notes_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_messages_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_modify_type_column_in_notifications_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_course_sessions_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_session_attendance_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_course_assignments_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_assignment_submissions_table.php
│   │   ├── xxxx_xx_xx_xxxxxx_create_course_materials_table.php
│   │   └── xxxx_xx_xx_xxxxxx_add_onboarding_fields_to_users_table.php
│   └── seeders/
│       ├── .. seeders for all tables ..
│       ├── DatabaseSeeder.php
│       └── EssentialDataSeeder.php
├── public/
│   ├── bootstrap/          # Locally Downloaded bootstrap
│   ├── chartjs/            # Locally Downloaded chart js
│   ├── font-awesome/       # Locally Downloaded font awesome
│   ├── fullcalendar/       # Locally Downloaded full calender
│   ├── ssweetalert2/       # Locally Downloaded sweet alert 2    
│   ├── css/                # asset css styles 
│   ├── js/                 # asset js styles 
│   └── images/             # asset image
├── resources/
│   └── views/
│       ├── admin/          # Admin Views    
│       ├── auth/           # Breeze auth 
│       ├── components/     # Breeze auth 
│       ├── errors/         # errors Pages
│       ├── instructor/     # instructor Views
│       ├── layouts/        # app layout
│       ├── profile/        # Users Profile Views 
│       ├── public/         # Public Views 
│       └── user/           # Student Views and Messaging/Notification System Views
├── routes/
    ├── web.php
    └── auth.php
```

---

## 🗄️ Database Schema

### Core Tables
| Table | Description |
|-------|-------------|
| `users` | System users (students, instructors, admins) |
| `categories` | Course categories |
| `courses` | Course information |
| `enrollments` | Student course enrollments |
| `learning_paths` | AI-generated learning paths |
| `learning_path_items` | Courses within learning paths |

### Content Tables
| Table | Description |
|-------|-------------|
| `course_sessions` | Live session scheduling |
| `session_attendance` | Student attendance tracking |
| `course_assignments` | Assignment creation |
| `assignment_submissions` | Student submissions and grades |
| `course_materials` | Course resources and files |
| `course_reviews` | Student reviews and ratings |

### Communication Tables
| Table | Description |
|-------|-------------|
| `messages` | Private messaging between users |
| `notifications` | System notifications |
| `contact_messages` | Public contact form submissions |
| `student_notes` | Admin notes on students |

### User Tables
| Table | Description |
|-------|-------------|
| `wishlists` | Student saved courses in their wishlist |
| `personal_access_tokens` | API tokens (Sanctum) *not used* |
| `permissions` | Spatie permission tables |

---

## 🚀 Installation Guide

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL 5.7 or higher
- Node.js & NPM (optional, for frontend assets)
- XAMPP/WAMP/MAMP for local development

### Step 1: Clone the Repository
```bash
git clone https://github.com/HasanSammour/IUG-Training-Task-12.git
cd IUG-Training-Task-12
```

### Step 2: Install Dependencies
```bash
composer install
npm install
```

### Step 3: Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

Configure your database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task12
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Database Setup
```bash
php artisan migrate
php artisan db:seed
# OR :: for essential data {Admin account && Roles && permissions}
php artisan db:seed --class=EssentialDataSeeder
```

### Step 5: Storage Link
```bash
php artisan storage:link
```

### Step 6: Compile Assets
```bash
npm run build
# OR
npm run dev
```

### Step 7: Start the Application
```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

---

## 🔑 Default Admin Access

After seeding, you can login with:

**Email:** `admin@edulink.com`  
**Password:** `admin123`

---

## 📱 Application Features by Role

### 👨‍💼 Admin Dashboard
- **Overview Stats:** Total students, instructors, courses, revenue
- **Analytics:** Course performance, student activity, revenue trends
- **User Management:** Create/edit/delete students, instructors, staff
- **Course Management:** Create/edit/approve/feature courses
- **Enrollment Management:** Manual enrollments, status updates
- **Category Management:** Create/edit/delete course categories
- **Review Moderation:** Approve/reject course reviews
- **Contact Messages:** Manage contact form submissions
- **Reports:** Export PDF reports of courses, students, enrollments

### 👨‍🏫 Instructor Dashboard
- **My Courses:** List of assigned courses with stats
- **Student Management:** View enrolled students, progress tracking
- **Live Sessions:** Schedule, edit, delete sessions with meeting links
- **Attendance Tracking:** Mark student attendance for sessions
- **Assignments:** Create, edit, grade assignments with feedback
- **Materials:** Upload and manage course materials
- **Bulk Actions:** Update progress, send messages to multiple students
- **Certificate Generation:** Generate completion certificates

### 👨‍🎓 Student Dashboard
- **My Courses:** List of enrolled courses with progress
- **Learning Path:** AI-generated personalized learning journey
- **Live Sessions:** Join scheduled sessions, view recordings
- **Assignments:** Submit work, view grades and feedback
- **Materials:** Access course resources and downloads
- **Progress Tracking:** Visual progress bars and statistics
- **Wishlist:** Save courses for later with priority settings
- **Messages:** Communicate with instructors and admins
- **Notifications:** Real-time updates on activities
- **Reviews:** Rate and review completed courses
- **Certificate Request:** Request certificates upon completion

---

## 📊 Key Functionalities

### 🧠 AI Learning Path Generation
The system analyzes student data to generate personalized learning paths:
- Enrolled and completed courses
- Wishlist items
- Course categories and levels
- Previous engagement patterns

### 🔄 Real-Time Features
- **Message Polling:** New messages appear without page refresh
- **Notification Updates:** Live notification counts
- **Calendar Drag & Drop:** Schedule updates in real-time
- **Read Receipts:** See when messages are read

### 📈 Analytics & Reporting
- **Revenue Charts:** Monthly and daily revenue trends
- **Enrollment Statistics:** Active, completed, pending enrollments
- **Peak Hours Analysis:** Best times for student engagement
- **PDF Export:** Professional reports for courses, students, revenue
- **Rating Distribution:** Visual representation of course ratings

### 🔐 Security Features
- Role-based access control (Spatie Permission)
- Email verification
- Session management
- CSRF protection
- XSS prevention
- SQL injection prevention

---

## 🧪 Testing the Application

### Test Accounts
| Role | Email | Password |
|------|-------|----------|
| Admin | admin@edulink.com | admin123 |
| Instructor | user email from 2 to 11 | instructor123 |
| Student | user email from 12 to 111 | student123 |

### Testing Features

#### Admin Testing
1. View dashboard statistics
2. Create a new course
3. Manage users (students, instructors)
4. View analytics reports
5. Export PDF reports
6. Approve/reject reviews

#### Instructor Testing
1. Create a course
2. Schedule a live session
3. Create an assignment
4. Upload course materials
5. Grade student submissions
6. Send bulk messages
7. Generate certificates

#### Student Testing
1. Browse and enroll in courses
2. Join live sessions
3. Submit assignments
4. Download materials
5. Track progress in learning path
6. Send messages to instructors
7. Write reviews
8. Request certificates

---

## 📝 Developer Notes

### Laravel Sanctum (API Authentication)

Laravel Sanctum is installed and ready for API authentication, but currently remains **dormant** as this is a pure web application. It's included for:

- **Future expansion** – When you're ready to build mobile apps (Flutter/React Native) or separate frontend clients (Vue/React SPAs), Sanctum is pre-configured and waiting.
- **Learning/practice** – You can use it to experiment with building REST APIs for your platform without affecting the web routes.

All API routes are prefixed with `/api` and protected by Sanctum's token authentication. To activate, simply uncomment the API routes in `routes/web.php` and start building endpoints for your courses, users, or learning paths.

*No additional configuration is needed – Sanctum is ready when you are.* 🚀

---

## 👏 Acknowledgments

- **Supervisor:** Eng. Nesma Ahmed Lubbad
- **University:** Islamic University of Gaza (IUG)
- **Faculty:** Faculty of Engineering
- **Department:** Computer Engineering

---

## 📄 License

This project is developed for educational purposes as part of university training. All rights reserved.

---

## 📞 Contact

**Developer:** Eng.Hasan Sammour  
**Email:** hasansammour01@gmail.com  
**GitHub:** [HasanSammour](https://github.com/HasanSammour)  
**University:** Islamic University of Gaza (IUG)

**Training Center:**  
**Name:** Shifra Training & Development Center  
**Email:** shifra.center@gmail.com  
**Location:** Palestine - Gaza - Al-Rimal Camp - East of Al-Shifa Medical Hospital

---

## 🎓 Project Completion Note

This project represents the culmination of practical training in back-end web development using Laravel. It demonstrates:
- Complete CRUD operations
- Complex database relationships
- Role-based access control
- Real-time features
- API integration
- PDF generation
- Responsive design
- Modern UI/UX practices

*Thank you for reviewing this project!* 🚀
