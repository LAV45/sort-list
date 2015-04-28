<?php
/**
 * @link https://github.com/LAV45/sort-list
 * @license http://opensource.org/licenses/BSD-2-Clause
 * @author Alexey Loban <lav451@gmail.com>
 */

namespace lav45;

/**
 * Class SortList
 *
 * $data = Category::find()
 *     ->select(['id', 'parent_id', 'title'])
 *     ->asArray()
 *     ->all();
 *
 * $sortList = (new SortList($data))->getList();
 *
 * return ArrayHelper::map($sortList, 'id', 'title');
 *
 */
class SortList
{
    /** @var string */
    public $prefix = '- ';

    /** @var array */
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    protected function getPath($category_id, $prefix = '')
    {
        foreach ($this->data as $item) {
            if ($category_id == $item['id']) {
                $prefix = $prefix ? $this->prefix . $prefix : $item['title'];
                if ($item['parent_id']) {
                    return $this->getPath($item['parent_id'], $prefix);
                } else {
                    return $prefix;
                }
            }
        }
        return '';
    }

    public function getList($parent_id = null)
    {
        $data = [];

        foreach ($this->data as $item) {
            if ($parent_id === $item['parent_id']) {
                $data[] = [
                    'id' => $item['id'],
                    'title' => $this->getPath($item['id'])
                ];
                $data = array_merge($data, $this->getList($item['id']));
            }
        }

        return $data;
    }
}