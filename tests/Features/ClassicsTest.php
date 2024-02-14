<?php

namespace Tests\Features;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ClassicsTest extends TestCase
{
    #[Test]
    public function it_can_run_the_classics_command(): void
    {
        exec('php src/classics.php', $output, $exitCode);

        //$this->assertSame(0, $exitCode);

        dd($output);
    }
}
