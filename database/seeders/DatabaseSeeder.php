<?php

namespace Database\Seeders;

use App\Models\Configuration;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@actescivils.cm',
            'phone' => '+237 6XX XXX XXX',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create agent users
        User::create([
            'name' => 'Agent Civil 1',
            'email' => 'agent1@actescivils.cm',
            'phone' => '+237 6XX XXX XXX',
            'password' => Hash::make('password'),
            'role' => 'agent',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Agent Civil 2',
            'email' => 'agent2@actescivils.cm',
            'phone' => '+237 6XX XXX XXX',
            'password' => Hash::make('password'),
            'role' => 'agent',
            'is_active' => true,
        ]);

        // Create citizen users
        User::create([
            'name' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
            'phone' => '+237 6XX XXX XXX',
            'password' => Hash::make('password'),
            'role' => 'citizen',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Marie Martin',
            'email' => 'marie.martin@example.com',
            'phone' => '+237 6XX XXX XXX',
            'password' => Hash::make('password'),
            'role' => 'citizen',
            'is_active' => true,
        ]);

        // Create configuration settings
        Configuration::setValue('pricing.birth_certificate', 7200, 'float', 'Prix pour acte de naissance', true);
        Configuration::setValue('pricing.marriage_certificate', 15000, 'float', 'Prix pour acte de mariage', true);
        Configuration::setValue('pricing.death_certificate', 5000, 'float', 'Prix pour acte de décès', true);
        
        Configuration::setValue('deadlines.birth_declaration', 30, 'integer', 'Délai de déclaration de naissance en jours', true);
        Configuration::setValue('deadlines.marriage_declaration', 0, 'integer', 'Délai de déclaration de mariage en jours', true);
        Configuration::setValue('deadlines.death_declaration', 0, 'integer', 'Délai de déclaration de décès en jours', true);

        // Create sample civil acts
        $this->createSampleCivilActs();
    }

    private function createSampleCivilActs()
    {
        $citizens = User::where('role', 'citizen')->get();
        
        foreach ($citizens as $citizen) {
            // Create a birth certificate request
            $birthAct = \App\Models\CivilAct::create([
                'user_id' => $citizen->id,
                'type' => 'birth',
                'reference_number' => \App\Models\CivilAct::generateReferenceNumber(),
                'status' => 'validated',
                'data' => [
                    'child_first_name' => 'Pierre',
                    'child_last_name' => $citizen->name,
                    'child_birth_date' => '2024-01-15',
                    'child_birth_place' => 'Yaoundé',
                    'child_gender' => 'M',
                    'father_name' => 'Père de ' . $citizen->name,
                    'mother_name' => 'Mère de ' . $citizen->name,
                    'father_profession' => 'Fonctionnaire',
                    'mother_profession' => 'Enseignante',
                ],
                'amount' => 7200,
                'payment_status' => 'paid',
                'submitted_at' => now()->subDays(5),
                'validated_at' => now()->subDays(2),
                'qr_code' => route('public.verify-act', 'ACT-2024-123456'),
                'pdf_path' => 'acts/acte-' . \App\Models\CivilAct::generateReferenceNumber() . '.pdf',
            ]);

            // Create a marriage certificate request
            $marriageAct = \App\Models\CivilAct::create([
                'user_id' => $citizen->id,
                'type' => 'marriage',
                'reference_number' => \App\Models\CivilAct::generateReferenceNumber(),
                'status' => 'under_review',
                'data' => [
                    'husband_name' => $citizen->name,
                    'wife_name' => 'Épouse de ' . $citizen->name,
                    'husband_birth_date' => '1990-05-20',
                    'wife_birth_date' => '1992-08-15',
                    'marriage_date' => '2024-06-15',
                    'marriage_place' => 'Yaoundé',
                ],
                'amount' => 15000,
                'payment_status' => 'paid',
                'submitted_at' => now()->subDays(3),
            ]);

            // Create a death certificate request
            $deathAct = \App\Models\CivilAct::create([
                'user_id' => $citizen->id,
                'type' => 'death',
                'reference_number' => \App\Models\CivilAct::generateReferenceNumber(),
                'status' => 'draft',
                'data' => [
                    'deceased_name' => 'Défunt de ' . $citizen->name,
                    'death_date' => '2024-03-10',
                    'death_place' => 'Douala',
                    'death_cause' => 'Maladie',
                    'declarant_name' => $citizen->name,
                    'relationship' => 'Fils',
                ],
                'amount' => 5000,
                'payment_status' => 'pending',
            ]);

            // Create sample payments
            \App\Models\Payment::create([
                'civil_act_id' => $birthAct->id,
                'amount' => 7200,
                'method' => 'mobile_money',
                'status' => 'success',
                'transaction_id' => 'TXN-' . uniqid(),
                'payment_reference' => 'MM-' . date('Ymd') . '-' . rand(1000, 9999),
                'processed_at' => now()->subDays(5),
                'gateway_response' => ['simulated' => true],
            ]);

            \App\Models\Payment::create([
                'civil_act_id' => $marriageAct->id,
                'amount' => 15000,
                'method' => 'bank_transfer',
                'status' => 'success',
                'transaction_id' => 'TXN-' . uniqid(),
                'payment_reference' => 'BT-' . date('Ymd') . '-' . rand(1000, 9999),
                'processed_at' => now()->subDays(3),
                'gateway_response' => ['simulated' => true],
            ]);
        }
    }
}