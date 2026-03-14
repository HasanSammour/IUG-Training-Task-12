<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    private $arabicNames = [
        'male' => [
            'Mohammed', 'Ahmed', 'Ali', 'Omar', 'Khalid', 'Youssef', 'Ibrahim', 'Hassan', 'Mahmoud', 'Abdullah',
            'Abdulrahman', 'Saad', 'Faisal', 'Saleh', 'Nasser', 'Majid', 'Tariq', 'Waleed', 'Hamza', 'Zaid',
            'Sultan', 'Bandar', 'Nawaf', 'Turki', 'Fahad', 'Mansour', 'Badr', 'Hatem', 'Anas', 'Riyad'
        ],
        'female' => [
            'Fatima', 'Aisha', 'Mariam', 'Noura', 'Layla', 'Sarah', 'Huda', 'Rania', 'Amal', 'Nadia',
            'Samira', 'Mona', 'Reem', 'Hana', 'Dalal', 'Jumana', 'Bushra', 'Asma', 'Khadija', 'Zainab',
            'Lama', 'Raghad', 'Sara', 'Maha', 'Abeer', 'Eman', 'Nawal', 'Hessa', 'Shatha', 'Afnan'
        ]
    ];

    private $companies = [
        'Saudi Aramco', 'STC', 'SABIC', 'Al Rajhi Bank', 'NCB', 'Riyad Bank', 'Samba', 'Zain', 'Mobily',
        'Jarir Bookstore', 'Almarai', 'Savola', 'Binzagr', 'Al Faisaliah', 'Al Jomaih', 'Nahdi Medical',
        'Alhokair Group', 'Al Saif', 'Al Tayyar', 'Al Baik', 'Freelancer', 'Self-Employed', 'Student',
        'Small Business Owner', 'Consultant', 'Government Employee', 'Tech Startup'
    ];

    private $jobTitles = [
        'male' => [
            'Software Engineer', 'IT Manager', 'Business Analyst', 'Project Manager', 'Data Analyst',
            'Marketing Specialist', 'Sales Manager', 'Accountant', 'HR Coordinator', 'Teacher',
            'University Student', 'Fresh Graduate', 'System Administrator', 'Network Engineer',
            'Graphic Designer', 'Content Writer', 'Social Media Specialist', 'Entrepreneur',
            'Consultant', 'Financial Analyst', 'Customer Service Manager', 'Operations Manager'
        ],
        'female' => [
            'Software Developer', 'IT Specialist', 'Marketing Manager', 'HR Manager', 'Data Scientist',
            'Graphic Designer', 'Content Creator', 'Teacher', 'University Student', 'Business Owner',
            'Project Coordinator', 'Account Manager', 'Social Media Manager', 'UX Designer',
            'Researcher', 'Pharmacist', 'Doctor', 'Architect', 'Interior Designer', 'Translator'
        ]
    ];

    public function run(): void
    {
        $startDate = Carbon::parse('2024-01-01');
        $endDate = Carbon::parse('2026-02-15');
        
        // Create Admin (first user, created at platform launch)
        $admin = User::create([
            'name' => 'Abdulaziz Al-Otaibi',
            'email' => 'admin@edulink.com',
            'email_verified_at' => $startDate->copy()->addDays(1),
            'password' => Hash::make('admin123'),
            'phone' => '+966501234567',
            'company' => 'EduLink Academy',
            'job_title' => 'System Administrator',
            'bio' => 'Experienced administrator with 10+ years in educational technology management. Founded EduLink to provide quality education across the Middle East.',
            'settings' => json_encode(['theme' => 'dark', 'notifications' => true, 'language' => 'en', 'timezone' => 'Asia/Riyadh']),
            'created_at' => $startDate,
            'updated_at' => $this->randomDate($startDate, $endDate),
        ]);
        $admin->assignRole('admin');

        // Create Instructors (10 instructors, created gradually)
        $instructorFirstNames = [
            'Dr. Ahmed', 'Prof. Sarah', 'Eng. Khalid', 'Dr. Noura', 'Prof. Fahad', 
            'Dr. Layla', 'Eng. Majid', 'Prof. Reem', 'Dr. Sultan', 'Eng. Huda'
        ];
        
        $instructorLastNames = [
            'Al-Mansoori', 'Al-Jasim', 'Al-Harbi', 'Al-Ghamdi', 'Al-Qahtani',
            'Al-Shammari', 'Al-Otaibi', 'Al-Zahrani', 'Al-Dossari', 'Al-Anazi'
        ];
        
        $instructorExpertise = [
            'Web Development, JavaScript, React, Node.js',
            'Digital Marketing, SEO, Social Media, Analytics',
            'Data Science, Machine Learning, Python, AI',
            'UI/UX Design, Figma, Adobe XD, Design Thinking',
            'Mobile Development, Flutter, iOS, Android',
            'Cybersecurity, Ethical Hacking, Network Security',
            'Business Management, Leadership, Entrepreneurship',
            'Language Learning, English, Arabic, Communication',
            'Cloud Computing, AWS, DevOps, Docker',
            'Database Administration, SQL, MongoDB, Big Data'
        ];

        for ($i = 0; $i < 10; $i++) {
            $gender = $i < 5 ? 'male' : 'female';
            $createdAt = $this->randomDate($startDate, $endDate->copy()->subMonths(3));
            
            $instructor = User::create([
                'name' => $instructorFirstNames[$i] . ' ' . $instructorLastNames[$i],
                'email' => strtolower(str_replace(['Dr. ', 'Prof. ', 'Eng. ', ' ', '.'], '', $instructorFirstNames[$i])) . '.' . strtolower(str_replace('Al-', '', $instructorLastNames[$i])) . '@edulink.com',
                'email_verified_at' => $createdAt->copy()->addDays(rand(0, 3)),
                'password' => Hash::make('instructor123'),
                'phone' => '+9665' . rand(50000000, 59999999),
                'company' => 'EduLink Academy',
                'job_title' => $gender == 'male' ? 'Senior Instructor' : 'Lead Instructor',
                'bio' => "Expert in " . $instructorExpertise[$i] . ". Passionate about teaching and helping students achieve their career goals. " . rand(5, 15) . "+ years of industry experience.",
                'settings' => json_encode([
                    'theme' => rand(0, 1) ? 'dark' : 'light', 
                    'notifications' => true, 
                    'language' => rand(0, 3) ? 'en' : 'ar',
                    'timezone' => 'Asia/Riyadh'
                ]),
                'created_at' => $createdAt,
                'updated_at' => $this->randomDate($createdAt, $endDate),
            ]);
            $instructor->assignRole('instructor');
        }

        // Create Students (100 students, distributed over the 2+ year period)
        for ($i = 1; $i <= 100; $i++) {
            $gender = rand(0, 1) ? 'male' : 'female';
            $firstName = $this->arabicNames[$gender][array_rand($this->arabicNames[$gender])];
            $lastName = $gender == 'male' 
                ? 'Al-' . ['Ghamdi', 'Qahtani', 'Shammari', 'Otaibi', 'Harbi', 'Dossari', 'Zahrani', 'Anazi', 'Rashid', 'Murri'][array_rand(range(0, 9))]
                : 'Al-' . ['Rashid', 'Zahrani', 'Murri', 'Shahrani', 'Timani', 'Ghamdi', 'Qahtani', 'Dossari', 'Anazi', 'Harbi'][array_rand(range(0, 9))];
            
            // Distribute student creation dates throughout the period
            // Earlier students (first half) have more activity
            if ($i <= 30) {
                // First 30 students joined in 2024
                $createdAt = $this->randomDate($startDate, Carbon::parse('2024-12-31'));
            } elseif ($i <= 70) {
                // Next 40 students joined in 2025
                $createdAt = $this->randomDate(Carbon::parse('2025-01-01'), Carbon::parse('2025-12-31'));
            } else {
                // Last 30 students joined in 2026
                $createdAt = $this->randomDate(Carbon::parse('2026-01-01'), $endDate->copy()->subDays(rand(5, 30)));
            }
            
            $hasCompany = rand(0, 2) ? true : false; // 2/3 have company
            $hasJobTitle = rand(0, 2) ? true : false; // 2/3 have job title
            
            $student = User::create([
                'name' => $firstName . ' ' . $lastName,
                'email' => strtolower($firstName) . '.' . strtolower(str_replace('Al-', '', $lastName)) . $i . '@' . (rand(0, 1) ? 'gmail.com' : (rand(0, 1) ? 'hotmail.com' : 'outlook.sa')),
                'email_verified_at' => $createdAt->copy()->addDays(rand(0, 7)),
                'password' => Hash::make('student123'),
                'phone' => rand(0, 1) ? '+9665' . rand(50000000, 59999999) : null,
                'company' => $hasCompany ? $this->companies[array_rand($this->companies)] : null,
                'job_title' => $hasJobTitle ? $this->jobTitles[$gender][array_rand($this->jobTitles[$gender])] : null,
                'bio' => rand(0, 1) ? ($gender == 'male' ? 'Passionate learner' : 'Eager to learn new skills') . ' interested in ' . 
                         ['technology', 'business', 'design', 'marketing', 'development'][array_rand(range(0, 4))] . '.' : null,
                'settings' => json_encode([
                    'theme' => rand(0, 3) ? 'light' : 'dark', 
                    'notifications' => rand(0, 4) ? true : false, 
                    'language' => rand(0, 2) ? 'ar' : 'en',
                    'timezone' => 'Asia/Riyadh'
                ]),
                'created_at' => $createdAt,
                'updated_at' => $this->randomDate($createdAt, $endDate),
            ]);
            $student->assignRole('student');
        }

        $this->command->info('✅ Users created: 1 Admin, 10 Instructors, 100 Students');
    }

    private function randomDate(Carbon $start, Carbon $end): Carbon
    {
        $randomTimestamp = rand($start->timestamp, $end->timestamp);
        return Carbon::createFromTimestamp($randomTimestamp);
    }
}