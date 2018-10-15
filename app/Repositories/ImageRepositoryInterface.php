<?php namespace App\Repositories;

interface ImageRepositoryInterface {
    public function processImages();
    public function get($imageUrl);
    public function getAll();
}