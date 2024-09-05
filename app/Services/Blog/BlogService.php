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

        $oldImages = isset($data['old_data']['images'])
            ? array_column($data['old_data']['images'], 'image_path')
            : [];

        $imagesToRemoveFromServer = array_diff($currentImages, $oldImages);

        foreach ($imagesToRemoveFromServer as $imagePath) {
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $images = $data['new_image'];

        if (isset($data['new_image']) && is_array($data['new_image'])) {
            $newImagePaths = [];
            foreach ($data['new_image'] as $image) {
                if ($image instanceof \Illuminate\Http\UploadedFile) {
                    $newImagePaths[] = $image->store('blog/images', 'public');
                } else {
                    throw new \Exception('Invalid file upload.');
                }
            }
            $data['image_urn'] = $newImagePaths;
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
