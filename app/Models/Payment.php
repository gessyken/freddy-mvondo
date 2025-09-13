<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'civil_act_id',
        'amount',
        'method',
        'status',
        'transaction_id',
        'payment_reference',
        'processed_at',
        'failure_reason',
        'gateway_response',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'processed_at' => 'datetime',
            'gateway_response' => 'array',
        ];
    }

    /**
     * Get the civil act that owns the payment.
     */
    public function civilAct(): BelongsTo
    {
        return $this->belongsTo(CivilAct::class);
    }

    /**
     * Check if the payment is successful.
     */
    public function isSuccessful(): bool
    {
        return $this->status === 'success';
    }

    /**
     * Check if the payment is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the payment failed.
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Get the status label in French.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'En attente',
            'success' => 'Réussi',
            'failed' => 'Échoué',
            'cancelled' => 'Annulé',
            default => 'Inconnu'
        };
    }

    /**
     * Get the method label in French.
     */
    public function getMethodLabelAttribute(): string
    {
        return match($this->method) {
            'mobile_money' => 'Mobile Money',
            'bank_transfer' => 'Virement bancaire',
            'cash' => 'Espèces',
            default => 'Inconnu'
        };
    }
}
