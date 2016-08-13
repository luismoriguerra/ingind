<?php namespace Chat\Repositories\Conversation;

use Chat\Repositories\DbRepository;

class DbConversationRepository extends DbRepository implements ConversationRepository {

    /**
     * @var Conversation
     */
    private $model;

    public function __construct(\Conversation $model) 
    {
        $this->model = $model; 
    }

    public function getByName($name)
    {
        return $this->model->where('name', $name)->firstOrFail();
    }
}
