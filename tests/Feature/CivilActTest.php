<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\CivilAct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CivilActTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_citizen_can_create_civil_act()
    {
        $user = User::factory()->create(['role' => 'citizen']);
        $this->actingAs($user);

        $civilActData = [
            'type' => 'birth',
            'data' => [
                'child_first_name' => 'Jean',
                'child_last_name' => 'Dupont',
                'child_birth_date' => '2024-01-15',
                'child_birth_place' => 'Yaoundé',
                'child_gender' => 'M',
                'father_name' => 'Père Dupont',
                'mother_name' => 'Mère Dupont',
                'father_profession' => 'Fonctionnaire',
                'mother_profession' => 'Enseignante',
            ],
        ];

        $response = $this->post('/civil-acts', $civilActData);

        $response->assertRedirect();
        $this->assertDatabaseHas('civil_acts', [
            'user_id' => $user->id,
            'type' => 'birth',
            'status' => 'draft',
        ]);
    }

    public function test_civil_act_requires_valid_type()
    {
        $user = User::factory()->create(['role' => 'citizen']);
        $this->actingAs($user);

        $civilActData = [
            'type' => 'invalid_type',
            'data' => [],
        ];

        $response = $this->post('/civil-acts', $civilActData);

        $response->assertSessionHasErrors(['type']);
    }

    public function test_civil_act_generates_reference_number()
    {
        $user = User::factory()->create(['role' => 'citizen']);
        $this->actingAs($user);

        $civilActData = [
            'type' => 'birth',
            'data' => [
                'child_first_name' => 'Jean',
                'child_last_name' => 'Dupont',
                'child_birth_date' => '2024-01-15',
                'child_birth_place' => 'Yaoundé',
                'child_gender' => 'M',
                'father_name' => 'Père Dupont',
                'mother_name' => 'Mère Dupont',
                'father_profession' => 'Fonctionnaire',
                'mother_profession' => 'Enseignante',
            ],
        ];

        $response = $this->post('/civil-acts', $civilActData);

        $civilAct = CivilAct::latest()->first();
        $this->assertNotNull($civilAct->reference_number);
        $this->assertStringStartsWith('ACT-', $civilAct->reference_number);
    }
}