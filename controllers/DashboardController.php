<?php

class DashboardController
{
    public function index()
    {
        // Require the view file for the dashboard
        require_once __DIR__ . '/../views/dashboard/index.php';
    }
}
