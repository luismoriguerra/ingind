<?php namespace Chat\Repositories\Message;

use Chat\Repositories\DbRepository;

class DBMessageRepository extends DbRepository implements MessageRepository {

    /**
     * @var Message
     */
    private $model;

    public function __construct(Message $model) 
    {
        $this->model = $model;
    }
}
