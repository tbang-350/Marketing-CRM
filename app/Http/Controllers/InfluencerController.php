<?php

namespace App\Http\Controllers;

use App\Models\Influencer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InfluencerController extends Controller
{
    public function index()
    {
        $influencers = Influencer::with(['campaigns' => function($query) {
            $query->where('status', 'active');
        }])->latest()->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $influencers
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:influencers',
            'phone' => 'nullable|string|max:20',
            'instagram_handle' => 'nullable|string|max:100',
            'tiktok_handle' => 'nullable|string|max:100',
            'youtube_channel' => 'nullable|string|max:100',
            'followers_count' => 'required|integer|min:0',
            'engagement_rate' => 'required|numeric|min:0|max:100',
            'social_media_stats' => 'nullable|array',
            'bio' => 'nullable|string',
            'status' => 'required|in:active,inactive,blacklisted',
            'categories' => 'nullable|array',
            'rate_per_post' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $influencer = Influencer::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Influencer created successfully',
            'data' => $influencer
        ], 201);
    }

    public function show(Influencer $influencer)
    {
        $influencer->load(['campaigns' => function($query) {
            $query->with('client');
        }]);

        return response()->json([
            'status' => 'success',
            'data' => $influencer
        ]);
    }

    public function update(Request $request, Influencer $influencer)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:influencers,email,' . $influencer->id,
            'phone' => 'nullable|string|max:20',
            'instagram_handle' => 'nullable|string|max:100',
            'tiktok_handle' => 'nullable|string|max:100',
            'youtube_channel' => 'nullable|string|max:100',
            'followers_count' => 'sometimes|required|integer|min:0',
            'engagement_rate' => 'sometimes|required|numeric|min:0|max:100',
            'social_media_stats' => 'nullable|array',
            'bio' => 'nullable|string',
            'status' => 'sometimes|required|in:active,inactive,blacklisted',
            'categories' => 'nullable|array',
            'rate_per_post' => 'nullable|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $influencer->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Influencer updated successfully',
            'data' => $influencer
        ]);
    }

    public function destroy(Influencer $influencer)
    {
        $influencer->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Influencer deleted successfully'
        ]);
    }

    public function getInfluencerStats(Influencer $influencer)
    {
        $stats = [
            'total_campaigns' => $influencer->campaigns()->count(),
            'active_campaigns' => $influencer->campaigns()->wherePivot('status', 'active')->count(),
            'completed_campaigns' => $influencer->campaigns()->wherePivot('status', 'completed')->count(),
            'total_earnings' => $influencer->total_earnings,
            'average_engagement_rate' => $influencer->engagement_rate,
            'campaign_performance' => $this->getCampaignPerformance($influencer)
        ];

        return response()->json([
            'status' => 'success',
            'data' => $stats
        ]);
    }

    private function getCampaignPerformance(Influencer $influencer)
    {
        return $influencer->campaigns()
            ->wherePivot('status', 'completed')
            ->get()
            ->map(function ($campaign) {
                return [
                    'campaign_id' => $campaign->id,
                    'campaign_name' => $campaign->name,
                    'client_name' => $campaign->client->company_name,
                    'performance_metrics' => $campaign->pivot->performance_metrics,
                    'contract_amount' => $campaign->pivot->contract_amount
                ];
            });
    }

    public function search(Request $request)
    {
        $query = Influencer::query();

        if ($request->has('category')) {
            $query->whereJsonContains('categories', $request->category);
        }

        if ($request->has('min_followers')) {
            $query->where('followers_count', '>=', $request->min_followers);
        }

        if ($request->has('min_engagement')) {
            $query->where('engagement_rate', '>=', $request->min_engagement);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $influencers = $query->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $influencers
        ]);
    }
}
