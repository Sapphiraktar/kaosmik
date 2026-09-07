<?php

namespace App\Models;

use CodeIgniter\Model;
use RuntimeException;

class RarityLevelModel extends Model
{
    protected $table            = 'rarity_levels';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'name',
        'color',
        'power_multiplier',
        'cost_multiplier',
        'appearance_rate',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'id'               => 'integer',
        'power_multiplier' => 'float',
        'cost_multiplier'  => 'float',
        'appearance_rate'  => 'float',
    ];

    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;

    protected $beforeInsert = ['convertAppearanceRate',];
    protected $beforeUpdate = ['convertAppearanceRate',];
    protected $beforeDelete = ['calculateCommonAppearanceRate',];
    protected $afterInsert = ['calculateCommonAppearanceRate'];
    protected $afterUpdate = ['calculateCommonAppearanceRate'];
    protected $beforeFind  = [];
    protected $afterFind  = [];
    protected $afterDelete = ['calculateCommonAppearanceRate'];

    /**
     * Convertit appearance_rate en float,
     * notamment lorsque la valeur utilise une virgule décimale.
     */
    protected function convertAppearanceRate(array $data): array
    {
        if (isset($data['data']['appearance_rate'])) {
            $value = $data['data']['appearance_rate'];

            if (is_string($value)) {
                $value = str_replace(',', '.', $value);
            }
            $data['data']['appearance_rate'] = (float) $value;
        }
        return $data;
    }

    protected function calculateCommonAppearanceRate(array $data) {
        //Gestion de l'ID
        $id = $data['id'];
        if(is_array($id)) {
            $ids = $id[0] ?? null;
        }
        //on bloque quanf même toujours le 1
        if ($id==1) {
            return $data;
        }
        //on calcul la somme de toutes les raretés autres que commun
        $result = $this->select('SUM(appearance_rate) as total')
            ->where(['id !=' => 1])
            ->first();

        $sum = $result['total'] ?? 0;
        $newCommonRate = 100 - $sum;
        //on empêche le négatif
        $newCommonRate = max(0, $newCommonRate);

        //on Maj le commun en enpêchant le callback d'être appeler pour ne pas boucler à l'infini
        $this->db->table('rarity_levels')
            ->where(['id' => 1])
            ->update(['appearance_rate' => $newCommonRate]);

        return $data;
    }

    /**
     * Empêche la modification ou la suppression
     * de la rareté par défaut (ID 1).
     */
    protected function protectDefaultRarity(array $data): array
    {
        $id = null;
        // Update
        if (isset($data['id'])) {
            $id = $data['id'];
        }
        // Certains callbacks peuvent fournir l'ID dans data
        if ($id === null && isset($data['data']['id'])) {
            $id = $data['data']['id'];
        }
        // Si on possède un ID, on vérifie la rareté par défaut.
        if ((int) $id === 1) {
            throw new RuntimeException(
                'Interdiction de modifier ou supprimer la rareté par défaut (commun).'
            );
        }
        return $data;
    }
    public function getRandomRarity() {
        //Générer un nombre en 1 et 100
        $random = rand(1, 100);
        $sum = 0;

        //Récupérer toutes les raretés
        $rarities = $this->orderBy('appearance_rate','DESC')->findAll();
        foreach($rarities as $rarity) {
            $sum += $rarity->appearance_rate;
            if ($random <= $sum) {
                return $rarity;
            }
        }
    }
}
