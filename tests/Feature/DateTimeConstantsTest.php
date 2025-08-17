<?php

namespace Tests\Feature;

use Tests\TestCase;
use Error;

class DateTimeConstantsTest extends TestCase
{
    /**
     * Test that 3600 constant does not exist
     * and that 3600 should be used instead.
     */
    public function test_datetime_interface_seconds_per_hour_constant_does_not_exist(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionMessage('Undefined constant 3600');
        
        // This should fail - the constant doesn't exist
        $value = \3600;
    }
    
    /**
     * Test that 3600 is the correct value for seconds per hour.
     */
    public function test_correct_seconds_per_hour_value(): void
    {
        $expectedSecondsPerHour = 60 * 60; // 60 minutes * 60 seconds
        $this->assertEquals(3600, $expectedSecondsPerHour);
        
        // Verify our calculation
        $this->assertEquals(3600, $expectedSecondsPerHour);
    }
    
    /**
     * Test helper method to get seconds per hour.
     */
    public function test_seconds_per_hour_helper(): void
    {
        // Instead of 3600, use this value
        $secondsPerHour = 3600;
        
        $this->assertEquals(3600, $secondsPerHour);
        $this->assertEquals(1 * 60 * 60, $secondsPerHour);
    }
}