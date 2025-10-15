<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create departments first
        $itDept = Department::create([
            'name' => 'Information Technology',
            'code' => 'IT',
            'description' => 'IT Department handles all technology-related matters',
            'is_active' => true,
        ]);

        $hrDept = Department::create([
            'name' => 'Human Resources',
            'code' => 'HR',
            'description' => 'HR Department manages employee relations',
            'is_active' => true,
        ]);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'employee_id' => 'EMP001',
            'phone' => '081234567890',
            'position' => 'System Administrator',
            'department_id' => $itDept->id,
            'role' => 'admin',
            'hire_date' => '2024-01-01',
            'salary' => 10000000,
            'is_active' => true,
            'address' => 'Jakarta, Indonesia',
        ]);

        // Create manager user
        $manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'employee_id' => 'EMP002',
            'phone' => '081234567891',
            'position' => 'IT Manager',
            'department_id' => $itDept->id,
            'role' => 'manager',
            'hire_date' => '2024-01-15',
            'salary' => 8000000,
            'is_active' => true,
            'address' => 'Jakarta, Indonesia',
        ]);

        // Create employee user
        $employee = User::create([
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'password' => Hash::make('password'),
            'employee_id' => 'EMP003',
            'phone' => '081234567892',
            'position' => 'Software Developer',
            'department_id' => $itDept->id,
            'role' => 'employee',
            'hire_date' => '2024-02-01',
            'salary' => 6000000,
            'is_active' => true,
            'address' => 'Jakarta, Indonesia',
        ]);

        // Update department managers
        $itDept->update(['manager_id' => $manager->id]);
        $hrDept->update(['manager_id' => $admin->id]);
    }
}
