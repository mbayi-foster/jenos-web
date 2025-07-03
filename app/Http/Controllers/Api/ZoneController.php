<?php

namespace App\Http\Controllers\Api;

use App\Enum\Roles;
use App\Enum\UserType;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ZoneResource;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zones = Zone::all();
        return ApiResponse::success(data: ZoneResource::collection($zones));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nom" => "required",
            "gerant" => "required",
        ]);
        $zones = Zone::create(
            [
                "nom" => $request->nom,
                "user_id" => $request->gerant,
                "status" => true
            ]
        );

        return ApiResponse::success(data: new ZoneResource($zones));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $zone = Zone::find($id);
        return response()->json([
            "id" => $zone->id,
            "nom" => $zone->nom,
            "chef" => $zone->chef,
            "status" => $zone->status,
        ]);
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
        $zone = Zone::find($id);
        if ($zone) {
            $zone->delete();
            return response()->json(true, 200);
        }
        return response()->json(false, 404);
    }

    public function change_status(string $id)
    {
        $zone = Zone::find($id);

        $zone->status = $zone->status == true ? false : true;
        $zone->save();
        return ApiResponse::success();
    }

    public function zone_by_id(string $id)
    {
        $zonesDb = Zone::where('chef', $id)->get();
        $zones = $zonesDb->map(
            fn($zone) =>
            [
                'id' => $zone->id,
                'nom' => $zone->nom
            ]
        );

        return response()->json($zones, 200);
    }

    public function gerants()
    {
        $users = User::where('type', UserType::ADMIN)
            ->with('roles')
            ->get()
            ->filter(callback: function ($user) {
                return $user->roles->contains('nom', Roles::GERANT);
            });
        $gerants = [];
        foreach ($users as $user) {
            $gerants[] = [
                'id' => $user->id,
                'nom' => $user->profile->prenom . " " . $user->profile->nom,
            ];
        }
        return ApiResponse::success($gerants);
    }
}
