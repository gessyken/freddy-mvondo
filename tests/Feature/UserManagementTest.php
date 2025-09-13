<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_admin_can_view_users_list()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->get('/admin/users');

        $response->assertStatus(200);
        $response->assertSee('Gestion des Utilisateurs');
    }

    public function test_admin_can_create_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $userData = [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'phone' => '+237123456789',
            'role' => 'citizen',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/admin/users', $userData);

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
            'role' => 'citizen',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_view_user_details()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $this->actingAs($admin);

        $response = $this->get("/admin/users/{$user->id}");

        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee($user->email);
    }

    public function test_admin_can_edit_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $this->actingAs($admin);

        $response = $this->get("/admin/users/{$user->id}/edit");

        $response->assertStatus(200);
        $response->assertSee($user->name);
    }

    public function test_admin_can_update_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['name' => 'Old Name']);
        $this->actingAs($admin);

        $updateData = [
            'name' => 'Updated Name',
            'email' => $user->email,
            'phone' => $user->phone,
            'role' => $user->role,
        ];

        $response = $this->put("/admin/users/{$user->id}", $updateData);

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_admin_can_toggle_user_status()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['is_active' => true]);
        $this->actingAs($admin);

        $response = $this->post("/admin/users/{$user->id}/toggle-status");

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_active' => false,
        ]);
    }

    public function test_admin_cannot_toggle_own_status()
    {
        $admin = User::factory()->create(['role' => 'admin', 'is_active' => true]);
        $this->actingAs($admin);

        $response = $this->post("/admin/users/{$admin->id}/toggle-status");

        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'is_active' => true,
        ]);
    }

    public function test_non_admin_cannot_access_user_management()
    {
        $citizen = User::factory()->create(['role' => 'citizen']);
        $this->actingAs($citizen);

        $response = $this->get('/admin/users');

        $response->assertStatus(403);
    }

    public function test_agent_cannot_access_user_management()
    {
        $agent = User::factory()->create(['role' => 'agent']);
        $this->actingAs($agent);

        $response = $this->get('/admin/users');

        $response->assertStatus(403);
    }

    public function test_user_creation_requires_valid_email()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $userData = [
            'name' => 'New User',
            'email' => 'invalid-email',
            'role' => 'citizen',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/admin/users', $userData);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_user_creation_requires_unique_email()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $existingUser = User::factory()->create(['email' => 'existing@example.com']);
        $this->actingAs($admin);

        $userData = [
            'name' => 'New User',
            'email' => 'existing@example.com',
            'role' => 'citizen',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/admin/users', $userData);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_user_creation_requires_valid_role()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $userData = [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'role' => 'invalid_role',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->post('/admin/users', $userData);

        $response->assertSessionHasErrors(['role']);
    }

    public function test_user_update_requires_unique_email_except_self()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user1 = User::factory()->create(['email' => 'user1@example.com']);
        $user2 = User::factory()->create(['email' => 'user2@example.com']);
        $this->actingAs($admin);

        $updateData = [
            'name' => 'Updated Name',
            'email' => 'user2@example.com', // Same as user2
            'phone' => $user1->phone,
            'role' => $user1->role,
        ];

        $response = $this->put("/admin/users/{$user1->id}", $updateData);

        $response->assertSessionHasErrors(['email']);
    }
}