<?php

namespace DanmerCC\TrashableStorage\Traits;

use DanmerCC\TrashableStorage\TrashStorage;
use Illuminate\Filesystem\FilesystemAdapter;

trait TrashableDisk
{
    public function trashable($trashFolder = null)
    {
        $trashFolder = $trashFolder ?? config('trash-storage.trash_folder', 'trash');

        // Devolver la instancia extendida del almacenamiento
        return new TrashStorage($this, $trashFolder);
    }
}
