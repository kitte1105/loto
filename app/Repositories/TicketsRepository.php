<?php


namespace App\Repositories;

use App\Ticket;

class TicketsRepository
{
    /** @var Ticket[] */
    private $tickets;

    public function findAll()
    {
        $this->tickets = Ticket::all();

        return $this->tickets;
    }

    public function findById($ticket_id)
    {
        return Ticket::findOrFail($ticket_id);
    }

    public function getBlank(Ticket $ticket)
    {
        return unserialize($ticket->getAttribute('blank'));
    }

    public function generate()
    {
        $ticket = new Ticket();

        try {
            $ticket_by_str = [];
            $number_order = [];
            for ($i = 1; $i <= 4; $i++) {
                for ($j = 1; $j <= 5; $j++) {
                    $rand_number = rand(1, 9);
                    while (in_array($rand_number, $number_order)) {
                        $rand_number = rand(0, 8);
                    }
                    $number_order[$i][] = $rand_number;
                }
            }
            foreach ($number_order as $str_pos => $str) {
                for ($i = 0; $i <= 8; $i++) {
                    if (in_array($i, $str)) {
                        $ticket_by_str[$str_pos][$i + 1] = rand($i * 10, ($i + 1) * 10 - 1);
                    } else {
                        $ticket_by_str[$str_pos][$i + 1] = 0;
                    }
                }
            }
            $ticket_data = [
                'user_id' => 2,
                'blank'   => serialize($ticket_by_str)
            ];
            if (empty($ticket_data['ticket_id'])) {
                $ticket->validateAndFill($ticket_data, Ticket::$createRules);
            } else {
                $ticket->validateAndFill($ticket_data, Ticket::$updateRules);
            }
            $ticket->save();
        }
        catch (Exception $exception) {
            $this->handleError($exception);
        }

        return $ticket;
    }

    public function store(Ticket $ticket) {
        try {
            $ticket->save();
        }
        catch (Exception $exception) {
            $this->handleError($exception);
        }
    }
}
