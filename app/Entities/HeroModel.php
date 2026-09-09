<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class HeroModel extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'specialization_id' => 'int',
        'name' => 'string',
        'description' => 'string',
        'power_min' => 'int',
        'power_max' => 'int',
        'cost_credits_min' => 'int',
        'cost_credits_max' => 'int',
        'level_required' => 'int',
    ];

    public function getSpecialization()
    {
        $sm = model(\App\Models\SpecializationModel::class);
        return $sm->find($this->attributes['specialization_id']);
    }
}
