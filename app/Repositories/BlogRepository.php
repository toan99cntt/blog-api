<?php

namespace App\Repositories;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Base\BaseRepository;
use App\Events\ShowBlog;

class BlogRepository extends BaseRepository
{
    public function model(): string
    {
        return Blog::class;
    }

    public function index(Request $request): Collection
    {
        return $this->model->newQuery()->with('member')->orderBy('id', 'desc')->get();
    }

    public function store(Request $request): Blog
    {
        /** @var Blog $blog */
        $blog = new $this->model();
        $blog
            ->setTitle($request->get('title'))
            ->setContent($request->get('content'))
            ->setMemberId($request->user()->getKey())
            ->save();

        return $blog;
    }

    public function show(int $id): ?Blog
    {
        $blog = $this->model->findOrFail($id);
        ShowBlog::dispatch($blog);

        return $this->model->findOrFail($id);
    }

    public function update(Request $request, int $id): Blog
    {
        /** @var Blog $blog */
        $blog = $this->model->newQuery()->findOrFail($id);
        $blog
            ->setTitle($request->get('title'))
            ->setContent($request->get('content'))
            ->save();

        return $blog;
    }

    public function destroy(int $id): void
    {
        $this->model->newQuery()->findOrFail($id)->delete();
    }
}
