<?php namespace Chat\Repositories\Area;

use Chat\Repositories\DbRepository;

class DbAreaRepository extends DbRepository implements AreaRepository {

    /**
     * @var Area
     */
    private $model;

    public function __construct(\Area $model)
    {
        $this->model = $model;
    }

    public function getAllExcept($id)
    {
        return $this->model->where('id', '<>', $id)->get();
    }
    public function getAllActives()
    {
        return $this->model
        ->where('estado', 1)
        ->get();
    }
}
