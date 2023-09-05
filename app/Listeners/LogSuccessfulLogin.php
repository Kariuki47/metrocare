<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = $event->user;
        $user->last_login_at = date('Y-m-d H:i:s');
        $user->last_login_ip = $this->request->ip();
        $user->save();
        activity()->performedOn($user)->withProperties(['ip' => $this->request->ip(), 'model' => 'User'])->log('signin');
    }
}
