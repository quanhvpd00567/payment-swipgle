<?php

namespace App\Console\Commands;

use App\Models\Transfer;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Storage;

class DeleteExpiryFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is for expiry time, its deleting expiry files';

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
     * @return int
     */
    public function handle()
    {
        // Get local transfers
        $transfers_local = Transfer::where('expiry_time', '<=', Carbon::now())->where('storage_method', 1)->where('tranfer_status', 1)->get();
        // Get amazon s3 transfers
        $transfers_amazon = Transfer::where('expiry_time', '<=', Carbon::now())->where('storage_method', 2)->where('tranfer_status', 1)->get();
        // foreach local transfers
        $files_local = [];
        foreach ($transfers_local as $transfer_local) {
            $files_local = explode(',', $transfer_local->transferted_files);
        }
        // foreach amazon s3 transfers
        $files_amazon = [];
        foreach ($transfers_amazon as $transfer_amazon) {
            $files_amazon = explode(',', $transfer_amazon->transferted_files);
        }
        // Foreach local files
        foreach ($files_local as $file_local) {
            // Delete file
            if (Storage::disk('local')->has('public/files/' . $file_local)) {
                $delete = Storage::disk('local')->delete('public/files/' . $file_local);
            }
        }
        // Foreach amazon s3 files
        foreach ($files_amazon as $file_amazon) {
            // Delete file
            if (Storage::disk('s3')->has($file_amazon)) {
                // Delete file from amazon s3
                $delete = Storage::disk('s3')->delete($file_amazon);
            }
        }
    }
}
