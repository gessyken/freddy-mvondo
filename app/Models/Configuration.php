<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'description',
        'type',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'is_public' => 'boolean',
        ];
    }

    /**
     * Get a configuration value by key.
     */
    public static function getValue(string $key, $default = null)
    {
        $config = self::where('key', $key)->first();
        
        if (!$config) {
            return $default;
        }

        return match($config->type) {
            'boolean' => (bool) $config->value,
            'integer' => (int) $config->value,
            'float' => (float) $config->value,
            'array' => json_decode($config->value, true),
            'json' => json_decode($config->value, true),
            default => $config->value
        };
    }

    /**
     * Set a configuration value by key.
     */
    public static function setValue(string $key, $value, string $type = 'string', string $description = null, bool $isPublic = false): void
    {
        $config = self::where('key', $key)->first();
        
        if (!$config) {
            $config = new self();
            $config->key = $key;
            $config->type = $type;
            $config->description = $description;
            $config->is_public = $isPublic;
        }

        $config->value = is_array($value) ? json_encode($value) : (string) $value;
        $config->save();
    }

    /**
     * Get all public configurations.
     */
    public static function getPublicConfigurations(): array
    {
        return self::where('is_public', true)
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * Get pricing configuration.
     */
    public static function getPricing(): array
    {
        return [
            'birth_certificate' => self::getValue('pricing.birth_certificate', 7200),
            'marriage_certificate' => self::getValue('pricing.marriage_certificate', 15000),
            'death_certificate' => self::getValue('pricing.death_certificate', 5000),
        ];
    }

    /**
     * Get deadline configuration.
     */
    public static function getDeadlines(): array
    {
        return [
            'birth_declaration' => self::getValue('deadlines.birth_declaration', 30), // days
            'marriage_declaration' => self::getValue('deadlines.marriage_declaration', 0),
            'death_declaration' => self::getValue('deadlines.death_declaration', 0),
        ];
    }
}
