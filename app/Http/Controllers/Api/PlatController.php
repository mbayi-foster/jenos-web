<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlatResource;
use App\Models\Plat;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
use Illuminate\Http\Request;

class PlatController extends Controller
{
    private $url;

    public function __construct()
    {
        $this->url = env("APP_URL");
    }
    /**
     * Display a listing of the resource.
     * Recuperer tous les plats
     */
    public function index()
    {
        $plats = Plat::all();
        return ApiResponse::success(PlatResource::collection($plats));
    }

    /**
     * Store a newly created resource in storage.
     * Creer un plat
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prix' => 'required|numeric',
            'details' => 'required',
            'photo' => 'required|image',
        ]);

        if ($request->file('photo')) {
            $file = $request->file('photo');
            $clean_name = strtolower($request->nom);
            $clean_name = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $clean_name); // Remplace les caractères spéciaux
            $clean_name = str_replace(' ', '_', $clean_name); // Remplace les espaces par des underscores
            $uniqueId = uniqid();
            $keyname = 'plats/' . $uniqueId . '_' . $clean_name . '.' . $file->getClientOriginalExtension();
            // $keyname = 'plats/' . $file->getClientOriginalName();
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
                Plat::create([
                    "nom" => $request->nom,
                    "prix" => $request->prix,
                    "photo" => $result['ObjectURL'],
                    "details" => $request->details
                ]);
                return response()->json([
                    'message' => 'succès',
                ], 201);
            } catch (S3Exception $e) {
                return response()->json([
                    'Upload Failed' => $e->getMessage()
                ], 500);
            }
        }
        return response()->json([
            'error' => "échec"
        ], 500);
    }

    /**
     * Display the specified resource.
     * Recuperer un plat par son id
     */
    public function show(string $id)
    {
        $plat = Plat::find($id);
        return ApiResponse::success(data: new PlatResource($plat));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nom' => 'required',
            'prix' => 'required|numeric',
            'details' => 'required',
            'photo' => 'image'
        ]);
        $plat = Plat::find($id);
        if ($plat) {
            if ($request->file('photo')) {
                $file = $request->file('photo');
                $clean_name = strtolower($request->nom);
                $clean_name = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $clean_name); // Remplace les caractères spéciaux
                $clean_name = str_replace(' ', '_', $clean_name); // Remplace les espaces par des underscores
                $uniqueId = uniqid();
                $keyname = 'plats/' . $uniqueId . '_' . $clean_name . '.' . $file->getClientOriginalExtension();
                // $keyname = 'plats/' . $file->getClientOriginalName();
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
                    $plat->nom = $request->nom;
                    $plat->prix = $request->prix;
                    $plat->photo = $result['ObjectURL'];
                    $plat->details = $request->details;
                    $plat->save();
                    // return response()->json([
                    //     'message' => 'succès',
                    // ], 201);
                    return ApiResponse::success(data: new PlatResource($plat), code: 201);
                } catch (S3Exception $e) {
                    return ApiResponse::error(message: $e->getMessage(), code: 500);

                }
            } else {
                $plat->nom = $request->nom;
                $plat->prix = $request->prix;
                $plat->details = $request->details;
                $plat->save();
                return ApiResponse::success(data: new PlatResource($plat));
            }
        }
        return ApiResponse::error();

    }

    /**
     * Remove the specified resource from storage.
     * Supprimer le plat
     */
    public function destroy(string $id)
    {
        $plat = Plat::findOrFail($id);
        if ($plat) {
            $plat->delete();
            return response()->json(true, 200);
        }

        return response()->json(["error" => "non trouvé"], 400);
    }

    /* changement du status du plat */
    public function change_status(string $id)
    {
        $plat = Plat::find($id);

        $plat->status = $plat->status == true ? false : true;
        $plat->save();
        return ApiResponse::success(new PlatResource($plat));
    }


    public function plats_status()
    {
        $plats = Plat::where("status", true)->get();
        $nouveauPlats = [];
        foreach ($plats as $plat) {
            $nouveauPlats[] = [
                'id' => $plat->id,
                'nom' => $plat->nom
            ];
        }
        return ApiResponse::success($nouveauPlats);
    }

    public function search(string $mot, Request $request)
    {
        // $request->validate([
        //     "order" => 'string'
        // ]);
        $plats = Plat::where("status", true)->where('nom', 'LIKE', "%$mot%")->get();
        return ApiResponse::success(PlatResource::collection($plats));
    }

    public function all(Request $request)
    {
        $plats = Plat::where('status', true)->inRandomOrder()->get();
        return ApiResponse::success(PlatResource::collection($plats));
    }
}
