<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\InfluencerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Client Routes
Route::get('/clients', [ClientController::class, 'index']);
Route::post('/clients', [ClientController::class, 'store']);
Route::get('/clients/{client}', [ClientController::class, 'show']);
Route::put('/clients/{client}', [ClientController::class, 'update']);
Route::delete('/clients/{client}', [ClientController::class, 'destroy']);
Route::get('/clients/{client}/stats', [ClientController::class, 'getClientStats']);

// Campaign Routes
Route::get('/campaigns', [CampaignController::class, 'index']);
Route::post('/campaigns', [CampaignController::class, 'store']);
Route::get('/campaigns/{campaign}', [CampaignController::class, 'show']);
Route::put('/campaigns/{campaign}', [CampaignController::class, 'update']);
Route::delete('/campaigns/{campaign}', [CampaignController::class, 'destroy']);
Route::post('/campaigns/{campaign}/influencers', [CampaignController::class, 'addInfluencer']);
Route::delete('/campaigns/{campaign}/influencers/{influencer}', [CampaignController::class, 'removeInfluencer']);
Route::put('/campaigns/{campaign}/influencers/{influencer}/status', [CampaignController::class, 'updateInfluencerStatus']);
Route::get('/campaigns/{campaign}/stats', [CampaignController::class, 'getCampaignStats']);

// Influencer Routes
Route::get('/influencers', [InfluencerController::class, 'index']);
Route::post('/influencers', [InfluencerController::class, 'store']);
Route::get('/influencers/{influencer}', [InfluencerController::class, 'show']);
Route::put('/influencers/{influencer}', [InfluencerController::class, 'update']);
Route::delete('/influencers/{influencer}', [InfluencerController::class, 'destroy']);
Route::get('/influencers/{influencer}/stats', [InfluencerController::class, 'getInfluencerStats']);
Route::get('/influencers/search', [InfluencerController::class, 'search']);
