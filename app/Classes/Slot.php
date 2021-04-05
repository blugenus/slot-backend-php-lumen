<?php

namespace App\Classes;

class Slot
{
    /**
     * The different symbols.
     *
     * @var array - array of symbols
     */
    protected $symbols = [];

    /**
     * The slot's paylines.
     *
     * @var array - array of paylines
     */
    protected $paylines = [];

    /**
     * The Mapping of the pailines and the board.
     *
     * @var array - array of int
     */
    protected $paylineToBoardMapping = [];

    /**
     * The pay rate for different consecutive symbols 
     *
     * @var array - key is consecutive symbols; value is a decimal bet multiplier.
     */
    protected $payRates = [];

    /**
     * The resulting board.
     *
     * @var array - array representing the board. 
     */
    private $board = [];

    /**
     * Winning Paylines
     *
     * @var array - Array with matched payline and number of matched symbol
     */
    private $winningPaylines = [];

    /**
     * The resulting board.
     *
     * @var int - monetary numbers in cents 1€ = 100cents. In you case is always 100
     */
    private $betAmount = 0;

    /**
     * Total Amount won.
     *
     * @var int - amount won
     */
    private $totalWin = 0;

    /**
     * create a slot and spin it once.
     *
     * @param $betAmount - in cents. 
     * @return void
     */
    public function __construct($betAmount)
    {
        $this->spin($betAmount, 15, $this->symbols);
        $this->paylines($this->paylines, $this->paylineToBoardMapping);
        $this->calculateWinnings($this->payRates);
    }

    /**
     * create board.
     *
     * @param $betAmount - in cents. 
     * @param $boardSize - the size of the board. 
     * @param $symbols - the different symbols allowed. 
     * @return void
     */
    protected function spin($betAmount, $boardSize, $symbols)
    {
        $this->betAmount = $betAmount;
        for ($i = 0; $i < $boardSize; $i++) {
            $this->board[] = $symbols[
                array_rand($symbols, 1)
            ];
        }
    }

    /**
     * check board winning paylines.
     *
     * For the scope of this test I'm assuming that there won't be a case where we will
     * have more then 5 columns thus same payline could have 2x3 consecutive symbols. 
     *
     * @param $paylines - array representing the slot's paylines.
     * @param $boardMapping - array representing the mapping of the pailines and the board.
     * @return void
     */
    protected function paylines($paylines,$boardMapping)
    {
        $mappedBoard = array_combine(
            $boardMapping, 
            array_values($this->board)
        );
        foreach ($paylines as $payline) {
            $consecutive = 1;
            $lastSymbol = $mappedBoard[$payline[0]];
            $sizeOfPayline = count($payline);
            for ($i = 1; $i < $sizeOfPayline; $i++) {
                if ($lastSymbol == $mappedBoard[$payline[$i]]) {
                    $consecutive++;
                } elseif ($consecutive < 3) {
                    $consecutive = 1;
                    $lastSymbol = $mappedBoard[$payline[$i]];
                } else {
                    break;
                }
            }
            if ($consecutive >= 3) {
                $this->winningPaylines[implode(' ', $payline)] = $consecutive;
            }
        }
    }

    /**
     * Calculate the total winning of this spin
     *
     * @param $payRates - The pay rate for different consecutive symbols 
     * @return void
     */
    protected function calculateWinnings($payRates)
    {
        foreach ($this->winningPaylines as $paylineString => $consecutive) {
            $this->totalWin += $payRates[$consecutive] * $this->betAmount;
        }        
    }

    /**
     * Get the outcome of the spin
     *
     * @return array
     */
    public function outcome()
    {
        return [
            'board' => $this->board,
            'paylines' => $this->winningPaylines,
            'bet_amount' => $this->betAmount,
            'total_win' => $this->totalWin,
        ];
    }

}