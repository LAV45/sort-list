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
    /**
     * @var string
     */
    public $prefix = '- ';
    /**
     * @var string
     */
    public $attrID = 'id';
    /**
     * @var string
     */
    public $attrParentID = 'parent_id';
    /**
     * @var string
     */
    public $attrTitle = 'title';
    /**
     * @var array
     */
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param integer $category_id
     * @param string $prefix
     * @return string
     */
    protected function getPath($category_id, $prefix = '')
    {
        foreach ($this->data as $item) {
            if ($category_id == $item[$this->attrID]) {
                $prefix = $prefix ? $this->prefix . $prefix : $item[$this->attrTitle];
                if ($item[$this->attrParentID]) {
                    return $this->getPath($item[$this->attrParentID], $prefix);
                } else {
                    return $prefix;
                }
            }
        }
        return '';
    }

    /**
     * @param null|integer $parent_id
     * @return array
     */
    public function getList($parent_id = null)
    {
        $data = [];

        foreach ($this->data as $item) {
            if ($parent_id === $item[$this->attrParentID]) {
                $data[] = [
                    $this->attrID => $item[$this->attrID],
                    $this->attrTitle => $this->getPath($item[$this->attrID])
                ];
                $data = array_merge($data, $this->getList($item[$this->attrID]));
            }
        }

        return $data;
    }
}