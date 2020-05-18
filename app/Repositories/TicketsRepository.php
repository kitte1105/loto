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

    public function generate($user_id)
    {
        $ticket = new Ticket();

        try {

            $ticket_order_by_strings = $this->generateRandomTicketOrderByStrings();
            $ticket_by_str = $this->fillTicketByRandomNumbers($ticket_order_by_strings);

            $ticket_data = [
                'user_id' => $user_id,
                'blank'   => serialize($ticket_by_str)
            ];

            if (empty($ticket_data['ticket_id'])) {
                $ticket->validateAndFill($ticket_data, Ticket::$createRules);
            } else {
                $ticket->validateAndFill($ticket_data, Ticket::$updateRules);
            }
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

    private function getRandomNumberNotInArray($start_pos, $finish_pos, $array = [])
    {
        $rand_number = rand($start_pos, $finish_pos);
        while (in_array($rand_number, $array)) {
            $rand_number = rand($start_pos, $finish_pos);
        }

        return $rand_number;
    }

    private function generateRandomStringOrder()
    {
        $string_order = [];
        for ($i = 1; $i <= 5; $i++) {
            $string_order[] = $this->getRandomNumberNotInArray(0, 8, $string_order);
        }

        return $string_order;
    }

    private function generateRandomTicketOrderByStrings()
    {
        $number_order = [];
        for ($i = 1; $i <= 6; $i++) {
            $number_order[$i] = $this->generateRandomStringOrder();
        }

        return $number_order;
    }

    private function fillTicketByRandomNumbers($ticket_order_by_strings)
    {
        $ticket_by_str = [];
        $elements = [];
        foreach ($ticket_order_by_strings as $str_pos => $str) {
            for ($i = 0; $i <= 8; $i++) {
                if (in_array($i, $str)) {
                    $start_pos = ($i === 0) ? 1 : $i * 10;
                    $finish_pos = ($i + 1) * 10 - 1;
                    $rand_number = $this->getRandomNumberNotInArray($start_pos, $finish_pos, $elements);
                    $ticket_by_str[$str_pos][$i + 1] = $rand_number;
                    $elements[] = $rand_number;

                } else {
                    $ticket_by_str[$str_pos][$i + 1] = 0;
                }
            }
        }

        return $ticket_by_str;
    }

    public function checkIfExists(Ticket $ticket)
    {
        $result = Ticket::where('blank', $ticket->blank);

        return (bool) $result->count();
    }
}
