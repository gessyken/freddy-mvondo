<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'civil_act_id',
        'sender_id',
        'recipient_id',
        'message',
        'is_read',
        'message_type',
        'attachments',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'attachments' => 'array',
        ];
    }

    /**
     * Get the civil act that owns the message.
     */
    public function civilAct(): BelongsTo
    {
        return $this->belongsTo(CivilAct::class);
    }

    /**
     * Get the sender of the message.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the recipient of the message.
     */
    public function recipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    /**
     * Check if the message is from a citizen.
     */
    public function isFromCitizen(): bool
    {
        return $this->sender && $this->sender->isCitizen();
    }

    /**
     * Check if the message is from an agent.
     */
    public function isFromAgent(): bool
    {
        return $this->sender && $this->sender->isAgent();
    }

    /**
     * Get the message type label in French.
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->message_type) {
            'general' => 'Général',
            'document_request' => 'Demande de document',
            'status_update' => 'Mise à jour de statut',
            'rejection' => 'Rejet',
            'validation' => 'Validation',
            default => 'Inconnu'
        };
    }

    /**
     * Mark the message as read.
     */
    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }
}
