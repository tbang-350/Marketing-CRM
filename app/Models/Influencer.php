<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Influencer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'instagram_handle',
        'tiktok_handle',
        'youtube_channel',
        'followers_count',
        'engagement_rate',
        'social_media_stats',
        'bio',
        'status',
        'categories',
        'rate_per_post',
    ];

    protected $casts = [
        'social_media_stats' => 'array',
        'categories' => 'array',
        'engagement_rate' => 'decimal:2',
        'rate_per_post' => 'decimal:2',
    ];

    public function campaigns()
    {
        return $this->belongsToMany(Campaign::class)
            ->withPivot([
                'contract_amount',
                'start_date',
                'end_date',
                'status',
                'deliverables',
                'performance_metrics',
                'notes'
            ])
            ->withTimestamps();
    }

    public function getTotalEarningsAttribute()
    {
        return $this->campaigns()
            ->where('status', 'completed')
            ->sum('contract_amount');
    }

    public function getActiveCampaignsCountAttribute()
    {
        return $this->campaigns()
            ->where('status', 'active')
            ->count();
    }
}
