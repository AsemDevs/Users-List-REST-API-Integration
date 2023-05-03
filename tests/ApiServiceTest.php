<?php

declare(strict_types=1);

const HOUR_IN_SECONDS = 3600;

use UserSpotlightPro\REST_API\UserApi;
use PHPUnit\Framework\TestCase;
use Brain\Monkey;
use Brain\Monkey\Functions;



class ApiServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Monkey\setUp();
    }

    protected function tearDown(): void
    {
        Monkey\tearDown();
        parent::tearDown();
    }

    public function testFetchUserDetails()
    {
        $userApi = new UserApi();
        $userId = 1;

        // Mock the get_transient() function
        Functions\when('get_transient')->justReturn(false);

        // Mock the wp_remote_get() function
        Functions\when('wp_remote_get')->justReturn([
            'response' => [
                'code' => 200,
                'message' => 'OK'
            ],
            'body' => json_encode([
                'id' => 1,
                'name' => 'John Doe',
                'username' => 'johndoe',
                'email' => 'john.doe@example.com',
            ]),
        ]);

        Functions\when('is_wp_error')->justReturn(false);

        Functions\when('wp_remote_retrieve_body')->alias(function ($response) {
            return $response['body'];
        });

        Functions\when('set_transient')->justReturn(true);

        $userDetails = $userApi->fetchUserDetails($userId);

        $this->assertIsArray($userDetails);
        $this->assertArrayHasKey('id', $userDetails);
        $this->assertEquals($userId, $userDetails['id']);
    }
}
