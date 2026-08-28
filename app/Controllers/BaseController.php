<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class BaseController extends Controller
{
    protected $helpers = ['url', 'form'];

    protected $title = '';

    protected function render(string $view, array $data = [])
    {
        $data['title'] = $this->title;

        // Menus disponibles dans la barre de navigation
        $data['menus'] = [
            'home' => [
                'url'   => '/',
                'icon'  => '<i class="fa-solid fa-house"></i>',
                'title' => 'Accueil',
            ],
            'login' => [
                'url'   => 'login',
                'icon'  => '<i class="fa-solid fa-right-to-bracket"></i>',
                'title' => 'Connexion',
            ],
            'register' => [
                'url'   => 'register',
                'icon'  => '<i class="fa-solid fa-user-plus"></i>',
                'title' => 'Inscription',
            ],
        ];

        return view('template/head', $data)
            . view($view, $data)
            . view('template/footer', $data);
    }

    protected function success(string $message)
    {
        session()->setFlashdata('success', $message);
    }
}
