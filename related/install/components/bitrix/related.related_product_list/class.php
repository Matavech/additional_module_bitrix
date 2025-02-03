<?php

declare(strict_types=1);

namespace Bitrix\Related\Components;

use Bitrix\Main\Grid\Options;
use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\PageNavigation;
use Bitrix\Related\Provider\Params\GridParams;
use Bitrix\Related\Provider\Params\RelatedProduct\RelatedProductFilter;
use Bitrix\Related\Provider\Params\RelatedProduct\RelatedProductSort;
use Bitrix\Related\Provider\Params\RelatedProduct\RelatedProductSelect;
use Bitrix\Related\Provider\RelatedProductProvider;
use Bitrix\Main\UI\Filter\Options as FilterOptions;

class RelatedProductList extends \CBitrixComponent
{
    private const MODULE_NAME = 'related';
    private const GRID_ID = 'RELATED_PRODUCTS_GRID';
    private const FILTER_ID = 'RELATED_PRODUCTS_FILTER';

    private Options $gridOptions;
    private PageNavigation $pageNavigation;
    private RelatedProductFilter $filter;
    private RelatedProductProvider $provider;

    public function executeComponent(): void
    {
        if (!Loader::includeModule(self::MODULE_NAME))
        {
            showError(Loc::getMessage('RELATED_RELATED_PRODUCT_LIST_MODULE_NOT_INSTALLED'));
            return;
        }

        $this->initParams();
        $this->includeComponentTemplate();
    }

    private function initParams(): void
    {
        $this->gridOptions = new Options(self::GRID_ID);
        $this->pageNavigation = $this->initPageNavigation();
        $this->filter = $this->initFilter();
        $select = new RelatedProductSelect($this->gridOptions->GetVisibleColumns());
        $sort = $this->gridOptions->getSorting(['sort' => ['ID' => 'DESC']])['sort'];
        $this->provider = new RelatedProductProvider();

        $params = new GridParams(
            limit: $this->pageNavigation->getLimit(),
            offset: $this->pageNavigation->getOffset(),
            filter: $this->filter,
            sort: new RelatedProductSort($sort),
            select: $select
        );

        $items = $this->provider->getList($params, true);
        $totalCount = $items->getTotalCount();
        $this->pageNavigation->setRecordCount($totalCount);

        $this->arResult = [
            'ITEMS' => $items->toGrid(),
            'NAV_OBJECT' => $this->pageNavigation,
            'TOTAL_COUNT' => $totalCount,
        ];

        $this->setupGrid();
        $this->setFilterParams();
    }

    private function setFilterParams(): void
    {
        $this->arResult['FILTER_PARAMS'] = [
            'FILTER_ID' => self::FILTER_ID,
            'GRID_ID' => self::GRID_ID,
            'FILTER' => [
                [
                    'id' => 'ID',
                    'name' => Loc::getMessage('RELATED_RELATED_PRODUCT_LIST_FILTER_ID'),
                    'type' => 'number',
                ],
                [
                    'id' => 'TITLE',
                    'name' => Loc::getMessage('RELATED_RELATED_PRODUCT_LIST_FILTER_TITLE'),
                    'type' => 'string',
                ],
                [
                    'id' => 'PRICE',
                    'name' => Loc::getMessage('RELATED_RELATED_PRODUCT_LIST_FILTER_PRICE'),
                    'type' => 'number',
                ],
                [
                    'id' => 'DEAL_ID',
                    'name' => Loc::getMessage('RELATED_RELATED_PRODUCT_LIST_FILTER_DEAL_ID'),
                    'type' => 'number',
                ],
            ],
            'ENABLE_LABEL' => true,
        ];
    }

    private function initPageNavigation(): PageNavigation
    {
        $navParams = $this->gridOptions->GetNavParams();
        $pageNavigation = new PageNavigation(self::GRID_ID);
        $pageNavigation->setPageSize((int)$navParams['nPageSize'])->initFromUri();

        return $pageNavigation;
    }

    private function initFilter(): RelatedProductFilter
    {
        $filterOptions = new FilterOptions(self::FILTER_ID);
        $filterData = $filterOptions->getFilterLogic(RelatedProductFilter::getSourceList());

        $searchString = $filterOptions->getSearchString();
        if ($searchString !== '')
        {
            $filterData['TITLE%'] = $searchString;
        }

        return new RelatedProductFilter($filterData);
    }

    private function setupGrid(): void
    {
        $this->arResult['GRID'] = [
            'GRID_ID' => self::GRID_ID,
            'HEADERS' => $this->getGridHeaders(),
            'ROWS'    => $this->arResult['ITEMS'],
            'NAV_OBJECT' => $this->arResult['NAV_OBJECT'],
            'SHOW_ROW_CHECKBOXES' => false,
            'AJAX_MODE' => 'Y',
            'AJAX_OPTION_HISTORY' => 'N',
            'AJAX_OPTION_JUMP' => 'N',
            'TOTAL_ROWS_COUNT' => $this->arResult['TOTAL_COUNT'],
            'PAGE_SIZES' => [
                ['NAME' => '5', 'VALUE' => '5'],
                ['NAME' => '10', 'VALUE' => '10'],
                ['NAME' => '20', 'VALUE' => '20'],
                ['NAME' => '50', 'VALUE' => '50'],
                ['NAME' => '100', 'VALUE' => '100'],
            ],
            'SHOW_PAGESIZE' => true,
            'SHOW_PAGINATION' => true,
            'SHOW_NAVIGATION_PANEL' => true,
        ];
    }

    private function getGridHeaders(): array
    {
        return [
            ['id' => 'ID', 'name' => Loc::getMessage('RELATED_RELATED_PRODUCT_LIST_ID'), 'default' => true, 'sort' => 'ID'],
            ['id' => 'TITLE', 'name' => Loc::getMessage('RELATED_RELATED_PRODUCT_LIST_TITLE'), 'default' => true],
            ['id' => 'PRICE', 'name' => Loc::getMessage('RELATED_RELATED_PRODUCT_LIST_PRICE'), 'default' => true, 'sort' => 'PRICE'],
            ['id' => 'DEAL_ID', 'name' => Loc::getMessage('RELATED_RELATED_PRODUCT_LIST_DEAL_ID'), 'default' => true, 'sort' => 'DEAL_ID'],
            ['id' => 'CREATED_AT', 'name' => Loc::getMessage('RELATED_RELATED_PRODUCT_LIST_CREATED_AT'), 'default' => true],
        ];
    }
}
