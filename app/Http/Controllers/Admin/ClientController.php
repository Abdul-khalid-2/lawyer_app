<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::with(['user', 'lawyer.user'])
            ->withCount('cases')
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
            ->paginate(15)
            ->withQueryString();

        return view('dashboard.admin.clients.index', compact('clients'));
    }

    public function show(Client $client)
    {
        $client->load(['user', 'lawyer.user', 'cases' => fn ($q) => $q->latest()]);

        return view('dashboard.admin.clients.show', compact('client'));
    }
}
