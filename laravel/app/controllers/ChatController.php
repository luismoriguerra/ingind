<?php

use Chat\Repositories\Conversation\ConversationRepository;
use Chat\Repositories\Area\AreaRepository;
//use Chat\Repositories\User\UserRepository;
    
class ChatController extends \BaseController {

    /**
     * @var Chat\Repositories\ConversationRepository
     */
    private $conversationRepository; 

    /**
     * @var Chat\Repositories\UserRepository
     */
    //private $userRepository; 

    /**
     * @var Chat\Repositories\AreaRepository
     */
    private $areaRepository; 

    public function __construct(ConversationRepository $conversationRepository,
        AreaRepository $areaRepository
        /*, UserRepository $userRepository*/)
    {
        $this->conversationRepository = $conversationRepository;
        //$this->userRepository = $userRepository;
        $this->areaRepository = $areaRepository;
    }

    /**
     * Display the chat index.
     *
     * @return Response
     */
    public function index() {
        $viewData = array();

        if(Input::has('conversation')) {
            $viewData['current_conversation'] = $this->conversationRepository->getByName(Input::get('conversation'));
        } else {
            $viewData['current_conversation'] = Auth::user()->conversations()->first();
        }

        if($viewData['current_conversation']) {
            Session::set('current_conversation', $viewData['current_conversation']->name);
    
            foreach($viewData['current_conversation']->messages_notifications as $notification) {
                $notification->read = true;
                $notification->save();
            }
        }
        
        $areas = $this->areaRepository->getAllActives();
        foreach($areas as $key => $area) {
            $viewData['areas'][$area->id] = $area->nombre;
        }

        //$areas = Area::all();
        /*$areas = Area::all();
        foreach($areas as $key => $area) {
            $viewData['areas'][$area->id] = $area->nombre;
        }*/
        
        $viewData['conversations'] = Auth::user()->conversations()->get();
        return View::make('templates/chat', $viewData);
    }
    /**
     * Display the chat index.
     *
     * @return Response
     */
    public function conversation() {
        $viewData = array();

        if(Input::has('conversation')) {
            $viewData['current_conversation'] = $this->conversationRepository->getByName(Input::get('conversation'));
        } else {
            $viewData['current_conversation'] = Auth::user()->conversations()->first();
        }

        if($viewData['current_conversation']) {
            Session::set('current_conversation', $viewData['current_conversation']->name);
    
            foreach($viewData['current_conversation']->messages_notifications as $notification) {
                $notification->read = true;
                $notification->save();
            }
        }
        
        $areas = $this->areaRepository->getAllActives();
        foreach($areas as $key => $area) {
            $viewData['areas'][$area->id] = $area->nombre;
            $areasObj[$area->id] = $area->nombre;
        }
        
        $viewData['conversations'] = Auth::user()->conversations()->get();

        $conversations=$messagesObj=[];
        foreach($viewData['conversations'] as $conversation) {
            $conversationObj['name']= $conversation->name;
            $conversationObj['messages_notifications_count']= $conversation->messages_notifications->count();
            $conversationObj['body']= Str::words($conversation->messages->last()->body, 5);

            foreach($conversation->users as $key => $user) {
                $userObj['img'] = $user->img;
                $userObj['full_name'] = $user->full_name;
                $userObj['area'] = $user->areas->nombre;
                $userObj['count'] = $conversation->users->count();
                $conversationObj['users'][$key]=$userObj;
            }
            $conversations[] = $conversationObj;
        }
        if (count($viewData['current_conversation'])>0) {
            foreach($viewData['current_conversation']->messages as $message){
                $messageObj['created_at']=$message->created_at;
                $messageObj['img']=$message->user->img;
                $messageObj['area_nemonico']='sin area';
                if (isset($message->user->areas->nemonico))
                    $messageObj['area_nemonico']=$message->user->areas->nemonico;
                $messageObj['user_nombre']=$message->user->nombre;
                $messageObj['body']=$message->body;
                $messagesObj[]=$messageObj;
            }
        }
        $response = [
            'conversations'=>$conversations,
            'current_conversation'=>$viewData['current_conversation'],
            'messages'=>$messagesObj,
            'areas'=>$areasObj,
        ];
        return Response::json($response);
    }
}
