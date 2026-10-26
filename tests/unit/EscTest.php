<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;

final class EscTest extends CIUnitTestCase
{
    public function testEscNeutralizesScriptTags()
    {
        $dangerousName = '<script>alert("XSS")</script>Cadet';

        $escaped = esc($dangerousName);

        $this->assertStringNotContainsString('<script>', $escaped);
        $this->assertStringContainsString('&lt;script&gt;', $escaped);
    }
}
