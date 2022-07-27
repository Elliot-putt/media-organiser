<?php

use Tests\TestCase;

class HomeControllerTest extends TestCase {

    public function test_User_Can_Visit_Home()
    {
        //login in and redirect to home page
        $this->login();
        $this->get(action([\App\Http\Controllers\HomeController::class, 'index']))->assertStatus(200);
    }
    public function test_User_Cannot_Visit_Home()
    {
        //login in and redirect to login page as not logged in
        $this->get(action([\App\Http\Controllers\HomeController::class, 'index']))->assertStatus(302);
    }

}
