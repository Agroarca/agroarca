<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\DarkModeWasToggled;
use JeroenNoten\LaravelAdminLte\Events\ReadingDarkModePreference;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(
            ReadingDarkModePreference::class,
            [$this, 'handleReadingDarkModeEvt']
        );

        Event::listen(
            DarkModeWasToggled::class,
            [$this, 'handleDarkModeWasToggledEvt']
        );
    }

    public function handleReadingDarkModeEvt(ReadingDarkModePreference $event)
    {
        $modo_escuro = false;

        if(Auth::user() != null){
            $modo_escuro = Auth::user()->modo_escuro;
        }

        if ($modo_escuro) {
            $event->darkMode->enable();
        } else {
            $event->darkMode->disable();
        }
    }

    public function handleDarkModeWasToggledEvt(DarkModeWasToggled $event)
    {
        $modo_escuro = $event->darkMode->isEnabled();
        $usuario = Auth::user();
        $usuario->modo_escuro = $modo_escuro;
        $usuario->save();
    }
}
