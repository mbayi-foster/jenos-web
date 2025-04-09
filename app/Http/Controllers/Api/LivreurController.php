<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\WebMail;
use App\Models\Livreur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LivreurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $livreursDb = Livreur::all();
        $livreurs = $livreursDb->map(fn($livreur) => $livreur->toArray());

        return response()->json($livreurs->toArray(), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:livreurs|max:255',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'phone' => 'required|numeric|digits_between:9,15', // Exemple de validation
        ]);

        $livreur = Livreur::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'password' => bcrypt('123456'),
            'phone' => $validated['phone']
        ]);

        if ($livreur) {
            $livreur->roles()->attach($validated['roles']);
            $data = [
                'nom' => $livreur->nom,
                'prenom' => $livreur->prenom,
                'phone' => $livreur->phone,
                "email" => $livreur->email,
                "password" => "123456",
                'sujet' => "Confirmatiom du compte"
            ];
            //  SendEmailJob::dispatch($livreur->email, $data);
            Mail::to($livreur->email)->send(new WebMail($data));
            return response()->json(true, 200);
        } else {
            return response()->json(false, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $livreur = Livreur::findOrFail($id);
        if ($livreur) {
            $livreur->delete();

            return response()->json(true, 200);
        }

        return response()->json(["error" => "non trouvé"], 400);
    }

    public function change_status(string $id)
    {
        $livreur = Livreur::find($id);

        $livreur->status = ($livreur->status == true) ? false : true;

        $livreur->save();
        return response()->json($livreur);
    }
}
