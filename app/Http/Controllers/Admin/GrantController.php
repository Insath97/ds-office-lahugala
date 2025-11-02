<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateGrantRequest;
use App\Http\Requests\UpdateGrantRequest;
use App\Models\Client;
use App\Models\GNDivision;
use App\Models\Grant;
use Illuminate\Http\Request;

class GrantController extends Controller
{
    public function index()
    {
        $grants = Grant::with(['client', 'gnDivision'])->latest()->get();
        return view('admin.grants.index', compact('grants'));
    }

    public function create()
    {
        $clients = Client::all();
        $gn_divisions = GNDivision::all();
        return view('admin.grants.create', compact('clients', 'gn_divisions'));
    }

    public function store(CreateGrantRequest $request)
    {
        try {
            $data = $request->validated();

            $grant = Grant::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Grant created successfully!',
                'data' => $grant,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create grant. Please try again.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $grant = Grant::with(['client', 'gnDivision'])->find($id);

            return response()->json([
                'success' => true,
                'data' => $grant
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Grant not found.'
            ], 404);
        }
    }

    public function edit(string $id)
    {
        $grant = Grant::with(['client', 'gnDivision'])->findOrFail($id);
        $clients = Client::all();
        $gn_divisions = GNDivision::all();

        return view('admin.grants.edit', compact('grant', 'clients', 'gn_divisions'));
    }

    public function update(UpdateGrantRequest $request, string $id)
    {
        try {
            $grant = Grant::with(['client', 'gnDivision'])->findOrFail($id);

            $data = $request->validated();

            $grant->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Grant updated successfully!',
                'data' => $grant,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update grant. Please try again.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $grant = Grant::findOrFail($id);
            $grant->delete();

            return response(['status' => 'success', 'message' => 'Grant deleted successfully']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}
