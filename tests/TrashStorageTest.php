<?php

namespace DanmerCC\Tests;

use Illuminate\Filesystem\FilesystemAdapter;
use DanmerCC\TrashableStorage\TrashStorage;
use PHPUnit\Framework\TestCase;

class TrashStorageTest extends TestCase
{
    protected $mockDisk;
    protected $trashDisk;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockDisk = $this->createMock(FilesystemAdapter::class);
        $this->trashDisk = new TrashStorage($this->mockDisk, 'trash');
    }

    public function test_file_is_moved_to_trash_on_delete()
    {
        $filePath = 'test-file.txt';
        $trashPath = 'trash/test-file.txt';

        $this->mockDisk->method('exists')
            ->with($filePath)
            ->willReturn(true);

        $this->mockDisk->expects($this->once())
            ->method('move')
            ->with($filePath, $trashPath);

        $this->trashDisk->delete($filePath);
    }

    public function test_file_does_not_move_if_not_exists()
    {
        $filePath = 'non-existent-file.txt';

        $this->mockDisk->method('exists')
            ->with($filePath)
            ->willReturn(false);

        $this->mockDisk->expects($this->never())
            ->method('move');

        $this->trashDisk->delete($filePath);
    }
}
