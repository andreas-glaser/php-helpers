<?php

namespace AndreasGlaser\Helpers\Tests;

use AndreasGlaser\Helpers\TimerHelper;
use AndreasGlaser\Helpers\Tests\BaseTest;

/**
 * TimerHelperTest provides comprehensive unit tests for the TimerHelper class.
 *
 * This class tests timing functionality including:
 * - Starting and stopping timers with unique aliases
 * - Measuring elapsed time differences
 * - Exception handling for invalid timer operations
 * - Multiple timer management
 */
class TimerHelperTest extends BaseTest
{
    /**
     * Reset timer state before each test to ensure clean state.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        // Reset static timers array using reflection to ensure clean state
        $reflection = new \ReflectionClass(TimerHelper::class);
        $property = $reflection->getProperty('timers');
        $property->setAccessible(true);
        $property->setValue(null, []);
    }

    /**
     * Tests starting a timer with a unique alias.
     * Verifies that a timer can be started successfully and is stored internally.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\TimerHelper::start
     * @return void
     */
    public function testStart()
    {
        TimerHelper::start('test_timer');
        
        // Use reflection to verify timer was stored
        $reflection = new \ReflectionClass(TimerHelper::class);
        $property = $reflection->getProperty('timers');
        $property->setAccessible(true);
        $timers = $property->getValue();
        
        $this->assertArrayHasKey('test_timer', $timers);
        $this->assertIsFloat($timers['test_timer']); // microtime(true) returns float
    }

    /**
     * Tests that starting a timer with an existing alias throws an exception.
     * Verifies proper exception handling for duplicate timer aliases.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\TimerHelper::start
     * @return void
     */
    public function testStartThrowsExceptionForDuplicateAlias()
    {
        TimerHelper::start('duplicate_timer');
        
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Timer has already been started.');
        
        TimerHelper::start('duplicate_timer');
    }

    /**
     * Tests getting the time difference for a running timer.
     * Verifies that elapsed time is calculated correctly and increases over time.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\TimerHelper::getDifference
     * @return void
     */
    public function testGetDifference()
    {
        TimerHelper::start('diff_timer');
        
        // Small delay to ensure measurable time difference
        \usleep(1000); // 1ms delay
        
        $difference = TimerHelper::getDifference('diff_timer');
        
        $this->assertIsFloat($difference);
        $this->assertGreaterThan(0, $difference);
        $this->assertLessThan(1, $difference); // Should be less than 1 second
    }

    /**
     * Tests that getting difference for non-existent timer throws exception.
     * Verifies proper exception handling when accessing non-started timers.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\TimerHelper::getDifference
     * @return void
     */
    public function testGetDifferenceThrowsExceptionForNonExistentTimer()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Timer has not been started');
        
        TimerHelper::getDifference('non_existent_timer');
    }

    /**
     * Tests stopping a timer and getting the elapsed time.
     * Verifies that stop returns the correct elapsed time and removes the timer.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\TimerHelper::stop
     * @return void
     */
    public function testStop()
    {
        TimerHelper::start('stop_timer');
        
        // Small delay to ensure measurable time difference
        \usleep(1000); // 1ms delay
        
        $elapsed = TimerHelper::stop('stop_timer');
        
        $this->assertIsFloat($elapsed);
        $this->assertGreaterThan(0, $elapsed);
        $this->assertLessThan(1, $elapsed); // Should be less than 1 second
        
        // Verify timer was removed
        $reflection = new \ReflectionClass(TimerHelper::class);
        $property = $reflection->getProperty('timers');
        $property->setAccessible(true);
        $timers = $property->getValue();
        
        $this->assertArrayNotHasKey('stop_timer', $timers);
    }

    /**
     * Tests that stopping a non-existent timer throws an exception.
     * Verifies proper exception handling when stopping non-started timers.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\TimerHelper::stop
     * @return void
     */
    public function testStopThrowsExceptionForNonExistentTimer()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Timer has not been started');
        
        TimerHelper::stop('non_existent_timer');
    }

    /**
     * Tests managing multiple timers simultaneously.
     * Verifies that multiple timers can run concurrently with unique aliases.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\TimerHelper::start
     * @covers \AndreasGlaser\Helpers\TimerHelper::getDifference
     * @covers \AndreasGlaser\Helpers\TimerHelper::stop
     * @return void
     */
    public function testMultipleTimers()
    {
        // Start multiple timers
        TimerHelper::start('timer1');
        \usleep(500); // Small delay
        TimerHelper::start('timer2');
        \usleep(500); // Small delay
        TimerHelper::start('timer3');
        \usleep(500); // Small delay
        
        // Get differences
        $diff1 = TimerHelper::getDifference('timer1');
        $diff2 = TimerHelper::getDifference('timer2');
        $diff3 = TimerHelper::getDifference('timer3');
        
        // Timer1 should have longest elapsed time, timer3 should have shortest
        $this->assertGreaterThan($diff2, $diff1);
        $this->assertGreaterThan($diff3, $diff2);
        
        // Stop all timers
        $elapsed1 = TimerHelper::stop('timer1');
        $elapsed2 = TimerHelper::stop('timer2');
        $elapsed3 = TimerHelper::stop('timer3');
        
        $this->assertIsFloat($elapsed1);
        $this->assertIsFloat($elapsed2);
        $this->assertIsFloat($elapsed3);
        
        // Verify all timers were removed
        $reflection = new \ReflectionClass(TimerHelper::class);
        $property = $reflection->getProperty('timers');
        $property->setAccessible(true);
        $timers = $property->getValue();
        
        $this->assertEmpty($timers);
    }

    /**
     * Tests that difference increases over time for a running timer.
     * Verifies the timer's accuracy by comparing sequential measurements.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\TimerHelper::getDifference
     * @return void
     */
    public function testDifferenceIncreasesOverTime()
    {
        TimerHelper::start('increasing_timer');
        
        $diff1 = TimerHelper::getDifference('increasing_timer');
        \usleep(1000); // 1ms delay
        $diff2 = TimerHelper::getDifference('increasing_timer');
        
        $this->assertGreaterThan($diff1, $diff2);
        
        TimerHelper::stop('increasing_timer');
    }

    /**
     * Tests edge case with empty string alias.
     * Verifies that empty string can be used as a valid timer alias.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\TimerHelper::start
     * @covers \AndreasGlaser\Helpers\TimerHelper::stop
     * @return void
     */
    public function testEmptyStringAlias()
    {
        TimerHelper::start('');
        \usleep(500);
        $elapsed = TimerHelper::stop('');
        
        $this->assertIsFloat($elapsed);
        $this->assertGreaterThan(0, $elapsed);
    }

    /**
     * Tests edge case with numeric string alias.
     * Verifies that numeric strings can be used as valid timer aliases.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\TimerHelper::start
     * @covers \AndreasGlaser\Helpers\TimerHelper::stop
     * @return void
     */
    public function testNumericStringAlias()
    {
        TimerHelper::start('123');
        \usleep(500);
        $elapsed = TimerHelper::stop('123');
        
        $this->assertIsFloat($elapsed);
        $this->assertGreaterThan(0, $elapsed);
    }

    /**
     * Tests that getDifference doesn't affect the timer state.
     * Verifies that calling getDifference multiple times doesn't change the timer.
     *
     * @test
     * @covers \AndreasGlaser\Helpers\TimerHelper::getDifference
     * @return void
     */
    public function testGetDifferenceDoesNotAffectTimer()
    {
        TimerHelper::start('persistent_timer');
        \usleep(500);
        
        // Call getDifference multiple times
        $diff1 = TimerHelper::getDifference('persistent_timer');
        $diff2 = TimerHelper::getDifference('persistent_timer');
        $diff3 = TimerHelper::getDifference('persistent_timer');
        
        // All differences should be close to each other (allowing for small time variations)
        $this->assertEqualsWithDelta($diff1, $diff2, 0.001);
        $this->assertEqualsWithDelta($diff2, $diff3, 0.001);
        
        // Timer should still be available for stopping
        $elapsed = TimerHelper::stop('persistent_timer');
        $this->assertIsFloat($elapsed);
    }
} 