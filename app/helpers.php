<?php

if (!function_exists('readableMenuName')) {
    function readableMenuName($key)
    {
        return [
            'events' => 'Event Management',
            'campaign-categories' => 'Campaign Categories',
            'pra-member' => 'Import Pra Member Tanpa Event',
            'visits' => 'Client Visits',
            'strategic-partnerships' => 'Strategic Partnerships',
            'exports' => 'Export Data',
            'users' => 'User Management',
            'summernote' => 'Content Editor',
            'dashboard' => 'Dashboard',
            'restore' => 'Data Recovery',
            'permissions' => 'Hak Akses',
        ][$key] ?? ucfirst(str_replace('-', ' ', $key));
    }
}