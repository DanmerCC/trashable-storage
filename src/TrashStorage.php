<?php

namespace DanmerCC\TrashableStorage;

use DanmerCC\TrashableStorage\Traits\TrashableDisk;
use Illuminate\Filesystem\FilesystemAdapter;

class TrashStorage extends FilesystemAdapter
{
    protected $trashFolder;

    public function __construct(FilesystemAdapter $disk, $trashFolder = 'trash')
    {
        parent::__construct($disk->getDriver(), $disk->getAdapter(), $disk->getConfig());
        $this->trashFolder = rtrim($trashFolder, '/') . '/';
    }

    public function delete($path)
    {
        $trashPath = $this->trashFolder . ltrim($path, '/');

        if ($this->exists($path)) {

            if($this->exists($trashPath)) {

                $filename = pathinfo($path, PATHINFO_FILENAME);
                $extension = pathinfo($path, PATHINFO_EXTENSION);
                $newFilename = $filename . '_' . time() . '.' . $extension;

                $filepath = pathinfo($path, PATHINFO_DIRNAME);
                $newPath = $filepath . '/' . $newFilename;

                $trashPath = $this->trashFolder . ltrim($newPath, '/');
            }
            $this->move($path, $trashPath);
        }

        return true;
    }
}
