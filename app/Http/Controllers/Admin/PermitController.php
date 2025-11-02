<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePermitRequest;
use App\Http\Requests\UpdatePermitRequest;
use App\Models\Client;
use App\Models\GNDivision;
use App\Models\Permit;
use Illuminate\Http\Request;

class PermitController extends Controller
{
    public function index()
    {
        $permits = Permit::with(['client', 'gnDivision'])->latest()->get();
        return view('admin.permits.index', compact('permits'));
    }

    public function create()
    {
        $clients = Client::all();
        $gn_divisions = GNDivision::all();
        return view('admin.permits.create', compact('clients', 'gn_divisions'));
    }

    public function store(CreatePermitRequest $request)
    {
        try {
            $data = $request->validated();

            $permit = Permit::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Permit created successfully!',
                'menu' => $permit,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create permit. Please try again.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $permit = Permit::with(['client', 'gnDivision'])->find($id);

            return response()->json([
                'success' => true,
                'data' => $permit
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Permit not found.'
            ], 404);
        }
    }

    public function edit(string $id)
    {
        $permit = Permit::with(['client', 'gnDivision'])->findOrFail($id);
        $clients = Client::all();
        $gn_divisions = GNDivision::all();

        return view('admin.permits.edit', compact('permit', 'clients', 'gn_divisions'));
    }

    public function update(UpdatePermitRequest $request, string $id)
    {
        try {
            $permit = Permit::with(['client', 'gnDivision'])->findOrFail($id);

            $data = $request->validated();

            $permit->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Permit updated successfully!',
                'data' => $permit,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update permit. Please try again.',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $permit = Permit::findOrFail($id);
            $permit->delete();

            return response(['status' => 'success', 'message' => 'Permit deleted successfully']);
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => $th->getMessage()]);
        }
    }
}
