<?php

namespace App\Controllers;

use App\Models\BlogModel;
use App\Models\FileManagerModel;
use App\Models\VillageLocationModel;

class DashboardController extends BaseAdminController
{
    public function index()
    {
        $blogModel    = new BlogModel();
        $fileModel    = new FileManagerModel();
        $locationModel = new VillageLocationModel();

        $data['totalBlogs']     = $blogModel->countAllResults();
        $data['publishedBlogs'] = $blogModel->where('status', 'public')->countAllResults();
        $data['totalFiles']     = $fileModel->countAllResults();
        $data['totalLocations'] = $locationModel->countAllResults();
        $data['recentBlogs']    = $blogModel->orderBy('created_at', 'DESC')->findAll(5);

        return view('admin/dashboard', $data);
    }
}
