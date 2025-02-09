<?php

namespace DanmerCC\TrashableStorage;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use DanmerCC\TrashableStorage\TrashStorage;

class TrashStorageServiceProvider extends ServiceProvider
{
    public function boot()
    {

        $trashableDisks = config('trash-storage.trashable_disks', []);
        $registeredDisks = [];

        foreach ($trashableDisks as $diskName) {
            if (!in_array($diskName, $registeredDisks)) {
                Storage::extend($diskName, function ($app, $config) use ($diskName) {
                    $originalDisk = Storage::disk($diskName);
                    $trashFolder = config('trash-storage.trash_folder', 'trash');

                    return new TrashStorage($originalDisk, $trashFolder);
                });
                $registeredDisks[] = $diskName;
            }
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/trash-storage.php', 'trash-storage');
    }
}

