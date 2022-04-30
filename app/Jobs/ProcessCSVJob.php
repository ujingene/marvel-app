<?php

namespace App\Jobs;

use App\Actions\UploadBulkInvoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCSVJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $flag;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($flag)
    {
        $this->flag = $flag;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $uploadBulkInvoice = new UploadBulkInvoice();
        $uploadBulkInvoice->execute($this->flag);
    }
}
