<?php

namespace App\Services\Blog;

use App\Repositories\Blog\BlogRepository;
use Illuminate\Support\Facades\Storage;

class BlogService
{
    protected $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function getAll()
    {
        return $this->blogRepository->all();
    }

    public function getById($id)
    {
        return $this->blogRepository->find($id);
    }

    public function create($data)
    {
        $image = $data['image'];
        $image_urn = $image->store('site/carousel/images', 'public');

        $data['image'] = $image_urn;

        return $this->blogRepository->create($data);
    }

    public function update($id, $data)
    {
        $carousel = $this->blogRepository->find($id);

        if (isset($data['image'])) {
            Storage::disk('public')->delete($carousel->image);

            $image = $data['image'];
            $data['image_urn'] = $image->store('site/carousel/images', 'public');
        } else {
            unset($data['image_urn']);
        }

        return $this->blogRepository->update($id, $data);
    }

    public function delete($id)
    {
        $logo = $this->blogRepository->find($id);
        if (isset($logo->image)) {
            Storage::disk('public')->delete($logo->image);
        }

        return $this->blogRepository->delete($id);
    }
}
