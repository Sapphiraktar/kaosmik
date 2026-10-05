<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableMissionResolutions extends Migration
{
    public function up()
    {
        $fields = [
            'experience_gained' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'default'  => 0
            ]
        ];
        $this->forge->addColumn('mission_resolutions', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('mission_resolutions', 'experience_gained');
    }
}