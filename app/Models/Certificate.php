<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = [
        'user_id',
        'certificate_number',
        'total_hours',
        'hours_volunteered',
        'issue_date',
        'description',
        'status',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'total_hours' => 'integer',
        'hours_volunteered' => 'integer',
    ];

    /**
     * Get the user that owns the certificate.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if certificate is active.
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if certificate is revoked.
     */
    public function isRevoked()
    {
        return $this->status === 'revoked';
    }

    /**
     * Generate a unique certificate number.
     */
    public static function generateCertificateNumber()
    {
        do {
            $number = 'CERT-' . date('Y') . '-' . strtoupper(substr(md5(uniqid()), 0, 8));
        } while (self::where('certificate_number', $number)->exists());

        return $number;
    }
}
