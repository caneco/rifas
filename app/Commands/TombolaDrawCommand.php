<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;
use LaravelZero\Framework\Commands\Command;
use RandomLib\Factory;
use SecurityLib\Strength;

class TombolaDrawCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tombola:draw';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Raffle the a prize to a lucky ticket holder.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $this->output->title(sprintf('Rifas %s', config('app.version')));

        $prizes = DB::table('prizes')
            ->whereNull('winner')
            ->get(['id', 'description']);

        $this->info('Take a look on our prize list:');
        foreach ($prizes as $prize) {
            $this->line(" <fg=yellow>[{$prize->id}]</> {$prize->description}");
        }

        while (1) {
            $input = $this->ask('Select the first prize that will be sorted', $prizes->first()->id);
            $prizeSelected = $prizes->where('id', $input)->first();
            if ($prizeSelected) break;
        }

        $tickets = DB::table('tickets')
            ->where('is_sorted', 0)
            ->get(['uid', 'email'])
            ->shuffle()
            ->toArray();

        if (empty($tickets)) {
            $this->line('<fg=red>!! Please add some tickets before the raffle !!</>'.PHP_EOL);
            exit;
        }

        $ticketsTotal = count($tickets)-1;
        $currentPosition = 0;
        $timestamp = time();

        $this->info(sprintf('And the prize <fg=yellow>(%s)</> goes to...', $prizeSelected->description));

        while (true) {
            @$pointer++;
            if ($pointer > $ticketsTotal) {
                $pointer = 0;
            }

            echo sprintf(" > %s\r", $tickets[$pointer]->email);

            if ((time() - $timestamp) >= mt_rand(3,5)) {
                $timestamp = time();
                echo "\r";
                break;
            }

            usleep(25000);
        }

        $ticketSelected = $tickets[$pointer];

        DB::table('prizes')
            ->where('id', $prizeSelected->id)
            ->update(['winner' => $ticketSelected->email]);

        DB::table('tickets')
            ->where('uid', $ticketSelected->uid)
            ->update(['is_sorted' => 1]);

        $this->warn(sprintf(' [%s] <fg=white>%s</>', $ticketSelected->uid, $ticketSelected->email));
        $this->line(PHP_EOL.'Congratz!'.PHP_EOL);
    }

    /**
	 * Define the command's schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule $schedule
	 *
	 * @return void
	 */
	public function schedule(Schedule $schedule): void
	{
		// $schedule->command(static::class)->everyMinute();
	}
}
