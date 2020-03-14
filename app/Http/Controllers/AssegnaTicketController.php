<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App;

class AssegnaTicketController extends Controller
{
    function __construct(){
    }

    public function update(Request $request, $id)
    {
        $check = App\AssegnaTicketModel::find($id);

        if(count($check) > 0){
            $data = $request->json()->all();
            $data["updated_at"] = date('Y-m-d H:i:s');
            DB::table('assegnaTicket')->where('id', $id)->update($data);
            return response()->json([
                'Modificato'
            ]);
        }else{
            return "ID non esiste";
        }
    }

    public function add(Request $request)
    {
        // $data = $request->json()->all();


        $validateData = $this->validate($request,[
            'idUtente_a' => 'required|max:20',
            'idUtente_da' => 'required|max:20',
            'assegnato_il' => 'required|date_format:Y-m-d H:i:s',
            'idTicket' => 'required|max:20'

        ]);
        
        $validateData['notExist'] = [];

        if(empty(App\User::find($validateData['idUtente_a']))){
            $validateData['notExist'][] = 'idUtente_a';
        }

        if(empty(App\User::find($validateData['idUtente_da']))){
            $validateData['notExist'][] = 'idUtente_da';
        }

        if(empty(App\TicketModel::find($validateData['idTicket']))){
            $validateData['notExist'][] = 'idTicket';
        }

        if(isset($validateData["errors"]) || count($validateData['notExist']) > 0){
            $msg = [];
            $msg['errors'] = (isset($validateData["errors"]) ? $validateData["errors"] : null);
            $msg['notExist'] = (isset($validateData["notExist"]) ? $validateData["notExist"] : null);

            return response()->json([
                $msg
            ]);
        }else{
            DB::table('assegnaTicket')->insert(
                [
                    'idUtente_a' => $validateData['idUtente_a'],
                    'idUtente_da' => $validateData['idUtente_da'],
                    'assegnato_il' => $validateData['assegnato_il'],
                    'idTicket' => $validateData['idTicket'],
                    'created_at' => date('Y-m-d H:i:s')
                ]
            );
            return response()->json([
                'Creato'
            ]);
        }
    }

    public function getAll(Request $request)
    {
        $results = App\AssegnaTicketModel::all();
        return $results;
        // $data = $request->json()->all();
    }

    public function getSingolo(Request $request, $id)
    {
        $result = App\AssegnaTicketModel::find($id);
        if(!empty($result)){
            return $result;
        }else{
            return response()->json([
                'Id non esiste'
            ]);
        }
        return $result;
    }

    public function delete(Request $request, $id)
    {
        $result = App\AssegnaTicketModel::find($id);

        if(!empty($result)){
            $result->delete();
            return response()->json([
                'Eliminato'
            ]);
        }else{
            return response()->json([
                'Id non esiste'
            ]);
        }
    }
}