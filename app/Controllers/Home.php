<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $user = auth()->user();

        return $this->render('home', [
            'user' => $user,
        ]);
    }
}
