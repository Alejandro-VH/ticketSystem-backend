<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;
use App\Models\TicketResponse;

class TicketResponseController extends Controller
{
    public function CreateResponse(Request $request, $id){
        $messages = $this->GetMessages();
        $request->validate([
            'message' => 'required|string|min:10|max:500',
        ], $messages); 

        $checkTicket = Ticket::find($id);
        if (!$checkTicket) {
            return response([
                'message' => 'No se encontró el ticket indicado',
                'data' => [],
                'error' => true,
            ],404);
        }

        $checkUser = $request->user()->id;
        if (!$checkUser){
            return response([
                'message' => 'No se encontró el usuario indicado',
                'data' => [],
                'error' => true,
            ],404);
        }

        $ticket = new TicketResponse();
        $ticket->ticket_id = $request->ticket_id;
        $ticket->user_id = $checkUser;
        $ticket->message = $request->message;
        
        if ($request->user()->hasRole('Soporte') || $request->user()->hasRole('Administrador')){
            $ticket->is_support = true;
        }else{
            $ticket->is_support = false;
        }

        $ticket->save();

        return response([
            'message' => 'Se ha creado la respuesta exitosamente',
            'data' => [],
            'error' => false,
        ],200);
    }

    public function getResponse($id){
        $ticket = TicketResponse::where('ticket_id', $id)->get();
        if ($ticket->isEmpty()) {
            return response([
                'message' => 'No se encontraron respuestas para el ticket indicado',
                'data' => [],
                'error' => true,
            ],404);
        }

        return response([
            'message' => 'Se han encontrado las respuestas exitosamente',
            'data' => $ticket,
            'error' => false,
        ],200);
    }

    public function GetMessages(){
        return [
            'ticket_id.required' => 'Debe ingresar el ID del ticket',
            'user_id.required' => 'Debe ingresar el ID del usuario',
            'message.required' => 'Debe ingresar una respuesta',
        ];
    }
}
