<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_User_login_via_email()
    {
        $User = User::factory()->create([
            'email' => 'mahdi@gmail.com',
            'password' => '12345678@Wd',
        ]);

        $response = $this->postJson(route('login'), [
            'email' => $User->email,
            'password' => '12345678@Wd',
        ]);

        $response->assertStatus(200);
        $response->assertJson(
            fn (AssertableJson $json) => $json->has('data.access_token')
                ->where('data.user.email', $User->email)
                ->etc()
        );
    }

    public function test_refresh_token()
    {
        $User = User::factory()->create([
            'email' => 'mahdi@gmail.com',
            'password' => '12345678@Wd',
        ]);

        $response = $this->postJson(route('login'), [
            'email' => $User->email,
            'password' => '12345678@Wd',
        ]);

        $response = $this->withHeader('Authorization', 'Bearer '.$response->json('data.access_token'))->post(route('refresh'));
        $response->assertStatus(200);
    }
}
