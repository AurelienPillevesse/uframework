<?php

namespace Model;

use Exception\HttpException;

class DatabaseFinder implements FinderInterface
{
    /**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll()
    {
        return '';
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
        throw new HttpException(404, 'Status not found');
    }

    public function addOne($username, $message)
    {
    }
}
