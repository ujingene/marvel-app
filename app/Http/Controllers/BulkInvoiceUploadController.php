<?php

namespace App\Http\Controllers;

use App\Actions\UploadBulkInvoice;
use App\Jobs\ProcessCSVJob;
use App\Models\Flag;
use App\Models\Invoice;
use Illuminate\Support\Facades\Config;

class BulkInvoiceUploadController extends Controller
{
    public function __construct(UploadBulkInvoice $uploadBulkInvoice)
    {
        $this->uploadBulkInvoice = $uploadBulkInvoice;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::paginate(3);
        return view('invoice.index', compact('invoices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        $csv_file = request()->file('invoiceDoc');

        try {
           $fname = md5(rand()) . '.csv';
           $full_path = Config::get('filesystems.disks.local.root');
           $csv_file->move( $full_path, $fname );

           // Flag new file upload
           $flag_table = Flag::firstOrNew(['file_name'=>$fname]);
           $flag_table->save();
       }catch(\Exception $e){
           return redirect()->route('csv_page')->withErrors($e->getMessage()); 
       }

        dispatch(new ProcessCSVJob($flag_table->id))->delay(now()->addMinutes(0.5));

        return redirect()->route('csv_page');
    }

}
