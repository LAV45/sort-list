SortList
========
Sort items list and recursive add prefix to child items

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist lav45/sort-list "*"
```

or add

```
"lav45/sort-list": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension for Yii2 is installed, simply use it in your code by  :

```php
use lav45\SortList;

$data = Category::find()
    ->select(['id', 'parent_id', 'name' => 'title'])
    ->asArray()
    ->all();

$sortList = (new SortList($data))->getList();

$dropDownList = ArrayHelper::map($sortList, 'id', 'title');
```