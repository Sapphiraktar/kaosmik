<?php

namespace Tests\Database\Services;

use PHPUnit\Framework\Attributes\Group;
use App\Models\HeroModel;
use App\Models\PlayerModel;
use App\Services\MissionService;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Traits\CreatesPlayers;


#[Group('database')]
#[Group('slow')]
final class MissionServiceTest extends CIUnitTestCase

{
    use DatabaseTestTrait;
    use CreatesPlayers;

    protected $migrate   = true;
    protected $refresh   = true;
    protected $DBGroup   = 'tests';
    protected $namespace = null;
    protected $seed      = 'Tests\Support\Database\Seeds\KaosmikTestSeeder';

    private MissionService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new MissionService();
    }
    public function testSuccessfulMissionGivesRewardsAndConsumesStamina()
    {
        $player = $this->createPlayer('joueur1');
        $hero   = $this->createHero($player, ['power' => 40, 'stamina_current' => 100]);

        $rewards = $this->service->processMission($player, 1, [$hero->id]);

        // Mission 1 : 30-60 crédits, 15-25 xp, 20 d'endurance
        $this->assertGreaterThanOrEqual(30, $rewards['credits']);
        $this->assertLessThanOrEqual(60, $rewards['credits']);

        $this->seeInDatabase('mission_resolutions', ['player_id' => $player->id, 'mission_id' => 1]);
        $this->seeInDatabase('heroes', ['id' => $hero->id, 'stamina_current' => 80]);

        $fresh = (new PlayerModel())->find($player->id);
        $this->assertSame(1000 + $rewards['credits'], $fresh->credits);
        $this->assertSame($rewards['xp'], $fresh->experience);
    }
    public function testUnknownMissionThrowsException()
    {
        $player = $this->createPlayer('joueur1');

        // Indique qu'on s'attend à une exception, et à quel message
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Mission introuvable.');

        // Cette ligne doit lever l'exception
        $this->service->processMission($player, 99999, [1]);
    }

}

