<?php namespace Chat\Repositories\Message;

interface MessageRepository {

    /**
     * Fetch a message by id
     *
     * @param $id
     */
    public function getById($id);
}
