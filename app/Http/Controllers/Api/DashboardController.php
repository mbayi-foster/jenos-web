<?php

namespace App\Http\Controllers\Api;

use App\Enum\UserType;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Livreur;
use App\Models\Plat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = User::where('type', UserType::CLIENT)->count();
        $plats = Plat::where('status', true)->count();
        $commandes = Commande::count();
        $livreurs = User::where('type', operator: UserType::LIVREUR)->count();
        $ordersByMonth = DB::select("
    SELECT 
        COUNT(*) as count, 
        MONTHNAME(created_at) as month, 
        YEAR(created_at) as year 
    FROM commandes 
    WHERE created_at IS NOT NULL 
    GROUP BY year, month 
    ORDER BY year ASC, MONTH(created_at) ASC
");

        $statsClients = DB::select("
    SELECT 
        COUNT(*) as count, 
        MONTHNAME(created_at) as month, 
        YEAR(created_at) as year 
    FROM users 
    WHERE created_at IS NOT NULL 
    GROUP BY year, month 
    ORDER BY year ASC, MONTH(created_at) ASC
");

        $data = [
            'users' => $clients,
            'livreurs' => $livreurs,
            'plats' => $plats,
            'commandes' => $commandes,
            'stats' => [
                'commandes' => $ordersByMonth,
                'clients' => $statsClients,
            ],

        ];
        return ApiResponse::success(data: $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function clients()
    {
        $clients = User::where('type', UserType::CLIENT)->get();
        return ApiResponse::success(data: ClientResource::collection($clients));
    }
}
