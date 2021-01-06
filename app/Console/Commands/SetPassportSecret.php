<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetPassportSecret extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:set-secret';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set passport client secret to env should be call after passport:install.';

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
        $path = base_path('.env');

        file_put_contents($path, str_replace(
            'PASSPORT_CLIENT_SECRET=' . env("PASSPORT_CLIENT_SECRET"),
            'PASSPORT_CLIENT_SECRET=' . DB::table('oauth_clients')->where('id', 2)->first()->secret,
            file_get_contents($path)
        ));
    }
}
