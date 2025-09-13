<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\CivilAct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CivilAct>
 */
class CivilActFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CivilAct::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = fake()->randomElement(['birth', 'marriage', 'death']);
        $status = fake()->randomElement(['draft', 'submitted', 'pending_payment', 'in_review', 'validated', 'rejected']);
        $paymentStatus = fake()->randomElement(['pending', 'paid', 'failed']);

        // Generate reference number
        $referenceNumber = 'ACT-' . now()->format('Y') . '-' . fake()->unique()->numberBetween(100000, 999999);

        // Generate data based on type
        $data = $this->generateDataForType($type);

        return [
            'user_id' => User::factory(),
            'type' => $type,
            'reference_number' => $referenceNumber,
            'status' => $status,
            'data' => $data,
            'amount' => $this->getAmountForType($type),
            'payment_status' => $paymentStatus,
            'submitted_at' => $status !== 'draft' ? now() : null,
            'validated_at' => $status === 'validated' ? now() : null,
            'rejected_at' => $status === 'rejected' ? now() : null,
            'rejection_reason' => $status === 'rejected' ? fake()->sentence() : null,
            'qr_code' => $status === 'validated' ? fake()->url() : null,
            'pdf_path' => $status === 'validated' ? 'acts/acte-' . $referenceNumber . '.pdf' : null,
        ];
    }

    /**
     * Generate data based on civil act type.
     */
    private function generateDataForType(string $type): array
    {
        switch ($type) {
            case 'birth':
                return [
                    'child_first_name' => fake()->firstName(),
                    'child_last_name' => fake()->lastName(),
                    'child_birth_date' => fake()->date(),
                    'child_birth_place' => fake()->city(),
                    'child_gender' => fake()->randomElement(['M', 'F']),
                    'father_name' => fake()->name('male'),
                    'mother_name' => fake()->name('female'),
                    'father_profession' => fake()->jobTitle(),
                    'mother_profession' => fake()->jobTitle(),
                    'husband_name' => null,
                    'wife_name' => null,
                    'husband_birth_date' => null,
                    'wife_birth_date' => null,
                    'marriage_date' => null,
                    'marriage_place' => null,
                    'deceased_name' => null,
                    'death_date' => null,
                    'death_place' => null,
                    'death_cause' => null,
                    'declarant_name' => null,
                    'relationship' => null,
                ];

            case 'marriage':
                return [
                    'child_first_name' => null,
                    'child_last_name' => null,
                    'child_birth_date' => null,
                    'child_birth_place' => null,
                    'child_gender' => null,
                    'father_name' => null,
                    'mother_name' => null,
                    'father_profession' => null,
                    'mother_profession' => null,
                    'husband_name' => fake()->name('male'),
                    'wife_name' => fake()->name('female'),
                    'husband_birth_date' => fake()->date(),
                    'wife_birth_date' => fake()->date(),
                    'marriage_date' => fake()->date(),
                    'marriage_place' => fake()->city(),
                    'deceased_name' => null,
                    'death_date' => null,
                    'death_place' => null,
                    'death_cause' => null,
                    'declarant_name' => null,
                    'relationship' => null,
                ];

            case 'death':
                return [
                    'child_first_name' => null,
                    'child_last_name' => null,
                    'child_birth_date' => null,
                    'child_birth_place' => null,
                    'child_gender' => null,
                    'father_name' => null,
                    'mother_name' => null,
                    'father_profession' => null,
                    'mother_profession' => null,
                    'husband_name' => null,
                    'wife_name' => null,
                    'husband_birth_date' => null,
                    'wife_birth_date' => null,
                    'marriage_date' => null,
                    'marriage_place' => null,
                    'deceased_name' => fake()->name(),
                    'death_date' => fake()->date(),
                    'death_place' => fake()->city(),
                    'death_cause' => fake()->sentence(),
                    'declarant_name' => fake()->name(),
                    'relationship' => fake()->randomElement(['Fils', 'Fille', 'Époux', 'Épouse', 'Parent', 'Autre']),
                ];

            default:
                return [];
        }
    }

    /**
     * Get amount based on civil act type.
     */
    private function getAmountForType(string $type): string
    {
        return match ($type) {
            'birth' => '7200.00',
            'marriage' => '15000.00',
            'death' => '5000.00',
            default => '5000.00',
        };
    }

    /**
     * Indicate that the civil act is in draft status.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'submitted_at' => null,
            'validated_at' => null,
            'rejected_at' => null,
            'rejection_reason' => null,
            'qr_code' => null,
            'pdf_path' => null,
        ]);
    }

    /**
     * Indicate that the civil act is submitted.
     */
    public function submitted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'submitted',
            'submitted_at' => now(),
            'payment_status' => 'pending',
        ]);
    }

    /**
     * Indicate that the civil act is validated.
     */
    public function validated(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'validated',
            'submitted_at' => now()->subDays(2),
            'validated_at' => now(),
            'payment_status' => 'paid',
            'qr_code' => fake()->url(),
            'pdf_path' => 'acts/acte-' . $attributes['reference_number'] . '.pdf',
        ]);
    }

    /**
     * Indicate that the civil act is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'submitted_at' => now()->subDays(1),
            'rejected_at' => now(),
            'rejection_reason' => fake()->sentence(),
        ]);
    }

    /**
     * Indicate that the civil act is paid.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'payment_status' => 'paid',
        ]);
    }
}