<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Event Management
            ['menu' => 'Event Management', 'action' => 'view'],
            ['menu' => 'Event Management', 'action' => 'create'],
            ['menu' => 'Event Management', 'action' => 'edit'],
            ['menu' => 'Event Management', 'action' => 'import'],

            // Campaign Categories
            ['menu' => 'Campaign Categories', 'action' => 'view'],
            ['menu' => 'Campaign Categories', 'action' => 'create'],
            ['menu' => 'Campaign Categories', 'action' => 'edit'],
            ['menu' => 'Campaign Categories', 'action' => 'delete'],

            // Import Pra Member Tanpa Event
            ['menu' => 'Import Pra Member Tanpa Event', 'action' => 'import'],
            ['menu' => 'Import Pra Member Tanpa Event', 'action' => 'view'],

            // Client Visits
            ['menu' => 'Client Visits', 'action' => 'view'],
            ['menu' => 'Client Visits', 'action' => 'create'],
            ['menu' => 'Client Visits', 'action' => 'edit'],
            ['menu' => 'Client Visits', 'action' => 'delete'],

            // Strategic Partnerships
            ['menu' => 'Strategic Partnerships', 'action' => 'view'],
            ['menu' => 'Strategic Partnerships', 'action' => 'create'],
            ['menu' => 'Strategic Partnerships', 'action' => 'edit'],
            ['menu' => 'Strategic Partnerships', 'action' => 'delete'],

            // Export Data
            ['menu' => 'Export Data', 'action' => 'view'],

            // User Management
            ['menu' => 'User Management', 'action' => 'view'],
            ['menu' => 'User Management', 'action' => 'edit'],
            ['menu' => 'User Management', 'action' => 'create'],

            // Content Editor
            ['menu' => 'Content Editor', 'action' => 'access'],

            // Data Recovery
            ['menu' => 'Data Recovery', 'action' => 'access'],
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate($p);
        }
    }
}