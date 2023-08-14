<?php 


use Arhitector\Yandex\Disk;
use Arhitector\Yandex\Client\Exception\NotFoundException;

$token = "y0_AgAAAABRivqFAApUugAAAADqKi3XeF9yFX_FTDS0NX3ZcLXUi6_d0ek";

class DiskManager
{
    protected $disk;

    public function __construct($token)
    {
        $disk = new Disk();
        $this->disk = $disk->setAccessToken($token);
    }

    public function getFiles()
    {
        $collection = $this->disk->getResources();
        return $collection->getIterator();
    }

    public function deleteFile($filePath)
    {
        $resource = $this->disk->getResource($filePath);
        $resource->delete();
    }

    public function downloadFile($filePath)
    {
        $resource = $this->disk->getResource($filePath);
        $resource->download(__DIR__.'/../downloads/'.$resource['name'], true);
    }

    public function uploadFile($file)
    {
        try {
            $resource = $this->disk->getResource($file['name']);
            $resource->toArray();
        } catch (NotFoundException $exc) {
            $resource->upload($file['tmp_name']);
        }
    }
}
