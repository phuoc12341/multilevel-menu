<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Services\MenuService;
use App\Services\PostService;
use App\Services\PageService;

class MenuController extends ApiController
{
    /**
     * @var \App\Services\MenuService
     */
    protected $menuService;
    protected $postService;
    protected $pageService;

    /**
     * Instantiate a new instance.
     * @param MenuService $menuService
     */
    public function __construct(MenuService $menuService, PostService $postService, PageService $pageService)
    {
        $this->menuService = $menuService;
        $this->postService = $postService;
        $this->pageService = $pageService;
    }

    public function changeOrderMenu(Request $request)
    {
        $data = $request->only(['tree_menu', 'id']);

        return $this->doAction(function () use ($data) {
            $arrMenu = $data['tree_menu'];
            $idChangedNode = $data['id'];
            $this->menuService->changeOrderMenu($arrMenu, $idChangedNode);
            $this->compacts['data'] = [];
            $this->compacts['description'] = __('messages.reorder_menus_success');
        }, __('update'));
    }

    public function getTypeOfMenu(Request $request)
    {
        $data = $request->only(['type']);

        return $this->doAction(function () use ($data) {
            $this->compacts['data'] = [];
            if ($data['type'] == config('common.menu.type.post')) {
                $listPost = $this->postService->index(['id', 'title']);
                $this->compacts['data'] = $listPost->pluck('title', 'id');
            }

            if ($data['type'] == config('common.menu.type.page')) {
                $listPage = $this->pageService->index(['id', 'name']);
                $this->compacts['data'] = $listPage->pluck('name', 'id');
            }
        });
    }
}
