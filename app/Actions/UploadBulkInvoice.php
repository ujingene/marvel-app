<?php 

namespace App\Actions;

use App\Imports\InvoicesImport;
use App\Models\Flag;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Exception;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;

class UploadBulkInvoice
{
	public function execute(string $fileId)
	{
		try {
			$file = Flag::where('imported','=','0')
                   ->orderBy('created_at', 'DESC')
                   ->first();

            $file_path = Config::get('filesystems.disks.local.root') . '/' .$file->file_name;

	       	//dd('load data...', $file_path);

	       	//import the rows
            Excel::queueImport(new InvoicesImport, $file_path);

            $file->imported =1;
       		$file->save();

        } catch (Exception $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

	}
}