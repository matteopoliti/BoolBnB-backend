<?php

namespace App\Console;

use App\Models\Apartment;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $apartments = Apartment::onlyTrashed()
                ->where('deleted_at', '<=', now()->subMinute(1))
                // Stringa che andrà per la verifica dei 30 giorni ->where('deleted_at', '<=', now()->subDays(30))
                ->get();

            foreach ($apartments as $apartment) {
                // Eliminazione dei messaggi associati all'appartamento
                foreach ($apartment->messages as $message) {
                    $message->delete();
                }

                // Scollegamento dei servizi
                $apartment->services()->detach();

                // Eliminazione dell'immagine di copertina, se presente
                if ($apartment->cover_image) {
                    Storage::delete($apartment->cover_image);
                }

                // Eliminazione forzata dell'appartamento
                $apartment->forceDelete();
            }
        })->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
