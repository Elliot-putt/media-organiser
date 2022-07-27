<?php

use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class MediaControllerTest extends TestCase {

    /**
     * @test
     * @dataProvider requests
     */
    public function test_Can_Access_Media(Closure $sendRequest)
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
        yield [fn() => $this->get(action([\App\Http\Controllers\MediaController::class, 'index']))];
        yield [fn() => $this->get(action([\App\Http\Controllers\MediaController::class, 'levelUp']))];
        yield [fn() => $this->get(action([\App\Http\Controllers\MediaController::class, 'checkFolder']  , 'media'))];

    }

}
