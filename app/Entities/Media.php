<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Media extends Entity
{
    protected $attributes = [
        'name' => 'string',
        'url' => 'string',
        'title' => 'string',
        'alt' => 'string',
        'type' => 'string',
    ];

    public function getUrl() {
        return base_url($this->attributes['url']);
    }

    public function getAbsolutePath() {
        return FCPATH . $this->attributes['url'];
    }

    public function fileExists() {
        return file_exists($this->getAbsolutePath());
    }
}
