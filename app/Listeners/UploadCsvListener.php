<?php

namespace App\Listeners;

use App\Actions\ImportCsv;
use App\Events\FlagCreatedEvent;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UploadCsvListener implements ShouldQueue, ShouldBeUnique
{
    use InteractsWithQueue;

    public function __construct(ImportCsv $importCsv)
    {
        $this->importCsv = $importCsv;
    }
    /**
     * Handle the event.
     *
     * @param  \App\Events\FlagCreatedEvent  $event
     * @return void
     */
    public function handle(FlagCreatedEvent $event)
    {
        $this->importCsv->execute($event->flag);
    }

}
