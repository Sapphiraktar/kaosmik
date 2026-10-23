<?php

namespace Tests\Database;

use App\Entities\Hero;
use App\Entities\Player;
use App\Entities\RarityLevel;
use App\Models\HeroModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Traits\CreatesPlayers;
use CodeIgniter\I18n\Time;


final class HeroModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use CreatesPlayers;

    protected $migrate = true;
    protected $refresh = true;
    protected $DBGroup = 'tests';
    protected $namespace = null;
    protected $seed = 'Tests\Support\Database\Seeds\KaosmikTestSeeder';

    private HeroModel $heroModel;
    private Player $player;

    protected function setUp(): void
    {
        parent::setUp();

        $this->heroModel = new HeroModel();
        $this->player = $this->createPlayer('joueur1');
    }
    public function testCanReadHero(): void
    {
        $hero = $this->createHero($this->player, [
            'name' => 'Beta Test',
        ]);

        $found = $this->heroModel->find($hero->id);

        $this->assertInstanceOf(Hero::class, $found);
        $this->assertSame('Beta Test', $found->name);
    }
}
