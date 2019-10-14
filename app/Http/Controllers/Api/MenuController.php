<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Services\MenuService;
use App\Services\PostService;
use App\Services\PageService;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use App\Models\Menu;

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

    // public function changeOrderMenu(Request $request)
    // {
    //     $arrMenu = $request->tree_menu;
    //     $listMenu = $this->menuService->index();
    //     $rootNode = $this->menuService->getRootMenu();
    //     $this->recursiveBuildTreeMenu($listMenu, $arrMenu, $rootNode);

    //     return response()->json(true);
    // }

    // public function recursiveBuildTreeMenu(Collection $listMenu, array $arrMenu, Menu $parentNode)
    // {
    //     foreach ($arrMenu as $menu) {
    //         $node = $listMenu->find($menu['id']);
    //         $node->makeRoot();
    //         $node->makeChildOf($parentNode);

    //         if (Arr::has($menu, 'children')) {
    //             $arrayMenu = $menu['children'];
    //             $this->recursiveBuildTreeMenu($listMenu, $arrayMenu, $node);
    //         }
    //     }
    // }

    public function changeOrderMenu(Request $request)
    {
        $arrMenu = $request->tree_menu;
        $idChangedNode = $request->id;
        $this->menuService->changeOrderMenu($arrMenu, $idChangedNode);

        return response()->json($arrMenu);
    }

    public function getTypeOfMenu(Request $request)
    {
        $typeOfMenu = $request->type;
        $test = [];
        if ($typeOfMenu == config('common.menu.type.post')) {
            $test = $this->postService->index(['id', 'title']);
            $test = $test->pluck('title', 'id');
        }
        if ($typeOfMenu == config('common.menu.type.page')) {
            $test = $this->pageService->index(['id', 'name']);
            $test = $test->pluck('name', 'id');
        }

        return response()->json($test);
    }
}
