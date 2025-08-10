<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class TicketController extends Controller
{
    // Functions
    public function CreateTicket(Request $request)
    {
        $messages = $this->GetMessages();
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'priority' => 'required',
        ], $messages);

        $id = $request->user()->id;
        if (!$id) {
            return response([
                'message' => 'No se encontró el usuario indicado',
                'data' => [],
                'error' => true,
            ], 404);
        }
        $ticket = new Ticket();
        $ticket->title = $request->title;
        $ticket->description = $request->description;
        $ticket->user_id = $id;
        $ticket->priority = $request->priority;
        $ticket->save();

        return response([
            'message' => 'Se ha creado el ticket exitosamente',
            'data' => [$ticket],
            'error' => false,
        ], 200);
    }

    public function UpdateTicket(Request $request, $id)
    {
        // Validar si el usuario esta autenticado y si cuenta con los permisos necesarios
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user || !($user->isAdmin() || $user->isSupport())) {
            return response([
                'message' => 'No autorizado para actualizar tickets',
                'data' => [],
                'error' => true,
            ], 403);
        }

        // Procesamos el request
        $messages = $this->GetMessages();
        $request->validate([
            'title' => 'sometimes',
            'description' => 'sometimes',
            'status' => 'sometimes',
            'priority' => 'sometimes',
        ], $messages);

        $ticket = Ticket::find($id);
        if (!$ticket) {
            return response([
                'message' => 'No se encontró el ticket indicado',
                'data' => [],
                'error' => true,
            ], 404);
        }

        $ticket->update($request->all());

        return response([
            'message' => 'Ticket actualizado exitosamente',
            'data' => [],
            'error' => false,
        ], 200);
    }

    public function ToggleEnabled($id)
    {

        // Validar si el usuario esta autenticado y si cuenta con los permisos necesarios
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user || !($user->isAdmin() || $user->isSupport())) {
            return response([
                'message' => 'No autorizado para actualizar tickets',
                'data' => [],
                'error' => true,
            ], 403);
        }
        // Procesamos el request
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return response([
                'message' => 'No se encontró el ticket indicado',
                'data' => [],
                'error' => true,
            ], 404);
        }

        if ($ticket->isEnabled == true) {
            $ticket->isEnabled = false;
        } else {
            $ticket->isEnabled = true;
        }

        $ticket->save();

        return response([
            'message' => 'Ticket ha sido actualizado exitosamente',
            'data' => [],
            'error' => false,
        ], 200);
    }

    public function ChangePriority(Request $request, $id)
    {

        // Validar si el usuario esta autenticado y si cuenta con los permisos necesarios
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user || !($user->isAdmin() || $user->isSupport())) {
            return response([
                'message' => 'No autorizado para actualizar tickets',
                'data' => [],
                'error' => true,
            ], 403);
        }
        // Procesamos el request
        $messages = $this->GetMessages();
        $request->validate([
            'priority' => 'required',
        ], $messages);

        $ticket = Ticket::find($id);
        if (!$ticket) {
            return response([
                'message' => 'No se encontró el ticket indicado',
                'data' => [],
                'error' => true,
            ], 404);
        }

        if ($request->priority == 'low' || $request->priority == 'medium' || $request->priority == 'high') {
            $ticket->priority = $request->priority;
            $ticket->save();
        } else {
            return response([
                'message' => 'Se ingreso una prioridad inválida',
                'data' => [],
                'error' => true,
            ], 422);
        }

        return response([
            'message' => 'Se ha cambiado la prioridad del ticket exitosamente',
            'data' => [],
            'error' => false,
        ], 200);
    }

    public function ChangeStatus(Request $request, $id)
    {
        // Validar si el usuario esta autenticado y si cuenta con los permisos necesarios
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user || !($user->isAdmin() || $user->isSupport())) {
            return response([
                'message' => 'No autorizado para actualizar tickets',
                'data' => [],
                'error' => true,
            ], 403);
        }
        // Procesamos el request
        $messages = $this->GetMessages();
        $request->validate([
            'status' => 'required',
        ], $messages);

        $ticket = Ticket::find($id);
        if (!$ticket) {
            return response([
                'message' => 'No se encontró el ticket indicado',
                'data' => [],
                'error' => true,
            ], 404);
        }

        if ($request->status == 'open' || $request->status == 'in_progress' || $request->status == 'closed') {
            $ticket->status = $request->status;
            $ticket->save();
        } else {
            return response([
                'message' => 'Se ingreso un estado inválido',
                'data' => [],
                'error' => true,
            ], 422);
        }

        return response([
            'message' => 'Se ha cambiado el estado del ticket exitosamente',
            'data' => [],
            'error' => false,
        ], 200);
    }

    // Gets
    public function GetAllTickets()
    {
        // Validar si el usuario esta autenticado y si cuenta con los permisos necesarios
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user || !($user->isAdmin() || $user->isSupport())) {
            return response([
                'message' => 'No autorizado para actualizar tickets',
                'data' => [],
                'error' => true,
            ], 403);
        }

        try {
            $tickets = Ticket::all();
            if ($tickets->isEmpty()) {
                return response([
                    'message' => 'No se encontraron tickets',
                    'data' => [],
                    'error' => false,
                ], 404);
            }
            return response([
                'message' => 'Tickets encontrados exitosamente',
                'data' => [$tickets],
                'error' => false,
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'Hubo un error al intentar obtener los tickets, intente más tarde',
                'data' => ['error' => $e->getMessage()],
                'error' => true,
            ], 500);
        }
    }

    public function GetTicketById($id)
    {
        // Validar si el usuario esta autenticado y si cuenta con los permisos necesarios
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) {
            return response([
                'message' => 'No estas autenticado',
                'data' => [],
                'error' => true,
            ], 403);
        }

        try {
            if ($user->isAdmin() || $user->isSupport()){
                $ticket = Ticket::find($id);
            }else{
                $ticket = Ticket::with('user')->where('id', $id)->where('user_id', $user->id)->first();
            }
            if (!$ticket) {
                return response([
                    'message' => 'No se encontró el ticket indicado',
                    'data' => [],
                    'error' => true,
                ], 404);
            }
            return response([
                'message' => 'Ticket encontrado exitosamente',
                'data' => [$ticket],
                'error' => false,
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'Hubo un error al intentar obtener el ticket, intente más tarde',
                'data' => ['error' => $e->getMessage()],
                'error' => true,
            ], 500);
        }
    }

    public function GetTicketsFromUser($id)
    {
        // Validar si el usuario esta autenticado
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) {
            return response([
                'message' => 'El usuario actual no esta autenticado',
                'data' => [],
                'error' => true,
            ], 403);
        }
        // Realizamos la consulta
        try {
            $tickets = Ticket::where('user_id', $id)->get();
            if (!$tickets) {
                return response([
                    'message' => 'No se encontraron tickets para este usuario',
                    'data' => [],
                    'error' => true,
                ], 404);
            }
            return response([
                'message' => 'Tickets encontrados exitosamente',
                'data' => [$tickets],
                'error' => false,
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'Hubo un error al intentar obtener los tickets, intente más tarde',
                'data' => ['error' => $e->getMessage()],
                'error' => true,
            ], 500);
        }
    }

    public function GetMyTicketById($id)
    {
        // Validar si el usuario esta autenticado
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) {
            return response([
                'message' => 'El usuario actual no esta autenticado',
                'data' => [],
                'error' => true,
            ], 403);
        }
        // Realizamos la consulta
        try {
            $ticket = Ticket::with('user')->where('id', $id)->where('user_id', $user->id)->first();
            if (!$ticket) {
                return response([
                    'message' => 'No se encontró el ticket',
                    'data' => [],
                    'error' => true,
                ], 404);
            }
            return response([
                'message' => 'Ticket encontrado exitosamente',
                'data' => [$ticket],
                'error' => false,
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'Hubo un error al intentar obtener los tickets, intente más tarde',
                'data' => ['error' => $e->getMessage()],
                'error' => true,
            ], 500);
        }
    }

    public function GetMyTickets()
    {
        // Validar si el usuario esta autenticado
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user) {
            return response([
                'message' => 'El usuario actual no esta autenticado',
                'data' => [],
                'error' => true,
            ], 403);
        }
        try {
            $tickets = Ticket::where('user_id', $user->id)->get();
            if ($tickets->isEmpty()) {
                return response([
                    'message' => 'No se encontraron tickets para este usuario',
                    'data' => [],
                    'error' => true,
                ], 404);
            }
            return response([
                'message' => 'Tickets encontrados exitosamente',
                'data' => [$tickets],
                'error' => false,
            ], 200);
        } catch (Exception $e) {
            return response([
                'message' => 'Hubo un error al intentar obtener los tickets, intente más tarde',
                'data' => ['error' => $e->getMessage()],
                'error' => true,
            ], 500);
        }
    }

    public function getTicketStats()
    {
        $total = Ticket::count();

        $pending = Ticket::where('status', 'open')->count();

        $in_progress = Ticket::where('status', 'in_progress')->count();

        $resolved = Ticket::where('status', 'closed')->count();

        return response([
            'message' => 'Tickets encontrados exitosamente',
            'data' => [
                'total' => $total,
                'pending' => $pending,
                'in_progress' => $in_progress,
                'resolved' => $resolved,
            ],
            'error' => false,
        ], 200);
    }

    public function GetMessages()
    {
        return [
            'title.required' => 'El campo título es requerido',
            'description.required' => 'El campo descripción es requerido',
            'status.required' => 'El campo estado es requerido',
            'priority.required' => 'El campo prioridad es requerido',
            'ticket_id.required' => 'El campo ID del ticket es requerido',
            'user_id.required' => 'El campo ID del usuario es requerido',
        ];
    }
}
