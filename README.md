# packagist-boilerplate h1
Put some helpfull description here

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