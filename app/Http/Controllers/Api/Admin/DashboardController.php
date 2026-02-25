<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;

class DashboardController extends Controller
{
    public function __construct(private readonly AdminService $adminService)
    {
    }

    public function index()
    {
        return response()->json($this->adminService->dashboard());
    }
}
