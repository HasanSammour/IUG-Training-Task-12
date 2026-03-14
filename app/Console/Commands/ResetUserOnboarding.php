<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ResetUserOnboarding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'onboarding:reset {email?}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset onboarding status for a user created only for test';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        if ($email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->update([
                    'onboarding_completed' => false,
                    'onboarding_shown_at' => null,
                ]);
                $this->info("Onboarding reset for {$user->name}");
            } else {
                $this->error("User not found");
            }
        } else {
            // Reset all students
            $count = User::role('student')->update([
                'onboarding_completed' => false,
                'onboarding_shown_at' => null,
            ]);
            $this->info("Onboarding reset for {$count} students");
        }
    }
}
