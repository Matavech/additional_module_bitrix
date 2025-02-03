The module integrates with Bitrix24 CRM and adds a "Related Products" tab to the Deal page. 
This tab displays a data grid with a list of related products. 
The grid supports filtering, sorting, and pagination.
Data is dynamically loaded via AJAX without requiring a page reload. 

## Install module

Clone repository to `${doc_root}/local/modules`

Install module using admin panel

## Setup modern Bitrix routing

Add `related.php` in `routing` section of `${doc_root}/bitrix/.settings.php` file:

```php
'routing' => ['value' => [
	'config' => ['related.php']
]],
```

Put following content into your `${doc_root}/index.php` file:

```php
<?php
require_once __DIR__ . '/bitrix/routing_index.php';
```

Replace following lines in your `${doc_root}/.htaccess` file:

```
-RewriteCond %{REQUEST_FILENAME} !/bitrix/urlrewrite.php$
-RewriteRule ^(.*)$ /bitrix/urlrewrite.php [L]

+RewriteCond %{REQUEST_FILENAME} !/index.php$
+RewriteRule ^(.*)$ /index.php [L]
```

## Symlinks for handy development

You probably want to make following symlinks:

```
local/components/hc -> local/modules/bitrix/install/components/related
local/routes/related.php -> local/modules/bitrix/install/routes/related.php
```