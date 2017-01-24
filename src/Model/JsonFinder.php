<?php

namespace Model;

use Exception\HttpException;

class JsonFinder implements FinderInterface
{
	private $file = '../data/statuses.json';

	/**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll() {
        return $this->readJsonFile();
    }

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed      $id
     * @return null|mixed
     */
    public function findOneById($id) {
        $statuses = $this->readJsonFile();

        foreach ($statuses as $status) {
            if($status['id'] == $id) {
                return $status;
            }
        }
        throw new HttpException(404, 'Status not found');
    }

    public function addOne($id) {
        //todo this method
    }

    public function readJsonFile() {
        $jsonDataDecode = json_decode(file_get_contents($this->file), true);

        if($jsonDataDecode === false) {
            //todo EXCEPTION
            echo 'NOON';
            exit();
        }
        return $jsonDataDecode;
    }

    public function saveJsonFile() {
    }
}
