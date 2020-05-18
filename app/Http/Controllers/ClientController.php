<?php

namespace App\Http\Controllers;

use App\Participant;
use Illuminate\Http\Request;
use App\Repositories\TicketsRepository;

class ClientController extends Controller
{
    protected $tickets_repo;

    public function __construct(TicketsRepository $tickets_repo)
    {
        $this->tickets_repo = $tickets_repo;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $participant = factory(Participant::class)->create();
        $ticket = $this->tickets_repo->generate($participant->participant_id);

        while ($this->tickets_repo->checkIfExists($ticket)) {
            $ticket = $this->tickets_repo->generate();
        }
        $this->tickets_repo->store($ticket);
        $blank = $this->tickets_repo->getBlank($ticket);

        return view('client', ['blank' => $blank]);
    }
}
