<?php

namespace App\Models;

use App\Entities\Player;
use CodeIgniter\Model;

class PlayerModel extends Model
{
    protected $table            = 'players';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Player::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'level',
        'experience',
        'credits',
        'fusion_energy',
        'fleet_capacity',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function findByUserId(int $userId)
    {
        return $this->where('user_id', $userId)->first();
    }

    public function getLevelFromExperience(int $experience): int
    {
        $threshold = model(LevelthresholdModel::class)
            ->where('experience_required <=', $experience)
            ->orderBy('experience_required', 'DESC')
            ->first();

        return $threshold ? (int) $threshold['level'] : 1;
    }

    public function addExperience(Player $player, int $amount): bool
    {
        if ($amount <= 0) {
            return false;
        }

        $oldLevel = (int) $player->level;

        $player->experience += $amount;

        $player->level = $this->getLevelFromExperience(
            (int) $player->experience
        );

        $this->save($player);

        return $player->level > $oldLevel;
    }
}
