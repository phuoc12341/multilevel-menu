<?php

namespace App\Services;

use App\Repo\PageRepositoryInterface;
use App;
use App\Models\Page;
use Illuminate\Support\Collection;

class PageService extends BaseService
{
    /**
     * @var \App\Repo\PageRepositoryInterface
     */
    protected $pageRepository;

    /**
     *
     * @param \App\Repo\PageRepositoryInterface $pageRepository
     */
    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function find($id)
    {
        $page = $this->pageRepository->findById($id);

        return $page;
    }

    public function findBySlug($slug)
    {
        $page = $this->pageRepository->findBySlug($slug);

        return $page;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(array $column = ['*'])
    {
        $listPage = $this->pageRepository->fetchAll($column);

        return $listPage;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $params
     * @return \Illuminate\Http\Response
     */
    public function store(array $params)
    {
        $page = $this->pageRepository->store($params);
        $page->slug = $page->name;

        return $this->pageRepository->update($page->id, ['slug' => $page->slug]);
    }

    public function update(array $params, Page $page)
    {
        $page->slug = $params['name'];
        $params['slug'] = $page->slug;

        return $this->pageRepository->update($page->id, $params);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Page  $page
     * 
     */
    public function destroy(Page $page)
    {
        return $this->pageRepository->deleteById($page->id);
    }
}
