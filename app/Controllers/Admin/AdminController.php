<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AdminController extends BaseController
{
    protected $layout = "back";

    public function index()
    {
        $user = auth()->user();


        ([
            'loggedIn' => auth()->loggedIn(),
            'user' => $user,
            'groups' => $user->getGroups(),
            'isAdmin' => $user->inGroup('admin'),
        ]);

        return $this->render('admin/dashboard');
    }
}
