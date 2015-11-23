<?php

namespace App\Console\Commands\Database;

use Illuminate\Console\Command;

class UsersAndRelatedTablesClean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:tables:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean the users and related tables from expired lines (reminders, activations, ...)';

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

        $this->line('Cleaning activations and reminders tables from expired lines ...');

        \Activation::removeExpired();
        $this->info('✔ Activations table cleaned.');

        \Reminder::removeExpired();
        $this->info('✔ Reminders table cleaned.');
    }
}
