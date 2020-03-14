<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App;

class TicketController extends Controller
{
    function __construct(){
    }

    public function update(Request $request, $id)
    {
        $check = App\TicketModel::find($id);

        if(!empty($check)){
            $data = $request->json()->all();
            $data["updated_at"] = date('Y-m-d H:i:s');
            // $check->update(['titolo' => "tiiii"]);
            DB::table('ticket')->where('id', $id)->update($data);
            return response()->json([
                'Modificato'
            ]);
        }else{
            return response()->json([
                'Id non esiste'
            ]);
        }
    }

    public function add(Request $request)
    {
        // $data = $request->json()->all();
        
        $utenteLogged = Auth::user()->dataUtente();
        
        // return response()->json([
        //     $data
        // ]);

        $validateData = $this->validate($request,[
            'titolo' => 'required|max:20',
            'descrizione' => 'required|max:200',
            'applicativo' => 'max:20',
            'segnalatoDa' => 'required|max:20',
            'segnalatoData' => 'required|date_format:Y-m-d H:i:s',
            'inseritoData' => 'required|date_format:Y-m-d H:i:s',
            'priorita' => 'required|max:2'
        ]);

        if(isset($validateData["errors"])){
            return response()->json([
                $validateData
            ]);
        }else{
            
            DB::table('ticket')->insert(
                [
                    'titolo' => $validateData['titolo'],
                    'descrizione' => $validateData['descrizione'],
                    'applicativo' => $validateData['applicativo'],
                    'segnalatoDa' => $validateData['segnalatoDa'],
                    'segnalatoData' => $validateData['segnalatoData'],
                    'inseritoDa' => $utenteLogged->id,
                    'inseritoData' => $validateData['inseritoData'],
                    'priorita' => $validateData['priorita'],
                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );
            return response()->json([
                'Inserito'
            ]);
        }
    }

    public function getAll(Request $request)
    {
        $results = App\TicketModel::all();
        return $results;
        // $data = $request->json()->all();
    }

    public function getSingolo(Request $request, $id)
    {
        $result = App\TicketModel::find($id);
        if(!empty($result)){
            return $result;
        }else{
            return "ID non esiste";
        }
        return $result;
    }

    public function delete(Request $request, $id)
    {
        $result = App\TicketModel::find($id);

        if(!empty($result)){
            $result->delete();
            return response()->json([
                'Eliminato'
            ]);
        }else{
            return response()->json([
                'Id inesistente'
            ]);
        }
    }

    public function getFiltred($idUtente = null)
    {
        // ? di certo bisognerà sapere chi è l'utente
        if($idUtente == null){
            $utenteLogged = Auth::user()->dataUtente();
        }else{
            $utenteLogged = new \stdClass;
            $utenteLogged->id = $idUtente;
        }

        $assegnazioni = App\AssegnaTicketModel::where('idUtente_a', $utenteLogged->id)
            ->get();

        $assoc_utente = [];

        foreach($assegnazioni as $singolaAss){
            $idTicket = $singolaAss->idTicket;

            $singolaAss->idUtente_a = App\User::find($singolaAss->idUtente_a)->name;
            $singolaAss->idUtente_da = App\User::find($singolaAss->idUtente_da)->name;

            $ticket = App\TicketModel::find($idTicket);
            
            if($ticket->status == '1'){
                $ticket->associazione = [$singolaAss];
                $assoc_utente[] = $ticket;
            }
        }
        return $assoc_utente;

        // $ticket = App\TicketModel::where('status', 1)
        //     ->orderBy('priorita', 'DESC')
        //     // ->take(1)
        //     ->get();
    }

    public function getFiltredAdmin()
    {
        $ticket = App\TicketModel::all();
        
        $obj = [];
        
        foreach($ticket as $singolo){
            $idTicket = $singolo->id;
            $assATicket = App\AssegnaTicketModel::where('idTicket', $idTicket)->get();

            foreach($assATicket as $sing){
                $sing->idUtente_a = App\User::find($sing->idUtente_a)->name;
                $sing->idUtente_da = App\User::find($sing->idUtente_da)->name;
            }

            $singolo->associazione = $assATicket;

            $obj[] = $singolo;
        }

        return $obj;
    }

    //  TODO VEDERE I RISOLTI [ADMIN] 
    // ? Nuova tabella con risolti da chi e quando

    public function getResolved()
    {
        // ! admin deve avere la possibilità di vederli tutti
        // ! utente deve vedere i suoi

        $ticket = App\TicketModel::where('status', 0)
            ->orderBy('priorita', 'DESC')
            ->get();
        return $ticket;
    }
}