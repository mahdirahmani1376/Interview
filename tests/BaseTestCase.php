<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BaseTestCase extends TestCase
{
//    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        $defaultUser = User::factory([
            'email' => 'default_user@test.com',
            'password' => 123456,
            'name' => 'default_user'
        ])->create();

        $this->actingAs($defaultUser);
    }
}
