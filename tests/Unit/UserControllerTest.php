<?php

use App\Models\User;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class UserControllerTest extends TestCase {

    public function test_User_Logging_In()
    {
        $user = $this->login();
        $this->assertDatabaseCount('users' , 1);
    }

    /**
     * @test
     * @dataProvider requests
     */
    public function test_Users_Can_Access(Closure $sendRequest)
    {
        //User Trying to complete the action
        $this->login();

        //Model trying to be accessed
        $user = \App\Models\User::factory()->create();

        /** @var TestResponse $response */
        $response = $sendRequest->call($this, $user);

        //expected Response
        $this->assertTrue(in_array($response->status(), [200, 302]));
    }

    public function requests(): \Generator
    {
        yield [fn(\App\Models\User $user) => $this->get(action([\App\Http\Controllers\UserController::class, 'index']))];
        yield [fn(\App\Models\User $user) => $this->get(action([\App\Http\Controllers\UserController::class, 'create']))];
        yield [fn(\App\Models\User $user) => $this->get(action([\App\Http\Controllers\UserController::class, 'store']))];

    }
}
