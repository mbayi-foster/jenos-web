<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $platsDb = Plat::all();
        $plats = $platsDb->map(fn($plat) => $plat->toArray());

        return response()->json($plats);
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
            $keyname = 'plats/' . $uniqueId . '_' . $clean_name . $file->getClientOriginalExtension();
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
        return response()->json($plat, 200);
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
                $keyname = 'plats/' . $uniqueId . '_' . $clean_name . $file->getClientOriginalExtension();
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
                    return response()->json([
                        'message' => 'succès',
                    ], 201);
                } catch (S3Exception $e) {
                    return response()->json([
                        'Upload Failed' => $e->getMessage()
                    ], 500);
                }
            } else {
                $plat->nom = $request->nom;
                $plat->prix = $request->prix;
                $plat->details = $request->details;
                $plat->save();
                return response()->json([
                    'message' => 'succès',
                ], 201);
            }
        }
        return response()->json(["une erreur s'est produite"], 500);

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
        return response()->json($plat);
    }


    public function plats_status()
    {
        $plats = Plat::where("status", 1)->get();
        $nouveauPlats = [];
        foreach ($plats as $plat) {
            $nouveauPlats[] = [
                'id' => $plat->id,
                'nom' => $plat->nom
            ];
        }
        return response()->json($nouveauPlats, 200);
    }

    public function search(string $mot, Request $request)
    {
        $request->validate([
            "order" => 'string'
        ]);
        $query = " SELECT * FROM plats WHERE status = true AND nom LIKE '%$mot%' ORDER BY created_at DESC";
        // if ($request->order)
        //     match ($request->order) {
        //         "new" => $query = " SELECT * FROM plats WHERE status = true AND nom LIKE '%$mot%' ORDER BY created_at DESC",
        //         "chers" => $query = " SELECT * FROM plats WHERE status = true AND nom LIKE '%$mot%' ORDER BY prix DESC",
        //         "moins" => $query = " SELECT * FROM plats WHERE status = true AND nom LIKE '%$mot%' ORDER BY prix ASC",
        //     };

        $plats = Plat::where("status", true)->where('nom', 'LIKE', "%$mot%")->get();
        return response()->json($plats);
    }

    public function all(Request $request)
    {
        // $request->validate([
        //     "order" => 'required|string'
        // ]);
        $plats = Plat::where('status', true)->inRandomOrder()->get();
        // match ($request->order) {
        //     "chers"=>$plats = Plat::orderByDesc('prix')->get(),
        //     "moins"=>$plats = Plat::orderBy('prix', 'ASC')->get(),
        //     "new"=>$plats = Plat::where('status', true)->orderBy('created_at', 'desc')->take(5)->get(),
        //     "desirs"=> $plats= Plat::withCount('paniers') // Assurez-vous que la relation 'paniers' est définie dans le modèle Plat
        //     ->orderBy('paniers_count', 'desc')
        //     ->limit(5)
        //     ->get()
        // };
        return response()->json($plats);
    }
}
