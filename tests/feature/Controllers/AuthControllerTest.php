<?php

namespace Tests\Feature\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use Tests\Support\Traits\CreatesPlayers;

class AuthControllerTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;
    use CreatesPlayers;

    protected $refresh = true;

    // Inclut les migrations de l'application et des packages.
    protected $namespace = null;

    public function testAdminPageIsAccessibleForAdmin()
    {
        $player = $this->createPlayer('admin');
        $user   = $this->getUserOf($player);
        $user->addGroup('admin');
        auth()->login($user);

        $result = $this->get('/admin');

        $result->assertStatus(200);
    }


}
