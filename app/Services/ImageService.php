<?php namespace App\Services;

use Repositories\ImageRepositoryInterface;

class ImageService
{
    private $repo;

    public function __construct(ImageRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function processImages()
    {
        return $repo->processImages();
    }

    public function get($url)
    {
        return $repo->get($url);
    }

    public function getAll()
    {
        return $repo->getAll();
    }

}
