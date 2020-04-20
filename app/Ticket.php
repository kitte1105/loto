<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Ticket extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'ticket_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'blank'
    ];

    public static $createRules = [
        'user_id' => ['required', 'max:255'],
        'blank'   => ['required']
    ];

    public static $updateRules = [
        'ticket_id' => ['unique:posts', 'int'],
        'user_id'   => ['required', 'max:255'],
        'blank'     => ['required']
    ];

    public function validate($rules = [], $validationRules = []) {
        if (empty($rules)) {
            $rules = $this->toArray();
        }

        if (empty($validationRules)) {
            $validationRules = self::$updateRules;
        }

        $validator = Validator::make($rules, $validationRules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function validateAndFill($inputArray, $validationRules) {
        // must validate input before injecting into model
        $this->validate($inputArray, $validationRules);
        $this->fill($inputArray);
    }
}
