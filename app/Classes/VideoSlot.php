<?php

namespace App\Classes;

class VideoSlot extends Slot
{
    /**
     * The different symbols.
     *
     * @var array - array of symbols
     */
    protected $symbols = [
        '9', 
        '10', 
        'J', 
        'Q',
        'K', 
        'A', 
        'cat', 
        'dog', 
        'monkey',
        'bird'
    ];

    /**
     * The slot's paylines.
     *
     * @var array - array of paylines
     */
    protected $paylines = [
        [0, 3, 6, 9, 12],
        [1, 4, 7, 10, 13],
        [2, 5, 8, 11, 14],
        [0, 4, 8, 10, 12],
        [2, 4, 6, 10, 14]
    ];

    /**
     * The Mapping of the pailines and the board.
     *
     * @var array - array of int
     */
    protected $paylineToBoardMapping = [0, 3, 6, 9, 12, 1, 4, 7, 10, 13, 2, 5, 8, 11, 14];

    /**
     * The pay rate for different consecutive symbols 
     *
     * @var array - key is consecutive symbols; value is a decimal bet multiplier.
     */
    protected $payRates = [
        3 => 0.2,
        4 => 2,
        5 => 10
    ];

}