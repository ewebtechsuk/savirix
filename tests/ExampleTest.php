<?php

namespace Tests;

class ExampleTest extends TestCase
{
    public function testHomeDisplaysMarketingPage(): void
    {
        $this->get('/')
            ->assertResponseOk()
            ->see('Modern Estate Agency Software')
            ->see('Get Started Free');
    }
}
