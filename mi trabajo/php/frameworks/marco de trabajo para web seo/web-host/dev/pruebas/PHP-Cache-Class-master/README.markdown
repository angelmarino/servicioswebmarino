# PHP Cache Class

#### Author

* Miquel Camps Orteza
* [@miquelcamps](https://twitter.com/miquelcamps)

#### Initialize

```php
require 'cache.php';

$cache = new Cache();
$cache->path = 'cache/';
$cache->life = 3600*24;
```

#### Load cache

```php
$content = $cache->get('list.html');
if( $content ){
	echo $content;
	exit();
}
```

#### Start to caching to buffer

```php
$cache->start();
```

#### Save cache and show buffer data

```php
$cache->finish();
$cache->save();
echo $cache->content;	
```