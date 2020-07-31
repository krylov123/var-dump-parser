# var-dump-parser
Parse var_dump's output back to PHP object.

At the moment supports only the plain array (inc. associative, but not multidimensional) and scalar types.

#Example

```php

$string = "
/var/www/var-dump-parser/test.php:9:
array(3) {
  'as' =>
  int(123123)
  [0] =>
  int(12312321)
  [1] =>
  int(3123)
}
";

$parser = new \Krylov123\VarDumpParser();

$array = $parser->parseOutput($string);

```

## Working with versions:

```bash
#list all your versions
git tag -l

#add version
git -a 0.0.1 -m "First version" 

#pushing the tags
git push --tags
```

## Run tests

```bash
composer install

./vendor/bin/phpunit tests
```