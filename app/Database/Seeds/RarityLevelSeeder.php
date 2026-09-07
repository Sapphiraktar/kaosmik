<?php

namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class RarityLevelSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Commun',
                'color' => '#808080',
                'power_multiplier' => 1.00,
                'cost_multiplier' => 1.00,
                'appearance_rate' => 0.5000,
            ],
            [
                'name' => 'Rare',
                'color' => '#0080FF',
                'power_multiplier' => 1.25,
                'cost_multiplier' => 1.25,
                'appearance_rate' => 0.3000,
            ],
            [
                'name' => 'Épique',
                'color' => '#8000FF',
                'power_multiplier' => 1.50,
                'cost_multiplier' => 1.50,
                'appearance_rate' => 0.1500,
            ],
            [
                'name' => 'Légendaire',
                'color' => '#FF8000',
                'power_multiplier' => 2.00,
                'cost_multiplier' => 2.00,
                'appearance_rate' => 0.0500,
            ],
        ];

        $this->db->table('raritylevels')->insertBatch($data);
    }
}
