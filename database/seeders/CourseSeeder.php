<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;

class CourseSeeder extends Seeder
{
    private $courseTemplates = [
        // Web Development Courses
        [
            'category' => 'web-development',
            'titles' => [
                'Complete Web Development Bootcamp 2024',
                'Advanced JavaScript: From Fundamentals to Frameworks',
                'React.js - The Complete Guide (with Hooks)',
                'Node.js API Development Masterclass',
                'Full Stack Development with Laravel & Vue.js',
                'Python Django - The Practical Guide',
                'HTML5 & CSS3: Modern Responsive Web Design',
                'TypeScript: The Complete Developer\'s Guide',
                'Next.js 14 & React - The Complete Guide',
                'Web Security: Authentication & Authorization'
            ],
            'base_price' => 299.99,
        ],
        // Data Science Courses
        [
            'category' => 'data-science',
            'titles' => [
                'Python for Data Science and Machine Learning',
                'Machine Learning A-Z: Hands-On Python',
                'Data Science: Deep Learning in Python',
                'SQL for Data Analysis - Advanced Techniques',
                'Data Visualization with Tableau 2025',
                'Big Data Analytics with Apache Spark',
                'Artificial Intelligence: Reinforcement Learning',
                'Natural Language Processing with Python',
                'Time Series Analysis and Forecasting',
                'Statistics for Data Science and Business'
            ],
            'base_price' => 399.99,
        ],
        // Business & Marketing
        [
            'category' => 'business-marketing',
            'titles' => [
                'Digital Marketing Masterclass 2025',
                'SEO 2025: Complete Search Engine Optimization',
                'Social Media Marketing Strategy',
                'Google Ads & Facebook Ads Certification',
                'Content Marketing: From Strategy to Execution',
                'Email Marketing: Build Campaigns That Convert',
                'Business Analytics with Excel & Python',
                'Project Management Professional (PMP) Prep',
                'Entrepreneurship: Launch Your Online Business',
                'Sales Funnel Optimization & Conversion Rate'
            ],
            'base_price' => 249.99,
        ],
        // Mobile Development
        [
            'category' => 'mobile-development',
            'titles' => [
                'Flutter & Dart - The Complete Guide 2025',
                'iOS Development with SwiftUI',
                'Android Development with Kotlin',
                'React Native - Build Mobile Apps',
                'Cross-Platform Mobile Development with .NET MAUI',
                'Flutter Advanced: State Management',
                'iOS & Swift - Complete iOS App Development',
                'Android Jetpack Compose Masterclass',
                'Mobile UI/UX Design for Developers',
                'Firebase for Mobile Apps'
            ],
            'base_price' => 279.99,
        ],
        // Cybersecurity
        [
            'category' => 'cybersecurity',
            'titles' => [
                'The Complete Cyber Security Course 2025',
                'Ethical Hacking from Scratch',
                'CompTIA Security+ (SY0-701) Complete Course',
                'Network Security: VPNs, Firewalls, IDS/IPS',
                'Certified Information Systems Security Professional (CISSP)',
                'Python for Cybersecurity',
                'Penetration Testing with Kali Linux',
                'Web Application Security Testing',
                'Cloud Security with AWS & Azure',
                'Digital Forensics and Incident Response'
            ],
            'base_price' => 329.99,
        ],
        // Graphic Design
        [
            'category' => 'graphic-design',
            'titles' => [
                'UI/UX Design Fundamentals',
                'Adobe Photoshop Masterclass',
                'Adobe Illustrator for Beginners',
                'Figma: Complete UI/UX Design Course',
                'Graphic Design Theory for Creatives',
                'Logo Design: From Concept to Presentation',
                'Adobe XD: UX Design & Prototyping',
                'Canva for Business Marketing',
                '3D Design with Blender',
                'Motion Graphics with After Effects'
            ],
            'base_price' => 199.99,
        ],
        // Language Learning
        [
            'category' => 'language-learning',
            'titles' => [
                'Business English for Professionals',
                'IELTS Preparation: Complete Course',
                'English Conversation Masterclass',
                'Arabic for Beginners',
                'TOEFL iBT: Complete Preparation',
                'English Grammar: Complete Guide',
                'Presentation Skills in English',
                'Academic Writing Masterclass',
                'English for Software Developers',
                'English for Customer Service'
            ],
            'base_price' => 149.99,
        ],
        // Personal Development
        [
            'category' => 'personal-development',
            'titles' => [
                'Leadership and Management Mastery',
                'Time Management: Productivity Hacks',
                'Public Speaking: Confident Communication',
                'Emotional Intelligence at Work',
                'Critical Thinking and Problem Solving',
                'Negotiation Skills Masterclass',
                'Stress Management and Mindfulness',
                'Career Development: Find Your Dream Job',
                'Building Self-Confidence',
                'Team Collaboration and Communication'
            ],
            'base_price' => 179.99,
        ],
    ];

    private $levelOptions = ['beginner', 'intermediate', 'advanced'];
    private $formatOptions = ['online', 'in-person', 'hybrid'];

    public function run(): void
    {
        $startDate = Carbon::parse('2024-01-01');
        $endDate = Carbon::parse('2026-02-15');
        
        $categories = Category::all()->keyBy('slug');
        
        // Get real instructors from database
        $realInstructors = User::role('instructor')->get();
        
        if ($realInstructors->isEmpty()) {
            $this->command->error('No instructors found! Please run UserSeeder first.');
            return;
        }
        
        // Get all available course images
        $imagePath = public_path('images/courses');
        $availableImages = [];
        
        if (is_dir($imagePath)) {
            $images = scandir($imagePath);
            foreach ($images as $image) {
                if (in_array($image, ['.', '..'])) continue;
                if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $image)) {
                    $availableImages[] = 'images/courses/' . $image;
                }
            }
        }
        
        // If no images found, use placeholder
        if (empty($availableImages)) {
            $availableImages = ['images/courses/placeholder.jpg'];
            $this->command->warn('No images found in public/images/courses/. Using placeholder.');
        } else {
            $this->command->info('Found ' . count($availableImages) . ' course images to use.');
        }
        
        $courseCount = 0;
    
        // Create courses from templates
        foreach ($this->courseTemplates as $template) {
            $category = $categories->get($template['category']);
            if (!$category) continue;
            
            foreach ($template['titles'] as $index => $title) {
                // Distribute course creation dates throughout 2024 and 2025
                if ($index < 4) {
                    $createdAt = $this->randomDate($startDate, Carbon::parse('2024-06-30'));
                } elseif ($index < 8) {
                    $createdAt = $this->randomDate(Carbon::parse('2024-07-01'), Carbon::parse('2024-12-31'));
                } else {
                    $createdAt = $this->randomDate(Carbon::parse('2025-01-01'), Carbon::parse('2025-12-31'));
                }
                
                // Some courses were updated recently
                $updatedAt = $this->randomDate($createdAt, $endDate);
                
                // Pick a random real instructor
                $instructor = $realInstructors->random();
                
                // Use the actual instructor name
                $instructorName = $instructor->name;
                
                $price = $template['base_price'] * (0.8 + (rand(0, 40) / 100)); // Vary price
                $hasDiscount = rand(0, 2) ? true : false; // 2/3 have discount
                $discountPercentage = $hasDiscount ? rand(10, 40) : null;
                $discountedPrice = $hasDiscount ? round($price * (1 - $discountPercentage/100), 2) : null;
                
                // Determine level based on index
                if ($index < 3) $level = 'beginner';
                elseif ($index < 7) $level = 'intermediate';
                else $level = 'advanced';
                
                // Generate learning outcomes
                $learningOutcomes = [];
                for ($j = 1; $j <= 6; $j++) {
                    $learningOutcomes[] = $this->generateLearningOutcome($template['category'], $level);
                }
                
                // Generate requirements
                $requirements = [];
                for ($j = 1; $j <= 4; $j++) {
                    $requirements[] = $this->generateRequirement($level);
                }
                
                $slug = strtolower(str_replace([' ', ',', "'", '&', '.'], ['-', '', '', 'and', ''], $title));
                
                // Select a random image from available images
                $randomImage = $availableImages[array_rand($availableImages)];
                
                Course::create([
                    'category_id' => $category->id,
                    'title' => $title,
                    'slug' => $slug . '-' . rand(1000, 9999),
                    'description' => $this->generateDescription($template['category'], $title),
                    'short_description' => substr($this->generateDescription($template['category'], $title), 0, 150) . '...',
                    'price' => round($price, 2),
                    'discounted_price' => $discountedPrice,
                    'discount_percentage' => $discountPercentage,
                    'instructor_name' => $instructorName,
                    'duration' => rand(4, 20) . ' weeks',
                    'rating' => 0, // Will be updated by reviews
                    'total_students' => 0, // Will be updated by enrollments
                    'level' => $level,
                    'format' => $this->formatOptions[array_rand($this->formatOptions)],
                    'image_path' => $randomImage, // Random image from your folder
                    'tags' => json_encode($this->generateTags($template['category'])),
                    'requirements' => json_encode($requirements),
                    'what_you_will_learn' => json_encode($learningOutcomes),
                    'meta_description' => "Learn " . strtolower($title) . " with our comprehensive course. " . rand(50, 150) . "+ lessons, hands-on projects, and certification.",
                    'is_featured' => rand(0, 4) ? false : true, // 20% featured
                    'is_active' => true,
                    'created_at' => $createdAt,
                    'updated_at' => $updatedAt,
                ]);
                
                $courseCount++;
            }
        }
    
        $this->command->info("✅ {$courseCount} Courses created successfully with real instructors and random images!");
    }

    private function generateDescription($category, $title): string
    {
        $descriptions = [
            'web-development' => "Master modern web development with this comprehensive course. You'll learn industry-standard tools and practices while building real-world projects. Perfect for beginners and experienced developers alike.",
            'data-science' => "Dive into the world of data science with hands-on projects and real datasets. Learn to analyze, visualize, and derive insights from data using Python and industry tools.",
            'business-marketing' => "Transform your business skills with practical marketing strategies. Learn from real case studies and implement campaigns that drive results.",
            'mobile-development' => "Build beautiful, performant mobile apps for iOS and Android. This course covers everything from UI design to backend integration and app store deployment.",
            'cybersecurity' => "Protect systems and networks from cyber threats. Learn ethical hacking, security best practices, and how to build secure applications.",
            'graphic-design' => "Unleash your creativity with professional design tools and techniques. Master the principles of visual communication and create stunning designs.",
            'language-learning' => "Improve your language skills with practical, conversation-focused lessons. Perfect for professional and personal growth.",
            'personal-development' => "Invest in yourself and unlock your full potential. Learn practical skills for career advancement and personal growth.",
        ];
        
        $base = $descriptions[$category] ?? "Comprehensive course covering all aspects of " . strtolower($title) . ".";
        
        return $base . " " . $this->generateUniqueContent($category);
    }

    private function generateUniqueContent($category): string
    {
        $contents = [
            'web-development' => "Includes 10+ projects, lifetime access, and a certificate of completion.",
            'data-science' => "Work with real datasets, build machine learning models, and create data visualizations.",
            'business-marketing' => "Case studies from top companies, practical assignments, and marketing templates.",
            'mobile-development' => "Publish your apps to app stores, implement push notifications, and integrate APIs.",
            'cybersecurity' => "Hands-on labs, capture the flag exercises, and penetration testing simulations.",
            'graphic-design' => "Real-world projects, design challenges, and portfolio-building exercises.",
            'language-learning' => "Interactive exercises, speaking practice, and real-world conversation scenarios.",
            'personal-development' => "Actionable strategies, worksheets, and practical exercises for immediate application.",
        ];
        
        return $contents[$category] ?? "Includes hands-on projects and expert instruction.";
    }

    private function generateLearningOutcome($category, $level): string
    {
        $outcomes = [
            'web-development' => [
                'beginner' => ['Build responsive websites with HTML5 & CSS3', 'Master JavaScript fundamentals', 'Create interactive web pages', 'Understand DOM manipulation', 'Work with APIs', 'Deploy websites to production'],
                'intermediate' => ['Build full-stack applications', 'Implement authentication systems', 'Work with databases', 'Create RESTful APIs', 'Use modern frameworks', 'Optimize application performance'],
                'advanced' => ['Design scalable architecture', 'Implement real-time features', 'Master state management', 'Build microservices', 'Implement CI/CD pipelines', 'Optimize for SEO and performance'],
            ],
            'data-science' => [
                'beginner' => ['Master Python for data analysis', 'Work with Pandas and NumPy', 'Create data visualizations', 'Understand statistics', 'Clean and preprocess data', 'Explore datasets'],
                'intermediate' => ['Build machine learning models', 'Implement regression algorithms', 'Create classification systems', 'Work with neural networks', 'Perform feature engineering', 'Evaluate model performance'],
                'advanced' => ['Design deep learning architectures', 'Implement NLP systems', 'Work with big data tools', 'Build recommendation engines', 'Deploy ML models to production', 'Optimize model performance'],
            ],
            'business-marketing' => [
                'beginner' => ['Understand marketing fundamentals', 'Create social media content', 'Learn SEO basics', 'Set up Google Analytics', 'Write marketing copy', 'Understand customer journey'],
                'intermediate' => ['Build marketing funnels', 'Create email campaigns', 'Optimize ad spend', 'Analyze marketing data', 'Develop brand strategy', 'Master content marketing'],
                'advanced' => ['Develop comprehensive marketing strategies', 'Scale advertising campaigns', 'Implement marketing automation', 'Conduct market research', 'Optimize conversion rates', 'Lead marketing teams'],
            ],
            'mobile-development' => [
                'beginner' => ['Build first mobile app', 'Understand mobile UI components', 'Handle user input', 'Work with device features', 'Navigate between screens', 'Store local data'],
                'intermediate' => ['Connect to APIs', 'Implement state management', 'Add authentication', 'Work with databases', 'Handle push notifications', 'Optimize app performance'],
                'advanced' => ['Build complex animations', 'Implement offline sync', 'Create custom plugins', 'Optimize for production', 'Publish to app stores', 'Monetize applications'],
            ],
            'cybersecurity' => [
                'beginner' => ['Understand security fundamentals', 'Identify common threats', 'Secure network connections', 'Implement basic encryption', 'Practice safe browsing', 'Protect personal data'],
                'intermediate' => ['Perform vulnerability assessments', 'Conduct penetration tests', 'Analyze security logs', 'Implement security policies', 'Configure firewalls', 'Respond to incidents'],
                'advanced' => ['Design secure architectures', 'Perform advanced exploitation', 'Conduct forensic analysis', 'Develop security tools', 'Lead security audits', 'Implement zero-trust models'],
            ],
        ];
        
        $categoryOutcomes = $outcomes[$category] ?? $outcomes['web-development'];
        $levelOutcomes = $categoryOutcomes[$level] ?? $categoryOutcomes['beginner'];
        
        return $levelOutcomes[array_rand($levelOutcomes)];
    }

    private function generateRequirement($level): string
    {
        $requirements = [
            'beginner' => [
                'No prior experience required',
                'Basic computer skills',
                'Internet connection',
                'Willingness to learn',
                'A computer (Windows/Mac/Linux)',
                'Dedication of 3-5 hours per week',
            ],
            'intermediate' => [
                'Basic knowledge of the subject',
                'Familiarity with related tools',
                'Completed beginner courses',
                'Some practical experience',
                'Understanding of core concepts',
            ],
            'advanced' => [
                'Strong foundation in basics',
                'Professional experience recommended',
                'Completed intermediate courses',
                'Familiarity with industry tools',
                'Portfolio of previous work',
            ],
        ];
        
        $levelReqs = $requirements[$level] ?? $requirements['beginner'];
        return $levelReqs[array_rand($levelReqs)];
    }

    private function generateTags($category): array
    {
        $tagSets = [
            'web-development' => ['html', 'css', 'javascript', 'react', 'nodejs', 'php', 'python', 'laravel', 'vue', 'angular', 'typescript', 'web-design'],
            'data-science' => ['python', 'machine-learning', 'data-analysis', 'pandas', 'tensorflow', 'sql', 'visualization', 'statistics', 'ai', 'deep-learning'],
            'business-marketing' => ['marketing', 'seo', 'social-media', 'analytics', 'content', 'email', 'strategy', 'digital-marketing', 'branding', 'advertising'],
            'mobile-development' => ['flutter', 'swift', 'kotlin', 'react-native', 'android', 'ios', 'mobile', 'dart', 'xcode', 'app-development'],
            'cybersecurity' => ['security', 'ethical-hacking', 'network-security', 'encryption', 'penetration-testing', 'cyber', 'infosec', 'hacking'],
            'graphic-design' => ['design', 'ui', 'ux', 'figma', 'photoshop', 'illustrator', 'adobe', 'graphic-design', 'creative', 'visual'],
            'language-learning' => ['english', 'arabic', 'language', 'communication', 'ielts', 'toefl', 'business-english', 'grammar'],
            'personal-development' => ['leadership', 'management', 'soft-skills', 'productivity', 'career', 'self-improvement', 'mindfulness', 'success'],
        ];
        
        $tags = $tagSets[$category] ?? $tagSets['web-development'];
        
        // Return 4-6 random tags (safer method)
        $count = min(rand(4, 6), count($tags));
        
        if ($count <= 0) {
            return ['general'];
        }
        
        // Shuffle and take first $count elements
        shuffle($tags);
        return array_slice($tags, 0, $count);
    }

    private function randomDate(Carbon $start, Carbon $end): Carbon
    {
        $randomTimestamp = rand($start->timestamp, $end->timestamp);
        return Carbon::createFromTimestamp($randomTimestamp);
    }
}