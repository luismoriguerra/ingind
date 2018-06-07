<?php
use Chat\Repositories\User\UserRepository;
use Chat\Repositories\Area\AreaRepository;
class AreaUserController extends \BaseController
{
    protected $_errorController;
    /**
     * @var Chat\Repositories\AreaRepository
     */
    private $areaRepository; 
    /**
      * @var Chat\Repositories\UserRepository
     */
    private $userRepository;
    /**
     *
     */    
    public function __construct(
        ErrorController $ErrorController,
        AreaRepository $areaRepository,
        UserRepository $userRepository
    ) {
        $this->beforefilter('auth');
        $this->_errorController = $ErrorController;
        $this->areaRepository = $areaRepository;
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing.
     *
     * @return Response
     */
    public function index() {
        $areas = $this->areaRepository->getAllActives();
        $response=[
            'areas' => $areas,
        ];
        return Response::json($response);
    }

    public function postListar()
    {
        if ( Request::ajax() ) {
            $a      = new Area;
            $listar = Array();
            $listar = $a->getAreaUser();
         
            return Response::json(
                array(
                    'rst'   => 1,
                    'datos' => $listar
                )
            );
        }
    }

}