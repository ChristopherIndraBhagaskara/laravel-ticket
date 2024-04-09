<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TicketResource::collection(
            Ticket::query()->orderBy('id', 'desc')->get()
        );
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
    public function store(StoreTicketRequest $request)
    {
        $ticket = new Ticket();
        $ticket->number = $this->getCode();
        $ticket->title = $request->title;
        $ticket->type = $request->type;
        $ticket->assigned_to = $request->assigned_to;
        $ticket->description = $request->description;
        $ticket->label = $request->label;
        $ticket->project = $request->project;
        $ticket->order = $this->getOrder($request->label);

        if($ticket->save())
        {
            return (new TicketResource($ticket))
                ->response()
                ->setStatusCode(201);
        }

        return response()->json(
            ['message' => 'Terjadi masaalah dalam menyimpan tiket'
        ], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        // Update Label

        // $ticket->title = $request->title;
        // $ticket->type = $request->type;
        // $ticket->assigned_to = $request->assigned_to;
        // $ticket->description = $request->description;
        $ticket->label = $request->label;
        // $ticket->project = $request->project;
        $ticket->order = $request->order;

        if($ticket->save())
        {
            return (new TicketResource($ticket))
                ->response()
                ->setStatusCode(201);
        }

        return response()->json([
            'message' => 'Terjadi masaalah dalam meng-update tiket'
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return response("", 204);
    }

    public function reorder($label, $order)
    {
        $label = 'TO DO';
        $order = '2';

        $tickets = Ticket::where('label', $label)
            ->where('order', '>', $order)
            ->orderBy('order', 'asc')
            ->get();

        if(count($tickets) > 0)
        {
            foreach ($tickets as $key => $value)
            {
                $ticket = Ticket::where('id', $value->id)->first();
                $ticket->order = $value->order + 1;
                $ticket->save();
            }
        }
    }

    public function getCode()
    {       
        $nextCode = '001';
        $getTicket = Ticket::orderBy('number', 'desc')
            ->first();

        if ($getTicket) {
            $getCodeNumber = substr($getTicket->number, -3);
            $nextCode = sprintf("%03d", (int)$getCodeNumber + 1);
        }

        $getNextTicketCode = 'TRX' . $nextCode;
            
        return $getNextTicketCode;
    }

    public function getOrder($label)
    {
        $getTicket = Ticket::where('label', $label)
            ->orderBy('order', 'desc')
            ->count();
            
        return $getTicket + 1;
    }
}
