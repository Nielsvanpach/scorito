<?php

namespace Tests\Features;

use PHPUnit\Framework\Attributes\Test;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;

class ClassicsTest extends TestCase
{
    use MatchesSnapshots;

    #[Test]
    public function it_can_run_the_classics_command(): void
    {
        exec('php classics.php', $output, $exitCode);

        $this->assertFileExists('classics.csv');

        $file = fopen('classics.csv', 'rb');

        $this->assertMatchesJsonSnapshot(fgetcsv($file));

        fclose($file);
    }
}
