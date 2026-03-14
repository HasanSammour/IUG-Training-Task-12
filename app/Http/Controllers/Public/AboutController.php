<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\CourseReview;

class AboutController extends Controller
{
    public function index()
    {
        $stats = [
            'total_courses' => Course::count(),
            'total_students' => User::role('student')->count(),
            'success_rate' => 95,
            'instructors' => User::role('instructor')->count(),
        ];
        
        $features = [
            [
                'title' => 'AI-Powered Learning Paths',
                'description' => 'Personalized learning journeys tailored to your goals and pace using cutting-edge artificial intelligence that adapts to your progress.',
                'icon' => 'fa-brain'
            ],
            [
                'title' => 'Expert Instructors',
                'description' => 'Learn from industry professionals with real-world experience and proven track records in their respective fields.',
                'icon' => 'fa-chalkboard-teacher'
            ],
            [
                'title' => 'Live Interactive Sessions',
                'description' => 'Engage in real-time learning with live sessions via Google Meet and Zoom platforms, with recordings available afterward.',
                'icon' => 'fa-video'
            ],
            [
                'title' => 'Comprehensive Resources',
                'description' => 'Access a wealth of materials, assignments, and recordings to enhance your learning journey at your own pace.',
                'icon' => 'fa-file-alt'
            ],
            [
                'title' => 'Practical Assignments',
                'description' => 'Apply your knowledge with hands-on assignments and projects that simulate real-world scenarios.',
                'icon' => 'fa-laptop-code'
            ],
            [
                'title' => 'Certificate of Completion',
                'description' => 'Earn recognized certificates upon course completion to showcase your new skills and boost your career.',
                'icon' => 'fa-certificate'
            ],
            [
                'title' => 'Flexible Learning',
                'description' => 'Study at your own pace with 24/7 access to course materials, recordings, and resources.',
                'icon' => 'fa-clock'
            ],
            [
                'title' => 'Community Support',
                'description' => 'Connect with fellow learners and instructors through our integrated messaging system.',
                'icon' => 'fa-users'
            ],
        ];

        $company = [
            'name' => 'مركز شيفرة للتدريب و التطوير',
            'name_en' => 'Shifra Training & Development Center',
            'email' => 'shifra.center@gmail.com',
            'whatsapp' => 'https://whatsapp.com/channel/0029VbBHUCv8kyyDuKmDzh2w',
            'instagram' => 'https://www.instagram.com/p/DQ_gRYyDMlx/?igsh=b2hieGZqcTM2bmho',
            'location' => 'Palestine - Gaza - Al-Rimal Camp - East of Al-Shifa Medical Hospital',
            'map_url' => 'https://www.google.com/maps/place/Al-Shifa+Medical+Complex/@31.5243795,34.4353623,17z/data=!3m1!4b1!4m6!3m5!1s0x14fd7f5a0b9b9b9b:0x9b9b9b9b9b9b9b9b!8m2!3d31.5243795!4d34.4379372!16s%2Fg%2F1td0b0j3?entry=ttu',
        ];

        $designer = [
            'name' => 'Engineer Hasan Younis Sammour',
            'title' => 'Computer Engineering Student',
            'university' => 'Islamic University of Gaza (IUG)',
            'faculty' => 'Faculty of Engineering',
            'department' => 'Computer Engineering Department',
            'github' => 'https://github.com/HasanSammour',
            'image' => asset('images/hasan-sammour.jpeg'),
            'bio' => 'Hasan Younis Sammour is a dedicated Computer Engineering student at the Islamic University of Gaza, passionate about using technology to solve real-world problems. This project represents the culmination of his practical training experience in developing comprehensive web solutions for educational platforms. The Shifra Training Center platform demonstrates his ability to create robust, user-friendly systems that connect instructors and students in a seamless learning environment.',
            'project_duration' => '2 Months (Practical Training)',
            'project_type' => 'Practical Training Project',
            'year' => '2025/2026',
            'status' => 'Completed',
        ];

        $techStack = [
            ['name' => 'PHP Laravel', 'icon' => 'fa-brands fa-php'],
            ['name' => 'MySQL', 'icon' => 'fa-solid fa-database'],
            ['name' => 'Laravel Blade', 'icon' => 'fa-solid fa-code'],
            ['name' => 'Bootstrap 5', 'icon' => 'fa-brands fa-bootstrap'],
            ['name' => 'JavaScript', 'icon' => 'fa-brands fa-js'],
            ['name' => 'AJAX', 'icon' => 'fa-solid fa-cloud'],
            ['name' => 'SweetAlert2', 'icon' => 'fa-solid fa-bolt'],
            ['name' => 'Chart.js', 'icon' => 'fa-solid fa-chart-line'],
            ['name' => 'FullCalendar', 'icon' => 'fa-solid fa-calendar'],
            ['name' => 'Git & GitHub', 'icon' => 'fa-brands fa-github'],
        ];

        $tools = ['VS Code', 'Git Bash', 'Chrome DevTools'];

        return view('public.about', compact(
            'stats', 
            'features', 
            'company', 
            'designer', 
            'techStack', 
            'tools'
        ));
    }
}