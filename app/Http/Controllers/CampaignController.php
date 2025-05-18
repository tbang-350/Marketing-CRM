<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Influencer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::with(['client', 'influencers'])
            ->latest()
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $campaigns
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'budget' => 'required|numeric|min:0',
            'status' => 'required|in:planning,active,completed,cancelled',
            'campaign_type' => 'required|string|max:100',
            'objectives' => 'nullable|array',
            'target_audience' => 'nullable|array',
            'influencers' => 'nullable|array',
            'influencers.*.id' => 'required|exists:influencers,id',
            'influencers.*.contract_amount' => 'required|numeric|min:0',
            'influencers.*.start_date' => 'required|date',
            'influencers.*.end_date' => 'required|date|after:influencers.*.start_date',
            'influencers.*.deliverables' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $campaign = Campaign::create($request->except('influencers'));

            if ($request->has('influencers')) {
                foreach ($request->influencers as $influencer) {
                    $campaign->influencers()->attach($influencer['id'], [
                        'contract_amount' => $influencer['contract_amount'],
                        'start_date' => $influencer['start_date'],
                        'end_date' => $influencer['end_date'],
                        'deliverables' => $influencer['deliverables'] ?? null,
                        'status' => 'pending'
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Campaign created successfully',
                'data' => $campaign->load('influencers')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create campaign',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Campaign $campaign)
    {
        $campaign->load(['client', 'influencers', 'tasks']);

        return response()->json([
            'status' => 'success',
            'data' => $campaign
        ]);
    }

    public function update(Request $request, Campaign $campaign)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after:start_date',
            'budget' => 'sometimes|required|numeric|min:0',
            'status' => 'sometimes|required|in:planning,active,completed,cancelled',
            'campaign_type' => 'sometimes|required|string|max:100',
            'objectives' => 'nullable|array',
            'target_audience' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $campaign->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Campaign updated successfully',
            'data' => $campaign
        ]);
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Campaign deleted successfully'
        ]);
    }

    public function addInfluencer(Request $request, Campaign $campaign)
    {
        $validator = Validator::make($request->all(), [
            'influencer_id' => 'required|exists:influencers,id',
            'contract_amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'deliverables' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $campaign->influencers()->attach($request->influencer_id, [
            'contract_amount' => $request->contract_amount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'deliverables' => $request->deliverables,
            'status' => 'pending'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Influencer added to campaign successfully'
        ]);
    }

    public function removeInfluencer(Campaign $campaign, Influencer $influencer)
    {
        $campaign->influencers()->detach($influencer->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Influencer removed from campaign successfully'
        ]);
    }

    public function updateInfluencerStatus(Request $request, Campaign $campaign, Influencer $influencer)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,active,completed,cancelled',
            'performance_metrics' => 'nullable|array',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $campaign->influencers()->updateExistingPivot($influencer->id, [
            'status' => $request->status,
            'performance_metrics' => $request->performance_metrics,
            'notes' => $request->notes
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Influencer status updated successfully'
        ]);
    }

    public function getCampaignStats(Campaign $campaign)
    {
        $stats = [
            'total_influencers' => $campaign->influencers()->count(),
            'active_influencers' => $campaign->influencers()->wherePivot('status', 'active')->count(),
            'total_contract_value' => $campaign->influencers()->sum('contract_amount'),
            'completion_rate' => $this->calculateCompletionRate($campaign),
            'engagement_metrics' => $this->getEngagementMetrics($campaign)
        ];

        return response()->json([
            'status' => 'success',
            'data' => $stats
        ]);
    }

    private function calculateCompletionRate(Campaign $campaign)
    {
        $total = $campaign->influencers()->count();
        if ($total === 0) return 0;

        $completed = $campaign->influencers()->wherePivot('status', 'completed')->count();
        return ($completed / $total) * 100;
    }

    private function getEngagementMetrics(Campaign $campaign)
    {
        return $campaign->influencers()
            ->wherePivot('status', 'completed')
            ->get()
            ->map(function ($influencer) {
                return [
                    'influencer_id' => $influencer->id,
                    'name' => $influencer->name,
                    'metrics' => $influencer->pivot->performance_metrics
                ];
            });
    }
}
