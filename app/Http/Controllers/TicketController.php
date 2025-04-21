<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    // Functions
    public function CreateTicket(Request $request)
    {
        $messages = $this->GetMessages();
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'priority' => 'required',
        ], $messages);

        $ticket = new Ticket();
        $ticket->title = $request->title;
        $ticket->description = $request->description;
        $ticket->status = $request->status;
        $ticket->priority = $request->priority;
        $ticket->save();

        return response([
            'message' => 'Se ha creado el ticket exitosamente',
            'data' => [$ticket],
            'error' => false,
        ],200);
    }

    public function UpdateTicket($id, Request $request)
    {
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return response([
                'message' => 'No se encontró el ticket indicado',
                'data' => [],
                'error' => true,
            ],404);
        }

        $messages = $this->GetMessages();
        $request->validate([
            'title' => 'sometimes',
            'description' => 'sometimes',
            'status' => 'sometimes',
            'priority' => 'sometimes',
        ], $messages);

        $ticket->update($request->all());
        
        return response([
            'message' => 'Ticket actualizado exitosamente',
            'data' => [],
            'error' => false,
        ],200);
    }

    public function DisableTicket($id){
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return response([
                'message' => 'No se encontró el ticket indicado',
                'data' => [],
                'error' => true,
            ],404);
        }

        $ticket->isEnabled = false;
        $ticket->save();
        return response([
            'message' => 'Ticket deshabilitado exitosamente',
            'data' => [],
            'error' => false,
        ],200);
    }

    public function EnableTicket($id){
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return response([
                'message' => 'No se encontró el ticket indicado',
                'data' => [],
                'error' => true,
            ],404);
        }

        $ticket->isEnabled = true;
        $ticket->save();

        return response([
            'message' => 'Ticket deshabilitado exitosamente',
            'data' => [],
            'error' => false,
        ],200);
    }
    
    // Gets
    public function GetAllTickets()
    {
        try {
            $tickets = Ticket::all();
            if ($tickets->isEmpty()){
                return response([
                    'message' => 'No se encontraron tickets',
                    'data' => [],
                    'error' => false,
                ],404);
            }
            return response([
                'message' => 'Tickets encontrados exitosamente',
                'data' => [$tickets],
                'error' => false,
            ],200);
        } catch (Exception $e){
            return response([
                'message' => 'Hubo un error al intentar obtener los tickets, intente más tarde',
                'data' => ['error' => $e->getMessage()],
                'error' => true,
            ],500);
        }
    }
    
    public function GetTicketById($id)
    {
        try {
            $ticket = Ticket::find($id);
            if (!$ticket){
                return response([
                    'message' => 'No se encontró el ticket indicado',
                    'data' => [],
                    'error' => true,
                ],404);
            }
            return response([
                'message' => 'Ticket encontrado exitosamente',
                'data' => [$ticket],
                'error' => false,
            ],200);
        } catch (Exception $e){
            return response([
                'message' => 'Hubo un error al intentar obtener el ticket, intente más tarde',
                'data' => ['error' => $e->getMessage()],
                'error' => true,
            ],500);
        }
    }

    public function GetMessages(){
        return [
            'title.required' => 'El campo título es requerido',
            'description.required' => 'El campo descripción es requerido',
            'status.required' => 'El campo estado es requerido',
            'priority.required' => 'El campo prioridad es requerido',
        ];
    }
}
