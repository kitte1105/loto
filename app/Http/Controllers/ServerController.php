<?php

namespace App\Http\Controllers;

use App\Tour;
use Illuminate\Http\Request;
use App\Repositories\ToursRepository;

class ServerController extends Controller
{
    protected $tours_repo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ToursRepository $tours_repo)
    {
        $this->middleware('auth');
        $this->tours_repo = $tours_repo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('server');
    }

    public function tour(Request $request)
    {
        $validatedData = $request->validate([
            'tour.participants_qty' => ['required'],
            'tour.bank' => ['required'],
        ]);
        $tour_results = $this->tours_repo->startTour();

        return $this->saveTourResults($tour_results);
    }

    public function statistics()
    {
        return view('statistics');
    }
}
