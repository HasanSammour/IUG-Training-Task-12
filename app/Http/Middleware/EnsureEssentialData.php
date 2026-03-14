<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Database\Seeders\EssentialDataSeeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

class EnsureEssentialData
{
    protected $seeder;
    
    public function __construct(EssentialDataSeeder $seeder)
    {
        $this->seeder = $seeder;
    }
    
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
         Log::info('🔍 EnsureEssentialData middleware running...');

        try {
            if (!Schema::hasTable('users')) {
                Log::info('Users table does not exist yet.');
                return $next($request);
            }

            if (User::count() === 0) {
                Log::info('⚠️ No users found! Running essential seeder via Artisan...');
                
                Artisan::call('db:seed', [
                    '--class' => 'Database\\Seeders\\EssentialDataSeeder'
                ]);
                
                $output = Artisan::output();
                Log::info('✅ Seeder output: ' . $output);
                
                session()->flash('info', 'Welcome to EduLink! An administrator account has been created. (Email: admin@edulink.com / Password: admin123)');
            }
            
        } catch (\Exception $e) {
            Log::error('❌ Error in EnsureEssentialData middleware: ' . $e->getMessage());
        }
        
        return $next($request);
    }
}