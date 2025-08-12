<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CreditApplication
 *
 * @property int $id
 * @property int $user_id
 * @property float $requested_amount
 * @property string $status
 * @property float|null $approved_limit
 * @property float $used_limit
 * @property float $available_limit
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $reviewed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \App\Models\User $user
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|CreditApplication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditApplication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditApplication query()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditApplication whereApprovedLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditApplication whereAvailableLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditApplication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditApplication whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditApplication whereRequestedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditApplication whereReviewedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditApplication whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditApplication whereUsedLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditApplication whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditApplication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditApplication whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CreditApplication pending()
 * @method static \Illuminate\Database\Eloquent\Builder|CreditApplication approved()
 * @method static \Database\Factories\CreditApplicationFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class CreditApplication extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'requested_amount',
        'status',
        'approved_limit',
        'used_limit',
        'available_limit',
        'notes',
        'reviewed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'requested_amount' => 'decimal:2',
        'approved_limit' => 'decimal:2',
        'used_limit' => 'decimal:2',
        'available_limit' => 'decimal:2',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the credit application.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include pending applications.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved applications.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}