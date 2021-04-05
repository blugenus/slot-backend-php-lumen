<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Classes\VideoSlot;

class SlotCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'slot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generates a random 5x3 board using 10 different symbols and prints the result including winning paylines.";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $spin = new VideoSlot(100); // 1Euro = 100cents. 
        // outputing json as indicated in test.
        $this->info(
            json_encode($spin->outcome())
        );
    }

}