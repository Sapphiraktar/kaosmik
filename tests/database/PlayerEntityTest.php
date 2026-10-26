<?php

namespace Tests\Database;

use App\Entities\Player;
use App\Models\PlayerModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Traits\CreatesPlayers;

final class PlayerEntityTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use CreatesPlayers;

    protected $migrate   = true;
    protected $refresh   = true;
    protected $DBGroup   = 'tests';
    protected $namespace = null;
    protected $seed      = 'Tests\Support\Database\Seeds\KaosmikTestSeeder';

    public function testCheckLevelReadsTheThresholdsTable()
    {
        $player = new Player();

        $this->assertSame(1, $player->checkLevel(0));
        $this->assertSame(1, $player->checkLevel(99));
        $this->assertSame(2, $player->checkLevel(100));
        $this->assertSame(3, $player->checkLevel(230));
    }

    public function testFleetIsFullWhenCapacityIsReached()
    {
        $player = $this->createPlayer('joueur1', ['fleet_capacity' => 2]);
        $this->createHero($player);

        $this->assertFalse($player->isFleetFull());

        $this->createHero($player);
        $fresh = (new PlayerModel())->find($player->id);

        $this->assertTrue($fresh->isFleetFull());
    }
    public function testTotalPowerIsTheSumOfHeroesPower()
    {
        $player = $this->createPlayer('joueur1');
        $this->createHero($player, ['power' => 10]);
        $this->createHero($player, ['power' => 15]);

        $this->assertCount(2, $player->getHeroes());
        $this->assertSame(25, $player->getTotalPower());
    }
}

