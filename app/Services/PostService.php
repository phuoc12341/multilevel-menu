<?php

namespace App\Services;

use App\Repo\PostRepositoryInterface;
use App;
use App\Models\Post;
use Illuminate\Support\Collection;

class PostService extends BaseService
{
    /**
     * @var \App\Repo\PostRepositoryInterface
     */
    protected $postRepository;

    /**
     *
     * @param \App\Repo\PostRepositoryInterface $postRepository
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function find($id)
    {
        $post = $this->postRepository->findById($id);

        return $post;
    }

    public function findBySlug($slug)
    {
        $post = $this->postRepository->findBySlug($slug);

        return $post;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(array $column = ['*'])
    {
        $listPost = $this->postRepository->fetchAll($column);

        return $listPost;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $params
     * @return \Illuminate\Http\Response
     */
    public function store(array $params)
    {
        $post = $this->postRepository->store($params);
        $post->slug = $post->title;

        return $this->postRepository->update($post->id, ['slug' => $post->slug]);
    }

    public function update(array $params, Post $post)
    {
        $post->slug = $params['title'];
        $params['slug'] = $post->slug;

        return $this->postRepository->update($post->id, $params);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Post  $post
     * 
     */
    public function destroy(Post $post)
    {
        return $this->postRepository->deleteById($post->id);
    }
}
