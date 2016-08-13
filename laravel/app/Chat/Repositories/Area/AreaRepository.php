<?php namespace Chat\Repositories\Area;

interface AreaRepository {
    
    /**
     * Fetch a record by id
     * 
     * @param $id
     */
    public function getById($id);

    /**
     * Fetch all users except the one specified by the id
     *
     * @param $id;
     */
    public function getAllExcept($id);
}
