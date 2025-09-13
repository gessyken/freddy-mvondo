<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CivilAct extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'reference_number',
        'status',
        'data',
        'amount',
        'payment_status',
        'submitted_at',
        'validated_at',
        'rejected_at',
        'rejection_reason',
        'qr_code',
        'pdf_path',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'submitted_at' => 'datetime',
            'validated_at' => 'datetime',
            'rejected_at' => 'datetime',
            'amount' => 'decimal:2',
        ];
    }

    /**
     * Get the user that owns the civil act.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the documents for the civil act.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get the payments for the civil act.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the messages for the civil act.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the latest payment.
     */
    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latest();
    }

    /**
     * Check if the civil act is paid.
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Check if the civil act is pending payment.
     */
    public function isPendingPayment(): bool
    {
        return $this->status === 'pending_payment';
    }

    /**
     * Check if the civil act is under review.
     */
    public function isUnderReview(): bool
    {
        return $this->status === 'under_review';
    }

    /**
     * Check if the civil act is validated.
     */
    public function isValidated(): bool
    {
        return $this->status === 'validated';
    }

    /**
     * Check if the civil act is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Get the status label in French.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft' => 'Brouillon',
            'pending_payment' => 'En attente de paiement',
            'under_review' => 'En cours d\'examen',
            'validated' => 'Validé',
            'rejected' => 'Rejeté',
            'ready' => 'Prêt',
            default => 'Inconnu'
        };
    }

    /**
     * Get the type label in French.
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'birth' => 'Acte de naissance',
            'marriage' => 'Acte de mariage',
            'death' => 'Acte de décès',
            default => 'Inconnu'
        };
    }

    /**
     * Generate a unique reference number.
     */
    public static function generateReferenceNumber(): string
    {
        do {
            $reference = 'ACT-' . date('Y') . '-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('reference_number', $reference)->exists());

        return $reference;
    }
}
