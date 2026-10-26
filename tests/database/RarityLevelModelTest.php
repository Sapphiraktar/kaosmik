<?php

namespace Tests\Database;

use App\Entities\RarityLevel;
use App\Models\RarityLevelModel;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

final class RarityLevelModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate   = true;
    protected $refresh   = true;
    protected $DBGroup   = 'tests';
    protected $namespace = null;
    protected $seed      = 'Tests\Support\Database\Seeds\KaosmikTestSeeder';

    private RarityLevelModel $rarityModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rarityModel = new RarityLevelModel();
    }

    private function newRarity(array $overrides = []): array
    {
        return array_merge([
            'name'             => 'Test',
            'color'            => '#123456',
            'power_multiplier' => '1.2',
            'cost_multiplier'  => '1.2',
            'appearance_rate'  => '5',
        ], $overrides);
    }
    public function testGetRandomRarityReturnsARarity()
    {
        $rarity = $this->rarityModel->getRandomRarity();

        $this->assertInstanceOf(RarityLevel::class, $rarity);
    }
}
