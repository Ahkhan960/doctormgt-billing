<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('users', function (Blueprint $table) {
        $table->id();

        $table->string('name');
        $table->string('first_name')->nullable();
        $table->string('last_name')->nullable();

        $table->string('email')->unique();
        $table->string('username')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->timestamp('last_login_at')->nullable();
        $table->unsignedInteger('failed_login_attempts')->default(0);
        $table->unsignedInteger('session_version')->default(1);

        $table->string('password');
        $table->rememberToken();

        $table->string('status')->default('active');
        $table->string('role')->default('biller');
        $table->string('designation')->nullable();
        $table->string('employee_id')->nullable();

        $table->string('pseudo_first_name')->nullable();
        $table->string('pseudo_last_name')->nullable();
        $table->string('nic')->nullable();
        $table->date('dob')->nullable();

        $table->string('signature_path')->nullable();
        $table->string('profile_picture_path')->nullable();
        $table->softDeletes(); // adds nullable deleted_at

        $table->timestamps();
    });

        // User::create(['name' => 'Admin','email' => 'admin@themesbrand.com','password' => Hash::make('12345678'),'email_verified_at'=> now(), 'created_at' => now(),]);

        User::create([
            'name' => 'Admin One',
            'first_name' => 'Admin',
            'last_name' => 'One',
            'email' => 'admin@themesbrand.com',
            'username' => 'admin1',
            'password' => Hash::make('12345678'),
            'status' => 'active',
            'role' => 'admin',
            'email_verified_at' => now(),
            'created_at' => now(),
        ]);        
        User::create([
            'name' => 'Manager One',
            'first_name' => 'Manager',
            'last_name' => 'One',
            'email' => 'manager@example.com',
            'username' => 'manager1',
            'password' => Hash::make('12345678'),
            'status' => 'active',
            'role' => 'manager',
            'email_verified_at' => now(),
            'created_at' => now(),
        ]);

        User::create([
            'name' => 'Collector One',
            'first_name' => 'Collector',
            'last_name' => 'One',
            'email' => 'collector@example.com',
            'username' => 'collector1',
            'password' => Hash::make('12345678'),
            'status' => 'active',
            'role' => 'collector',
            'email_verified_at' => now(),
            'created_at' => now(),
        ]);

        User::create([
            'name' => 'Biller One',
            'first_name' => 'Biller',
            'last_name' => 'One',
            'email' => 'biller@example.com',
            'username' => 'biller1',
            'password' => Hash::make('12345678'),
            'status' => 'active',
            'role' => 'biller',
            'email_verified_at' => now(),
            'created_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
