<?php

namespace Tests\Feature;

use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = $this->app->make(UserService::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        $this->assertTrue($this->userService->login('padhilahm@gmail.com', 'password'));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginFailed()
    {
        $this->assertFalse($this->userService->login('padhilah@gmail.com', 'password'));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLogoutSuccess()
    {
        $this->assertTrue($this->userService->logout());
    }
}
