<?php
use Bitrix\Main\Grid\Options;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\Filter\Filter;
?>

<div class="related-product-list-grid">

    <div class="filter-container">
        <?php
        $APPLICATION->IncludeComponent(
            'bitrix:main.ui.filter',
            '',
            $arResult['FILTER_PARAMS']
        );
        ?>
    </div>

    <div class="grid-container">
        <?php
        $APPLICATION->IncludeComponent('bitrix:main.ui.grid', '', $arResult['GRID']);
        ?>
    </div>

</div>
