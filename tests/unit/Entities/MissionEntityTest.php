<?php

namespace Tests\Unit\Entities;

use App\Entities\Mission;
use codeIgniter\Test\CIUnitTestCase;

final class MissionEntityTest extends CIUnitTestCase
{
    public function testStaminaRequiredUsesTheMaximumCost()
    {
        $mission = new Mission(['stamina_cost_min' => 10, 'stamina_cost_max' => 20]);

        $this->assertEquals (20, $mission->getStaminaRequired());
    }

    public function testPowerRequiredUsesTheMaximumValue()
    {
        $mission = new Mission(['power_required_min' => 15, 'power_required_max' => 30]);

        $this->assertEquals (30, $mission->getPowerRequired());
    }
}