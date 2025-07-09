<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'apparelmagic_endpoint' => 'https://linksoultesting.app.apparelmagic.com/api/json/',
            'apparelmagic_token' => '2e281a53b1ce23efd7f7996a38175679',
            'logiwa_endpoint' => 'https://myapisandbox.logiwa.com/v3.1/',
            'logiwa_username' => 'apiuser@civa.tech',
            'logiwa_password' => 'Xyz2024!',
            'logiwa_token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjI0NDkwIiwiaWR0ZnIiOiI4MTkwZTAxNS1kMzA1LTQyNmItOWE3My1lOGIxZjUwMjVmMDUiLCJhY2lkdGZyIjoiY2MyNzc1NWYtMWRhYS00NjY4LWI2NDAtNGM2NDExODMxYWNjIiwiYWNpZCI6IjI1MDc5Iiwib2F1c3IiOiJGYWxzZSIsImFwaWQiOiIwIiwiYXBhdSI6ImY5YmVmNGFlLTc1ZTAtNDZmYS1iNzU4LTdiYWU2NDdhODc4NSIsIm93bnIiOiJGYWxzZSIsImxnaWQiOiIxIiwibmJmIjoxNzIzMjg0NjY4LCJleHAiOjE3MjU4NzY2NjgsImlzcyI6ImxvZ2l3YSIsImF1ZCI6ImxvZ2l3YS1hdWRpZW5jZSJ9.aX0YJGEGAdc15wVitnWyk8Nlc6J1TlS0tJSeSQfsKVU',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
