<?php


namespace App\Repositories;

use App\Tour;

class ToursRepository
{
    /** @var Tour[] */
    private $tours;

    public function findAll()
    {
        $this->tours = Tour::all();

        return $this->tours;
    }

    public function findById($tour_id)
    {
        return Tour::findOrFail($tour_id);
    }

    public function startTour()
    {
        $this->startFirstStage();
        $this->startSecondStage();
        $this->startThirdStage();
    }

    private function startFirstStage()
    {

    }
}
