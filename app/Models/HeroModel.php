<?php

namespace App\Models;

use App\Entities\Hero;
use CodeIgniter\Model;

class HeroModel extends Model
{
    protected $table            = 'heroes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Hero::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['player_id','hero_model_id','rarity_id','name','power','cost_credit','stamina_current','stamina_max','last_stamina_update'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'name'        => 'required|min_length[3]|max_length[100]',
        'power'       => 'required|is_natural_no_zero',
        'cost_credit' => 'required|is_natural',
    ];

    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = ['refreshStamina'];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function refreshStamina(array $data) {
        if(empty($data['data'])) {
            return $data;
        }
        $heroes = is_array($data['data']) ? $data['data'] : [$data['data']];

        foreach($heroes as $hero) {
            if($hero instanceof Hero && $hero->updateStamina()){
                $this->save($hero);
            }
        }

        return $data;
    }
}