<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Bus;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    protected function setUp(): void
    {
        Parent::setUp();

        Bus::fake([]);
    }
    public function login(User $user = null): User
    {
        $user ??= $user = User::factory()->create();
        $this->actingAs($user);

        return $user;
    }
}
