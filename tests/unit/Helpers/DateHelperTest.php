<?php

namespace Tests\Unit\Helpers;

use CodeIgniter\Test\CIUnitTestCase;

final class DateHelperTest extends CIUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        helper('date');
    }

    public function testFormatDateFrUsesDayMonthYear()
    {
        $this->assertEquals(
            '09/10/2026 14:30',
            format_date_fr('2026-10-09 14:30:00')
        );
    }

    public function testFormatDateFrAcceptsCustomFormat()
    {
        $this->assertEquals(
            '09/10/2026',
            format_date_fr('2026-10-09 14:30:00', 'dd/MM/yyyy')
        );
    }

    public function testFormatDateFrReturnsDashWhenEmpty()
    {
        $this->assertEquals('-', format_date_fr(null));
        $this->assertEquals('-', format_date_fr(''));
    }
}
