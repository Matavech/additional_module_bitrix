Модуль-интеграция с CRM. Добавляет вкладку на страницу CRM "Связанные товары". На странице отображает грид с связанными товарами, фильтром, постраничкой и сортировкой. 

Setup modern Bitrix routing
Add houseceeper.php in routing section of ${doc_root}/bitrix/.settings.php file:

'routing' => ['value' => [
	'config' => ['related.php']
]],
Put following content into your ${doc_root}/index.php file:

<?php
require_once __DIR__ . '/bitrix/routing_index.php';
Replace following lines in your ${doc_root}/.htaccess file:

-RewriteCond %{REQUEST_FILENAME} !/bitrix/urlrewrite.php$
-RewriteRule ^(.*)$ /bitrix/urlrewrite.php [L]

+RewriteCond %{REQUEST_FILENAME} !/index.php$
+RewriteRule ^(.*)$ /index.php [L]
