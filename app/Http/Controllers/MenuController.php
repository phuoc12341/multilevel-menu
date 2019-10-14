<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\MenuService;
use App\Models\Menu;
use App\Services\PageService;
use App\Services\PostService;

class MenuController extends Controller
{
    /**
     * @var \App\Services\MenuService
     */
    protected $menuService;
    protected $pageService;
    protected $postService;

    /**
     * Instantiate a new instance.
     * @param MenuService $menuService
     */
    public function __construct(MenuService $menuService, PageService $pageService, PostService $postService)
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

        return view('menus.index', ['listMenu' => $listMenu]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listMenu = $this->menuService->index();

        $arrPushToComponent = [
            'listSelectMenu' => $listMenu->pluck('name', 'id'), 
            'parentMenu' => null,
            'order' => null,
            'associatedMenuId' => null,
            'typeMenuWantAssociate' => array_flip(config('common.menu.type')),
            'indexCurrentTypeMenu' => null,
            'listMenuAssociate' => [],
        ];

        $compacts = [
            'arrPushToComponent' => $arrPushToComponent,
        ];

        return view('menus.create', $compacts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->only('name', 'parent_id', 'order', 'type_of_menu', 'menu_associate');
        $this->menuService->store($params);

        return redirect()->route('menus.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Menu $menu)
    {
        $menu->parent_name = $menu->parent()->get('name')->first();
        $listMenu = $this->menuService->index();
        $indexCurrentTypeMenu = null;
        $listMenuAssociate = [];

        if ($menu->menuable_type == 'App\Models\Post') {
            $indexCurrentTypeMenu = config('common.menu.type.post');
            $listMenuAssociate = $this->postService->index()->pluck('title', 'id');
        }

        if ($menu->menuable_type == 'App\Models\Page') {
            $indexCurrentTypeMenu = config('common.menu.type.page');
            $listMenuAssociate = $this->pageService->index()->pluck('name', 'id');
        }

        $arrPushToComponent = [
            'listSelectMenu' => $listMenu->except($menu->id)->pluck('name', 'id'),
            'parentMenu' => $menu->only('parent_id', 'parent_name'),
            'order' => $request->order,
            'associatedMenuId' => $menu->menuable->id,
            'typeMenuWantAssociate' => array_flip(config('common.menu.type')),
            'indexCurrentTypeMenu' => $indexCurrentTypeMenu,
            'listMenuAssociate' => $listMenuAssociate,
        ];

        $compact = [
            'menu' => $menu,
            'arrPushToComponent' => $arrPushToComponent,
        ];

        return view('menus.edit', $compact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $params = $request->only('name', 'parent_id', 'order', 'type_of_menu', 'menu_associate');
        $this->menuService->update($params, $menu);

        return redirect()->route('menus.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $this->menuService->destroy($menu);
        
        return redirect()->route('menus.index');
    }
}
