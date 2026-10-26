<?php

namespace Tests\Feature\Controllers;

use PHPUnit\Framework\Attributes\DataProvider;
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
    #[DataProvider('invalidLoginProvider')]
    public function testLoginWithInvalidCredentials(string $email, string $password, string $sessionKey, string|array $expected)
    {
        $this->createPlayer('joueur1');

        $result = $this->post('/login', ['email' => $email, 'password' => $password]);

        $result->assertSessionHas($sessionKey, $expected);
    }

    /**
     * Fournit différents cas de connexion invalides
     */
    public static function invalidLoginProvider(): array
    {
        return [
            'email_inconnu'   => ['inconnu@kaosmik.test', 'Kaosmik2026!', 'error', 'Unable to log you in. Please check your credentials.'],
            'password_errone' => ['joueur1@kaosmik.test', 'MauvaisMotDePasse1!', 'error', 'Unable to log you in. Please check your password.'],
            'champs_vides'    => ['', '', 'errors', [
                'email'    => 'The Email Address field is required.',
                'password' => 'The Password field is required.',
            ]],
            'email_malforme'  => ['pasunemail', 'Kaosmik2026!', 'errors', [
                'email' => 'The Email Address field must contain a valid email address.',
            ]],
        ];
    }


}
