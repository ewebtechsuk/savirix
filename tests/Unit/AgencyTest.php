<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Agency;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AgencyTest extends TestCase
{
    #[Test]
    public function it_builds_tenant_dashboard_url_with_https(): void
    {
        $agency = new Agency(['domain' => 'http://aktonz.savarix.com/']);

        $this->assertSame('https://aktonz.savarix.com/dashboard', $agency->tenantDashboardUrl());
    }

    #[Test]
    public function it_normalizes_domains(): void
    {
        $domain = Agency::normalizeDomain(' HTTPS://Example.SAVARIX.com/ ');

        $this->assertSame('example.savarix.com', $domain);
    }
}
