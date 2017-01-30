<?php

namespace Model;

use Exception\HttpException;

class InMemoryFinder implements FinderInterface
{
    private $data = ['yo', 'yoo', 'yooo'];

    /*public function __construct() {
        $data[] = "1er status";
        $data[] = "2eme status";
        $data[] = "3eme status";
        $data[] = "4eme status";
    }*/

    /**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll()
    {
        return $this->data;
    }

    /**
     * Retrieve an element by its id.
     *
     * @param mixed $id
     *
     * @return null|mixed
     */
    public function findOneById($id)
    {
        if ($id < count($this->data)) {
            return $this->data[$id];
        }
        throw new HttpException(404, 'Status not found');
    }
}
