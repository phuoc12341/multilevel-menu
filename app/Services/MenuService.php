<?php

namespace App\Services;

use App\Repo\MenuRepositoryInterface;
use App\Repo\PostRepositoryInterface;
use App\Repo\PageRepositoryInterface;
use App\Models\Menu;
use App\Models\Post;
use App\Models\Page;
use App;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class MenuService extends BaseService
{
    /**
     * @var \App\Repo\MenuRepositoryInterface
     */
    protected $menuRepository;
    protected $postRepository;
    protected $pageRepository;

    /**
     *
     * @param \App\Repo\MenuRepositoryInterface $menuRepository
     */
    public function __construct(MenuRepositoryInterface $menuRepository, PostRepositoryInterface $postRepository, PageRepositoryInterface $pageRepository)
    {
        $this->menuRepository = $menuRepository;
        $this->postRepository = $postRepository;
        $this->pageRepository = $pageRepository;
    }

    public function findByDepth(string $depth, string $parent_id, string $exceptId)
    {
        $menu = $this->menuRepository->findByDepth($depth, $parent_id, $exceptId);

        return $menu;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index()
    {
        $listMenu = $this->menuRepository->fetchAll();

        return $listMenu;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $params
     * @return \Illuminate\Http\Response
     */
    public function store(array $params)
    {
        $params['parent_id'] = isset($params['parent_id']) ? $params['parent_id'] : null;
        $menu = $this->menuRepository->store($params);
        $dataForUpdatePolymorphic = array_only($params, ['type_of_menu', 'menu_associate']);
        $this->updatePolymorphicModel($dataForUpdatePolymorphic, $menu);

        if (isset($params['order'])) {
            $this->recalculateNodeOrder($params['parent_id'], $params['order'], $menu);
        }

        return true;
    }

    public function update(array $params, Menu $menu)
    {
        $data = array_only($params, ['name', 'parent_id']);
        $this->menuRepository->update($menu->id, $data);
        $dataForUpdatePolymorphic = array_only($params, ['type_of_menu', 'menu_associate']);
        $this->updatePolymorphicModel($dataForUpdatePolymorphic, $menu);

        if (isset($params['order'])) {
            $this->recalculateNodeOrder($params['parent_id'], $params['order'], $menu);
            // doan nay du em ko thay doi order nhung van bi tinh toan lai, anh co cach nao ko
        }

        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\Post  $post
     * 
     */
    public function destroy(Menu $post)
    {
        return $this->menuRepository->deleteById($post->id);
    }

    public function updatePolymorphicModel(array $params, Menu $menu)
    {
        if ($params['type_of_menu'] == config('common.menu.type.post')) {
            $post = $this->postRepository->findById($params['menu_associate']);
            $this->postRepository->attachModelToParent($post->id, $menu);
        }
        if ($params['type_of_menu'] == config('common.menu.type.page')) {
            $page = $this->pageRepository->findById($params['menu_associate']);
            $this->pageRepository->attachModelToParent($page->id, $menu);
        }

        return true;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList()
    {
        $paginatedMenu = $this->menuRepository->paginateList(null, ['*'], 'lft', 'asc');
        $collectionOfPaginatedMenu = $paginatedMenu->getCollection();
        $this->calculateOrderAttribute($collectionOfPaginatedMenu);
        $this->menuRepository->loadParentRelation($collectionOfPaginatedMenu);

        return $paginatedMenu;
    }

    public function recalculateNodeOrder($parent_id, $orderOfNode, Menu $menu)
    {
        $parentNode = $this->menuRepository->findById($parent_id);
        $immediateDescendantsOfParentNode = $parentNode->getImmediateDescendants();
        $countImmediateDescendantsOfParentNode = $immediateDescendantsOfParentNode->count();    
        if ( $orderOfNode < $countImmediateDescendantsOfParentNode) {
            $edgeNode = $immediateDescendantsOfParentNode->get($orderOfNode - 1);
            if ( $menu->id !== $edgeNode->id ) {
                $menu->moveToLeftOf($edgeNode);
            }
        } else {
            $menu->makeLastChildOf($parentNode);
        }

        return true;
    }

    public function calculateOrderAttribute($listMenu)
    {
        foreach ($listMenu as $node) {
            if ( $node->isRoot() ) {
                $parentNode = $node;
                $order = 0;
                $node->order = null;
            } else {
                if ($node->isDescendantOf($parentNode) ) {
                    $node->order = ++$order;
                } else {
                    $parentNode = $node->parent;
                    $node->order = 1;
                }
            }
        }

        return true;
    }

    public function getListWithoutOrderAttribute()
    {
        $listMenu = $this->menuRepository->getRootMenu();
        if ($listMenu != null) {
            $listMenu = $listMenu->getDescendants()->toHierarchy();
        } else {
            $listMenu = collect([]);
        }

        return $listMenu;
    }

    public function getRootMenu()
    {
        return $this->menuRepository->getRootMenu();
    }

        public function changeOrderMenu(array $arrMenu, string $idChangedNode)
    {
        $rootNode = $this->getRootMenu();
        $rootNode->makeTree($arrMenu);

        $arrMenuflattened = Arr::flatten($arrMenu);
        $indexOfChangedNode = array_search($idChangedNode, $arrMenuflattened);
        $changedNode = $this->menuRepository->findbyId($idChangedNode);

        if ($indexOfChangedNode == 0) {
            $changedNode->makeFirstChildOf($rootNode);
        }

        if ($indexOfChangedNode > 0) {
            $this->reOrderWithIndexGreaterThanZero([
                'changedNode' => $changedNode,
                'rootNode' => $rootNode,
                'indexOfChangedNode' => $indexOfChangedNode,
                'arrMenuflattened' => $arrMenuflattened,
                'idChangedNode' =>$idChangedNode
            ]);
        }

        return true;
    }

    public function reOrderWithIndexGreaterThanZero(array $params)
    {
        $indexOfParentOrSiblingOfChangedNode = $params['indexOfChangedNode'] - 1;
        $idBeforeNodeOfChangedNode = Arr::get($params['arrMenuflattened'], $indexOfParentOrSiblingOfChangedNode);
        $beforeNode = $this->menuRepository->findById($idBeforeNodeOfChangedNode);
        if ($beforeNode->id == $params['changedNode']->parent_id) {
            $this->reOrderWithMenuFirChildOfBef($params['changedNode'], $beforeNode);
        } elseif ($beforeNode->parent_id == $params['changedNode']->parent_id) {
            $this->reOrderWhenMenuNextSibOfBef($params['changedNode'], $beforeNode);
        } elseif ($params['indexOfChangedNode'] < (count($params['arrMenuflattened']) - 1) && $params['indexOfChangedNode'] != 0) {
            $this->reOrderWhenMenuNotFirChildNotSibOfBef([
                'changedNode' => $params['changedNode'],
                'rootNode' => $params['rootNode'],
                'indexOfChangedNode' => $params['indexOfChangedNode'],
                'arrMenuflattened' => $params['arrMenuflattened'],
            ]);
        } elseif (last($params['arrMenuflattened']) == $params['idChangedNode']) {
            $params['changedNode']->makeLastChildOf($params['rootNode']);
        }

        return true;
    }

    public function reOrderWithMenuFirChildOfBef(Menu $changedNode, Menu $beforeNode)
    {
        $changedNode->makeRoot();
        $changedNode->makeFirstChildOf($beforeNode);

        return true;
    }

    public function reOrderWhenMenuNextSibOfBef(Menu $changedNode, Menu $beforeNode)
    {
        $changedNode->makeRoot();
        $changedNode->makeNextSiblingOf($beforeNode);

        return true;
    }

    public function reOrderWhenMenuNotFirChildNotSibOfBef(array $params)
    {
        $indexOfNextOrSiblingOfChangedNode = $params['indexOfChangedNode'] + 1;
        $idNextNodeOfChangedNode = Arr::get($params['arrMenuflattened'], $indexOfNextOrSiblingOfChangedNode);
        $nextNode = $this->menuRepository->findById($idNextNodeOfChangedNode);
        if ($nextNode->parent_id == $params['changedNode']->parent_id) {
            $this->reOrderWhenPrevSibOfNext($params['changedNode'], $nextNode);
        } else {
            $this->reOrderWhenInAnotherCaseLeft($params['changedNode'], $params['arrMenuflattened']);
        }
    }

    public function reOrderWhenPrevSibOfNext(Menu $changedNode, Menu $nextNode)
    {
        $changedNode->makeRoot();
        $changedNode->makePreviousSiblingOf($nextNode);

        return true;
    }

    public function reOrderWhenInAnotherCaseLeft(Menu $changedNode, array $arrMenuflattened)
    {
        $listId = $this->findByDepth($changedNode->depth, $changedNode->parent_id, $changedNode->id);
        foreach ($arrMenuflattened as $value) {
            if ($value == $changedNode->id) {
                break;
            } 
            if (in_array($value, $listId)) {
                $idPreviousSibling = $value;
            }
        }
        $previousSiblingNode = $this->menuRepository->findById($idPreviousSibling);
        $changedNode->makeRoot();
        $changedNode->makeNextSiblingOf($previousSiblingNode);

        return true;
    }    
}
