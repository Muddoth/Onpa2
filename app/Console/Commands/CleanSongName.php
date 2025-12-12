<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CleanSongName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'songs:clean-names';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean audio file names and update database paths';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $audioDir = storage_path('app/public/audio');
        $files = scandir($audioDir);

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $oldPath = $audioDir . DIRECTORY_SEPARATOR . $file;

            if (!is_file($oldPath)) {
                continue;
            }

            $cleanName = Str::of($file)
                ->lower()
                ->replace(' ', '_')                     // spaces → underscores
                ->replaceMatches('/[^a-z0-9_\-.]/', '') // remove unwanted chars except underscore, dash, dot
                ->replace('_-_', '_');                   // replace the sequence "_-_" with "_"


            if ($cleanName == $file) {
                continue;
            }

            $newPath = $audioDir . DIRECTORY_SEPARATOR . $cleanName;

            rename($oldPath, $newPath);

            DB::table('songs')
                ->where('file_path', 'audio/' . $file)
                ->update(['file_path' => 'audio/' . $cleanName]);

            $this->info("Renamed $file to $cleanName and updated DB.");
        }

        $this->info('All done!');
    }
}
