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
        $images = $data['images'];

        $images_urn = [];
        foreach ($data['images'] as $key) {
            $images_urn[] = $key->store('blog/images', 'public');
        }

        $data['images'] = $images_urn;

        return $this->blogRepository->create($data);
    }

    public function update($id, $data)
    {
        $blog = $this->blogRepository->find($id);
        $currentImages = $blog->images->pluck('image_path')->toArray();

        foreach ($data['old_data']['images'] as $key => $value) {
            $old_data[] = $value['image_path'];
        }

        $imagesToRemoveFromServer = array_diff($currentImages, $old_data);

        if (!empty($imagesToRemoveFromServer)) {
            foreach ($imagesToRemoveFromServer as $key => $value) {
                Storage::disk('public')->delete($value);
            }
        }

        if (isset($data['new_image'])) {
            $images_urn = [];

            foreach ($data['new_image'] as $key) {
                $images_urn[] = 1;
            }

            // $image = $data['new_image'];
            // dd($image);
            // $data['image_urn'] = $image->store('blog/images', 'public');
        } else {
            unset($data['image_urn']);
        }

        return $this->blogRepository->update($id, $data);
    }

    public function delete($id)
    {
        $blog = $this->blogRepository->find($id);

        if (isset($blog->images)) {

            foreach ($blog->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }
        }

        return $this->blogRepository->delete($id);
    }
}
