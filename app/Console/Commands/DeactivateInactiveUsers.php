<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DeactivateInactiveUsers extends Command
{
    protected $signature = 'users:deactivate-inactive';
    protected $description = 'Deactivate non-admin users who have not logged in recently and rotate their passwords';

    public function handle(): int
    {
        // For real use: now()->subDays(5)
        $threshold = now()->subSeconds(300); // testing: 5 seconds
        // $threshold = now()->subDays(5); // For real use

        $users = User::where('role', '!=', 'admin')
            ->where('status', 'active')
            ->where(function ($q) use ($threshold) {
                $q->whereNull('last_login_at')
                ->orWhere('last_login_at', '<', $threshold);
            })
            ->get();
        foreach ($users as $user) {
            $newPasswordPlain = Str::random(10); // or whatever length you want

            $user->status = 'inactive';
            $user->password = Hash::make($newPasswordPlain);
            $user->save();

            // TODO: decide how to communicate this password:
            // - log it
            // - email it
            // - show in some admin UI, etc.
            $this->info("User {$user->id} deactivated; new password: {$newPasswordPlain}");
        }

        $this->info("Processed {$users->count()} users.");

        return self::SUCCESS;
    }
}
