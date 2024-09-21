<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BaseTestCase extends TestCase
{
    //    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        $defaultUser = User::factory([
            'email' => 'default_user@test.com',
            'password' => 123456,
            'name' => 'default_user',
        ])->create();

        $this->actingAs($defaultUser);
    }
}
