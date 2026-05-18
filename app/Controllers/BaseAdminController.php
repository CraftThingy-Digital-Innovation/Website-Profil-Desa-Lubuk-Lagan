<?php

namespace App\Controllers;

use CodeIgniter\Controller;

/**
 * BaseAdminController
 * Semua controller admin WAJIB extends class ini.
 * Guard Shield diterapkan disini, sekali selamanya.
 */
class BaseAdminController extends BaseController
{
    protected string $requiredGroup = 'superadmin,admin,author';

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Auth Guard — jika belum login, tendang ke halaman login
        if (!auth()->loggedIn()) {
            redirect()->to('/login')->send();
            exit;
        }

        // Group Guard — jika tidak punya role yang diperlukan
        $userGroups = auth()->user()->getGroups();
        $requiredGroups = array_map('trim', explode(',', $this->requiredGroup));
        $hasAccess = !empty(array_intersect($requiredGroups, $userGroups));

        if (!$hasAccess) {
            redirect()->to('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.')->send();
            exit;
        }
    }
}
