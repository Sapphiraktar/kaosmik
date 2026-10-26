<?php

namespace Tests\Database;

use App\Entities\Hero;
use App\Entities\Player;
use App\Entities\RarityLevel;
use App\Models\HeroModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\I18n\Time;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Traits\CreatesPlayers;

final class HeroModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use CreatesPlayers;

    protected $migrate   = true;
    protected $refresh   = true;
    protected $DBGroup   = 'tests';
    protected $namespace = null;
    protected $seed      = 'Tests\Support\Database\Seeds\KaosmikTestSeeder';

    private HeroModel $heroModel;
    private Player $player;


    protected function setUp(): void
    {
        parent::setUp();

        $this->heroModel = new HeroModel();
        $this->player = $this->createPlayer('joueur1');
    }
    public function testFindDoesNotTouchStaminaOfFullHero()
    {
        $hero = $this->createHero($this->player, ['stamina_current' => 100, 'stamina_max' => 100]);

        $found = $this->heroModel->find($hero->id);

        $this->assertSame(100, $found->stamina_current);
    }
}
