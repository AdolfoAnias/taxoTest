<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\MySendMail;
use Illuminate\Support\Facades\Artisan;

class SendMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:sentMail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sent Mails from Queue';

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
     * @return int
     */
    public function handle()
    {        
      $command = Artisan::call('queue:work');  
    }
}
