<?php

use Bitrix\Main\Routing\Controllers\PublicPageController;
use Bitrix\Main\Routing\RoutingConfigurator;

return function (RoutingConfigurator $routes)
{
    //$routes->get('/', new PublicPageController('/local/modules/hc.houseceeper/views/house-list.php'));
   $routes->get('/related/products/', new PublicPageController('/local/modules/related/views/related-product-list.php'));
   $routes->post('/related/products/', new PublicPageController('/local/modules/related/views/related-product-list.php'));
};

/**
  mklink /D "C:\OSPanel\domains\finaltest\local/routes" "C:\OSPanel\domains\finaltest\local\modules\related\install\routes"
 */