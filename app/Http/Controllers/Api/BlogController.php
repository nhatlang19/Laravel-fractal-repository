<?php
namespace App\Http\Controllers\Api;

class BlogController {
    public function getBlogs() {
        return [
            ['id' => 1, 'title' => 'Title 1'],
            ['id' => 2, 'title' => 'Title 2'],
            ['id' => 3, 'title' => 'Title 3'],
        ];
    }
}