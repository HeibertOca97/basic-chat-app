<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\SolicitudeFriendShip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SolicitudController extends Controller
{
    public function index()
    {
        return view('solicitudes');
    }

    public function sendSolicitud(Request $req)
    {
        $req->validate([
            'receptor' => 'required'
        ]);

        SolicitudeFriendShip::create(array(
            'emisor_id' => Auth::user()->id,
            'receptor_id' => $req->receptor,
            'status' => 0
        ));

        return back()->with('success', "Solicitud enviada");
    }

    public function removeSolicitud(Request $req)
    {
        $req->validate([
            'receptor' => 'required'
        ]);

        $solicitud = SolicitudeFriendShip::where("receptor_id", $req->receptor)->first();

        if ($solicitud) {
            $solicitud->delete();
        }

        return back()->with('success', "Solicitud removida");
    }

    public function acepted(Request $req)
    {
        $req->validate([
            'solicitud' => ['required'],
        ]);

        $req = json_decode($req->solicitud);


        Contact::create([
            'user_id' => $req->emisor_id,
            'user2_id' => $req->receptor_id,
        ]);

        Contact::create([
            'user_id' => $req->receptor_id,
            'user2_id' => $req->emisor_id,
        ]);

        $res = SolicitudeFriendShip::find($req->id)->first();

        if ($res) {
            $res->delete();
        }

        return back()->with('success', "Solicitud aceptada");
    }

    public function canceled(Request $req)
    {
        $req->validate([
            'solicitud' => ['required'],
        ]);

        $req = json_decode($req->solicitud);

        $res = SolicitudeFriendShip::find($req->id)->first();

        if ($res) {
            $res->delete();
        }

        return back()->with('success', "Solicitud cancelada");
    }
}
