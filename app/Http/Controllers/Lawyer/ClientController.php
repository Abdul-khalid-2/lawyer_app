<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $lawyer = Auth::user()->lawyer;

        $clients = Client::with('user')
            ->where('lawyer_id', $lawyer->id)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('phone', 'like', "%{$search}%")
                        ->orWhere('cnic', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($uq) use ($search) {
                            $uq->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('dashboard.clients.create');
    }

    public function store(StoreClientRequest $request)
    {
        $validated = $request->validated();

        $lawyer = Auth::user()->lawyer;

        DB::transaction(function () use ($validated, $request, $lawyer) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'client',
                'is_active' => true,
            ]);
            $user->assignRole('client');

            Client::create([
                'user_id' => $user->id,
                'lawyer_id' => $lawyer->id,
                'phone' => $validated['phone'] ?? null,
                'cnic' => $validated['cnic'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'is_active' => $request->boolean('is_active', true),
            ]);
        });

        return redirect()->route('clients.index')
            ->with('success', 'Client created successfully! They can now log in with the email and password you set.');
    }

    public function show(Client $client)
    {
        $this->authorizeOwnership($client);

        $client->load(['user', 'cases.hearings' => function ($q) {
            $q->orderBy('hearing_date', 'desc');
        }]);

        return view('dashboard.clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        $this->authorizeOwnership($client);

        return view('dashboard.clients.edit', compact('client'));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $this->authorizeOwnership($client);

        $validated = $request->validated();

        DB::transaction(function () use ($validated, $request, $client) {
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];
            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }
            $client->user->update($userData);

            $client->update([
                'phone' => $validated['phone'] ?? null,
                'cnic' => $validated['cnic'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'is_active' => $request->boolean('is_active'),
            ]);
        });

        return redirect()->route('clients.index')
            ->with('success', 'Client updated successfully!');
    }

    public function destroy(Client $client)
    {
        $this->authorizeOwnership($client);

        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client removed successfully!');
    }

    private function authorizeOwnership(Client $client): void
    {
        \Illuminate\Support\Facades\Gate::authorize('manage', $client);
    }
}
