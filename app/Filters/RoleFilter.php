<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    /**
     * Check if the logged-in user's role is in the allowed roles list.
     * Usage in routes: ['filter' => 'role:Admin,Manajer']
     *
     * @param RequestInterface $request
     * @param array|null       $arguments  Allowed role names, e.g. ['Admin','Manajer']
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $userRole = session()->get('role');

        // If no arguments provided, allow all authenticated users
        if (empty($arguments)) {
            return;
        }

        // Check if user's role is in the allowed list
        if (!in_array($userRole, $arguments)) {
            return redirect()->to('/admin')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed
    }
}
