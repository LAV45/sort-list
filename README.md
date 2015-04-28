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

print_r($data);
/**
 * Array
 * (
 *    [0] => Array
 *        (
 *            [id] => 1
 *            [parent_id] => 
 *            [title] => Auto
 *        )
 *
 *    [1] => Array
 *        (
 *            [id] => 2
 *            [parent_id] => 1
 *            [title] => Car
 *        )
 *
 *    [2] => Array
 *        (
 *            [id] => 3
 *            [parent_id] => 1 
 *            [title] => Motorcycle
 *        )
 * )
 */

$sortList = (new SortList($data))->getList();

print_r($sortList);
/**
 * Array
 * (
 *    [0] => Array
 *        (
 *            [id] => 1
 *            [title] => Auto
 *        )
 *
 *    [1] => Array
 *        (
 *            [id] => 2
 *            [title] => - Car
 *        )
 *
 *    [2] => Array
 *        (
 *            [id] => 3
 *            [title] => - Motorcycle
 *        )
 * )
 */

$dropDownList = ArrayHelper::map($sortList, 'id', 'title');

print_r($sortList);
/**
 * Array
 * (
 *     [1] => Auto
 *     [2] => - Car
 *     [3] => - Motorcycle
 * )
 */
```
