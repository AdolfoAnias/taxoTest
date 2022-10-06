<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\MySendMail;
use Illuminate\Support\Facades\Artisan;

class SendMails extends Command
{
    protected $signature = 'schedule:sentMail';
    protected $description = 'Sent Mails from Queue';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {        
      $command = Artisan::call('queue:work');  
    }
}
