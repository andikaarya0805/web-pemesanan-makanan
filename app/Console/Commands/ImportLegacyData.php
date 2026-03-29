<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ImportLegacyData extends Command
{
    protected $signature = 'nutribox:import-legacy';
    protected $description = 'Import users and records from the legacy NutriBox database';

    public function handle()
    {
        $this->info('Starting legacy data import...');

        try {
            $legacyUsers = DB::connection('legacy')->table('users')->get();
        } catch (\Exception $e) {
            $this->error('Could not connect to legacy database: ' . $e->getMessage());
            return 1;
        }

        $importedCount = 0;
        $skippedCount = 0;

        foreach ($legacyUsers as $legacyUser) {
            // Check if user already exists
            if (User::where('email', $legacyUser->email)->exists()) {
                $skippedCount++;
                continue;
            }

            // Determine if password needs hashing
            $password = $legacyUser->password;
            if (!str_starts_with($password, '$2y$')) {
                // Legacy plain text or simple hash -> Re-hash for Laravel
                $password = Hash::make($password);
            }

            User::create([
                'name' => $legacyUser->full_name ?? $legacyUser->username,
                'email' => $legacyUser->email,
                'password' => $password,
                'phone' => $legacyUser->phone,
                'address' => $legacyUser->address,
                'role' => ($legacyUser->role == 'admin') ? 'admin' : 'user',
                'created_at' => $legacyUser->created_at,
            ]);

            $importedCount++;
        }

        $this->info("Import complete. Imported: {$importedCount}, Skipped: {$skippedCount}");
        
        return 0;
    }
}
