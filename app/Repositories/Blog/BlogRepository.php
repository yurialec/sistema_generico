<?php

namespace App\Repositories\Blog;

use App\Interfaces\Blog\BlogRepositoryInterface;
use App\Models\Blog\Blog;

class BlogRepository implements BlogRepositoryInterface
{
    protected $blog;

    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }

    public function all()
    {
        return $this->blog->get();
    }

    public function find($id)
    {
        return $this->blog->find($id);
    }

    public function create(array $data)
    {
        return $this->blog->create($data);
    }

    public function update($id, $data)
    {
        $blog = $this->blog->find($id);
        $blog->update($data);

        return $blog;
    }

    public function delete($id)
    {
        $blog = $this->blog->find($id);
        if ($blog) {
            $blog->delete();
            return true;
        }
        return false;
    }
}
