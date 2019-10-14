<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\MenuService;
use App\Services\PostService;
use App\Services\PageService;

class HomeController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listMenu = $this->menuService->getListWithoutOrderAttribute();

        return view('home.index', ['listMenu' => $listMenu]);
    }
}
