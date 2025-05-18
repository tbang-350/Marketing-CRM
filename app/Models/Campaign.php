<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'budget',
        'status',
        'campaign_type',
        'objectives',
        'target_audience',
    ];

    protected $casts = [
        'objectives' => 'array',
        'target_audience' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function influencers()
    {
        return $this->belongsToMany(Influencer::class)
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

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
