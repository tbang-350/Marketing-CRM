<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with(['campaigns' => function($query) {
            $query->where('status', 'active');
        }])->latest()->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $clients
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'email' => 'required|email|unique:clients',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,inactive,prospect'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $client = Client::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Client created successfully',
            'data' => $client
        ], 201);
    }

    public function show(Client $client)
    {
        $client->load(['campaigns', 'invoices']);

        return response()->json([
            'status' => 'success',
            'data' => $client
        ]);
    }

    public function update(Request $request, Client $client)
    {
        $validator = Validator::make($request->all(), [
            'company_name' => 'sometimes|required|string|max:255',
            'contact_person' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:clients,email,' . $client->id,
            'phone' => 'sometimes|required|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'sometimes|required|string|max:100',
            'notes' => 'nullable|string',
            'status' => 'sometimes|required|in:active,inactive,prospect'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $client->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Client updated successfully',
            'data' => $client
        ]);
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Client deleted successfully'
        ]);
    }

    public function getClientStats(Client $client)
    {
        $stats = [
            'total_campaigns' => $client->campaigns()->count(),
            'active_campaigns' => $client->campaigns()->where('status', 'active')->count(),
            'total_spent' => $client->campaigns()->sum('budget'),
            'total_invoices' => $client->invoices()->count(),
            'pending_invoices' => $client->invoices()->where('status', 'pending')->count(),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $stats
        ]);
    }
}
