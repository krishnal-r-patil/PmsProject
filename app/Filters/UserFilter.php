<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class UserFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // First check if logged in
        if (!session()->get('user_id')) {
            return redirect()->to(base_url('login'))->with('error', 'Please login first');
        }

        // Check if user is NOT a citizen/user
        if (session()->get('user_role') !== 'user') {
            // Redirect them to their own dashboard
            return redirect()->to(base_url('admin/dashboard'))->with('error', 'You do not have permission to access Citizen area');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
