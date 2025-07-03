<?php

namespace App\Repositories\Blog;

use App\Interfaces\Blog\BlogRepositoryInterface;
use App\Models\Blog\Blog;
use App\Models\Blog\BlogImages;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Log;

class BlogRepository implements BlogRepositoryInterface
{
    protected $blog;
    protected $blogImages;

    public function __construct(Blog $blog, BlogImages $blogImages)
    {
        $this->blog = $blog;
        $this->blogImages = $blogImages;
    }

    public function all()
    {
        try {
            return $this->blog->paginate();
        } catch (Exception $err) {
            Log::error('Erro ao listar blog', [$err->getMessage()]);
        }
    }

    public function find($id)
    {
        try {
            return $this->blog->find($id);
        } catch (Exception $err) {
            Log::error('Erro ao localizar blog', [$err->getMessage()]);
        }
    }

    public function create(array $data)
    {
        try {
            DB::transaction(function () use ($data) {
                $blog = $this->blog->create([
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'user_id' => Auth::id(),
                ]);

                foreach ($data['images'] as $imagePath) {
                    $this->blogImages->insert([
                        'image_path' => $imagePath,
                        'order' => 0,
                        'blog_id' => $blog->id,
                    ]);
                }

                return $blog;
            });

            return true;
        } catch (Exception $err) {
            Log::error('Erro ao cadastrar blog', [$err->getMessage()]);
            return false;
        }
    }

    public function update($id, $data)
    {
        try {
            return DB::transaction(function () use ($id, $data) {
                $blog = $this->blog->find($id);

                $blog->update([
                    'title' => $data['title'],
                    'description' => $data['description'],
                ]);

                $this->blogImages->where('blog_id', $id)
                    ->whereNotIn('image_path', $data['old_data'])
                    ->delete();

                if (isset($data['images'])) {
                    foreach ($data['images'] as $imagePath) {
                        $this->blogImages->create([
                            'image_path' => $imagePath,
                            'order' => 0,
                            'blog_id' => $id,
                        ]);
                    }
                }

                return $blog;
            });

        } catch (Exception $err) {
            Log::error('Erro ao cadastrar blog', [$err->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            $blog = $this->blog->find($id);
            $blog->delete();
            return true;
        } catch (Exception $err) {
            Log::error('Erro ao cadastrar blog', [$err->getMessage()]);
            return false;
        }
    }
}
