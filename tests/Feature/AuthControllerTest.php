<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    /** @test */
    public function can_User_login_via_username()
    {
        $User = User::factory()->create([
            'email' => 'saeed@gmail.com',
            'password' => '12345678@Wd',
        ]);

        $response = $this->post(route('Users.login'), [
            'username' => 'WRONG USERNAME',
            'password' => 'WRONG PASSWORD',
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $response = $this->post(route('Users.login'), [
            'username' => $User->email,
            'password' => 'WRONG PASSWORD',
        ]);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);

        $response = $this->post(route('Users.login'), [
            'username' => $User->email,
            'password' => '12345678@Wd',
        ]);

        $response->assertStatus(200);
        $response->assertJson(
            fn (AssertableJson $json) => $json->has('data.access_token')
                ->where('data.user.email', $User->email)
                ->where('data.user.phone', $User->phone)
                ->etc()
        );
    }

    public function test_refresh_token()
    {
        $User = User::factory()->create([
            'email' => 'saeed@gmail.com',
            'password' => '12345678@Wd',
        ]);

        $response = $this->post(route('Users.login'), [
            'username' => $User->email,
            'password' => '12345678@Wd',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer '.$response->json('data.access_token'))->post(route('Users.refresh'));
        $response->assertStatus(200);
    }
}
