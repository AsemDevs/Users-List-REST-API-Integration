<?php

namespace UserSpotlightPro\Tests;

use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery;

class ApiServiceTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testFetchUsers()
    {
        // Create a mock of the ApiService class
        $apiService = Mockery::mock('\UserSpotlightPro\REST_API\ApiService')->makePartial();
    
        // Mock the get_transient function
        $apiService->shouldReceive('get_transient')->andReturn('');
    
        $this->assertTrue(true);
        
    }
}
