<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_admin_user_is_recognized_as_admin(): void
    {
        $user = new User([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $this->assertTrue($user->isAdmin());
    }

    public function test_client_user_is_not_recognized_as_admin(): void
    {
        $user = new User([
            'name' => 'Client',
            'email' => 'client@example.com',
            'role' => 'client',
        ]);

        $this->assertFalse($user->isAdmin());
    }

    public function test_user_without_role_is_not_recognized_as_admin(): void
    {
        $user = new User([
            'name' => 'User',
            'email' => 'user@example.com',
        ]);

        $this->assertFalse($user->isAdmin());
    }
}
