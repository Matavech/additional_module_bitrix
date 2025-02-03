<?php

namespace Bitrix\Related\Internals\Integration\Crm;

use Bitrix\Main\Loader;

class CrmControlPanelBuildListener
{
    public static function onAfterCrmControlPanelBuild(array &$items)
    {
        if (!Loader::includeModule("related"))
        {
            return;
        }

        $item = [
            'ID' => 'RELATED_PRODUCTS',
            'TEXT' => 'Связанные продукты',
            'URL' => '/related/products/',
        ];

        $items[] = $item;
    }
}