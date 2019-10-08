<?php

namespace App\Console\Commands;

use App\User;
use App\DripEmailer;
use Illuminate\Console\Command;

class LaravelCafebazaarConsole extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Cafebazaar {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cafebazaar console commands';

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
    public function handle()
    {
        $action = $this->argument('action');
        $client_id = config('laravel-cafebazaar.client_id');
        $redirect_uri = config('laravel-cafebazaar.redi$redirect_uri');
        switch($action) {
            case 'code':
                echo "Visit this and grant access";
                echo "https://pardakht.cafebazaar.ir/devapi/v2/auth/authorize/?response_type=code&access_type=offline&redirect_uri=$redirect_uri&client_id=$client_id\n";
                break;
        }
    }
}