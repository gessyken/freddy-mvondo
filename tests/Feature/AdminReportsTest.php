<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\CivilAct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminReportsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_admin_can_view_reports()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->get('/admin/reports');

        $response->assertStatus(200);
        $response->assertSee('Rapports et Statistiques');
    }

    public function test_reports_filter_by_period()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        // Create acts in different months
        CivilAct::factory()->create([
            'created_at' => now()->subMonth(),
            'type' => 'birth',
            'status' => 'validated',
        ]);
        CivilAct::factory()->create([
            'created_at' => now(),
            'type' => 'marriage',
            'status' => 'validated',
        ]);

        $response = $this->get('/admin/reports?period=this_month');

        $response->assertStatus(200);
        $response->assertSee('1'); // Only current month acts
    }

    public function test_non_admin_cannot_access_reports()
    {
        $citizen = User::factory()->create(['role' => 'citizen']);
        $this->actingAs($citizen);

        $response = $this->get('/admin/reports');

        $response->assertStatus(403);
    }

    public function test_agent_cannot_access_reports()
    {
        $agent = User::factory()->create(['role' => 'agent']);
        $this->actingAs($agent);

        $response = $this->get('/admin/reports');

        $response->assertStatus(403);
    }
}