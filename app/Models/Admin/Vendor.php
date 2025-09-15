<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

class Vendor extends Model
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'status',
        'contact_email',
        'contact_phone',
        'address',
        'commission_rate',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(VendorSetting::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(VendorReview::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(VendorPayment::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getTotalEarningsAttribute()
    {
        return $this->payments()->sum('amount');
    }

    public function getStatusBadgeAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function getStatusClassAttribute()
    {
        return $this->status ? 'success' : 'danger';
    }
}
