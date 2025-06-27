<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use Illuminate\Http\Request;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menu = Menu::all();
        return ApiResponse::success(data: MenuResource::collection($menu), code: 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nom" => "required",
            "plats" => "required",
            "photo" => "required|image"
        ]);

        if ($request->file('photo')) {
            $file = $request->file('photo');
            $clean_name = strtolower($request->nom);
            $clean_name = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $clean_name); // Remplace les caractères spéciaux
            $clean_name = str_replace(' ', '_', $clean_name); // Remplace les espaces par des underscores
            $uniqueId = uniqid();
            $keyname = 'menus/' . $uniqueId . '_' . $clean_name . '.' . $file->getClientOriginalExtension();


            $s3 = new S3Client([
                'version' => 'latest',
                'region' => env('AWS_DEFAULT_REGION'),
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            try {
                $result = $s3->putObject([
                    'Bucket' => env('AWS_BUCKET'),
                    'Key' => $keyname,
                    'Body' => fopen($file, 'r'),
                    // 'ACL' => 'public-read'  
                ]);
                $menu = Menu::create([
                    "nom" => $request->nom,
                    "photo" => $result['ObjectURL']
                ]);
                $platIds = explode(',', $request->plats);
                $menu->plats()->attach($platIds);
                return response()->json([
                    'message' => 'succès',
                ], 201);
            } catch (S3Exception $e) {
                return response()->json([
                    'Upload Failed' => $e->getMessage()
                ], 500);
            }
        }

        return response()->json(['error' => "Une erreur s'est produite veillez réessayer"], status: 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
        $menu = Menu::findOrFail($id);
        if ($menu) {
            $menu->delete();
            return response()->json(true, 200);
        }
        return response()->json(false, 400);
    }


    public function change_status(string $id)
    {
        $menu = Menu::find($id);
        $menu->status = ($menu->status == true) ? false : true;
        $menu->save();
        return response()->json(true, 200);
    }

}
