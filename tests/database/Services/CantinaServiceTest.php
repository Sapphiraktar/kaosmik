<?php

namespace Tests\Database\Services;

use App\Entities\Hero;
use App\Models\CantinaModel;
use App\Models\PlayerModel;
use App\Services\CantinaService;
use CodeIgniter\I18n\Time;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Traits\CreatesPlayers;

final class CantinaServiceTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use CreatesPlayers;

    protected $migrate = true;
    protected $refresh = true;
    protected $DBGroup = 'tests';
    protected $namespace = null;
    protected $seed = 'Tests\Support\Database\Seeds\KaosmikTestSeeder';

    private CantinaService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new CantinaService();
    }

    public function testRecruitCreatesHeroAndChargesPlayer()
    {
        $player = $this->createPlayer('joueur1');
        $offer = $this->service->generateOffers($player->id)[0];

        $hero = $this->service->recruit($offer->id);

        $this->assertInstanceOf(Hero::class, $hero);
        $this->assertSame($player->id, $hero->player_id);
        $this->assertSame(1000 - $offer->cost_credit, (new PlayerModel())->find($player->id)->credits);
    }

    public function testRecruitFailsWhenPlayerCannotAfford()
    {
        $player = $this->createPlayer('joueur1', ['credits' => 0]);
        $offer = $this->service->generateOffers($player->id)[0];

        $this->assertNull($this->service->recruit($offer->id));
        $this->seeNumRecords(0, 'heroes', ['player_id' => $player->id]);
    }

    public function testRecruitFailsWhenFleetIsFull()
    {
        $player = $this->createPlayer('joueur1', ['fleet_capacity' => 1]);
        $this->createHero($player);
        $offer = $this->service->generateOffers($player->id)[0];

        $this->assertNull($this->service->recruit($offer->id));
    }

    public function testRecruitUnknownOfferReturnsNull()
    {
        $this->assertNull($this->service->recruit(99999));
    }
}
