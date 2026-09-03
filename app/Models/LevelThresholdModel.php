<?php

namespace App\Models;

use CodeIgniter\Model;

class LevelThresholdModel extends Model
{
    protected $table            = 'level_thresholds';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = ['level', 'experience_required'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'id'                  => 'integer',
        'level'               => 'integer',
        'experience_required' => 'integer',
    ];

    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'level' => 'required|integer|greater_than[0]',
        'experience_required' => 'required|integer|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
}
