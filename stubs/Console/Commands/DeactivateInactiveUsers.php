<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeactivateInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sbkl:deactivate-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate user account after 3 months of non-activity based on the last_activity_at field of the users table';

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
        $users = User::all();
        $users->each(function ($user) {
            if ((! $user->last_activity_at && (new Carbon($user->created_at))->addMonths(3) < now()) || (new Carbon($user->last_activity_at))->addMonths(3) < now()) {
                if (! $user->deactivated) {
                    $user->deactivate();
                }
            }
        });
    }
}
