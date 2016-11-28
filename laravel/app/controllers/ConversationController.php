<?php

use Chat\Repositories\Conversation\ConversationRepository;
use Chat\Repositories\User\UserRepository;

class ConversationController extends \BaseController {

    /**
     * @var Chat\Repositories\Conversation\ConversationRepository
     */
    private $conversationRepository;

    /**
     * @var Chat\Repositories\User\UserRepository
     */ 
    private $userRepository;

    public function __construct(ConversationRepository $conversationRepository, UserRepository $userRepository) 
    {
        $this->conversationRepository = $conversationRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of conversations.
     *
     * @return Response
     */
    public function index() 
    {
        $viewData = array();

        $users = $this->userRepository->getAllExcept(Auth::user()->id);

        foreach($users as $key => $user) {
            $viewData['recipients'][$user->id] = $user->username;
        }
        //validacion cuando se envia mensaje por primera ves
        try {
            $viewData['current_conversation'] = $this->conversationRepository->getByName(Input::get('conversation'));
        } catch (Exception $e) {
            $viewData['current_conversation']= Conversation::where('name', Input::get('conversation'))->first();
        }
        
        $viewData['conversations'] = Auth::user()->conversations()->get();
        ///armando json
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
        
        $response = [
            'conversations'=>$conversations,
            'current_conversation'=>$viewData['current_conversation']
        ];
        return Response::json($response);

        return View::make('templates/conversations', $viewData);
    }

    /**
     * Store a newly created conversation in storage.
     *
     * @return Response
     */
    public function store() 
    {

        $rules = array(
            'users' => 'required|array',
            'body'  =>  'required'
        );

        $validator = Validator::make(Input::only('users', 'body'), $rules);

        if($validator->fails()) {
            return Response::json([
                'success' => false,
                'result' => $validator->messages()
            ]);
        }

        // Create Conversation
        $params = array(
            'created_at' => new DateTime,
            'name'          => str_random(30),
            'author_id'  => Auth::user()->id
        );

        $conversation = Conversation::create($params);

        //aqui para cancelar el registro en conversacion user
        $conversation->users()->attach(Input::get('users'));
        $conversation->users()->attach(array(Auth::user()->id));

        // Create Message
        $params = array(
            'conversation_id' => $conversation->id,
            'body'               => Input::get('body'),
            'user_id'           => Auth::user()->id,
            'created_at'      => new DateTime
        );

        $message = Message::create($params);

        // Create Message Notifications
        $messages_notifications = array();

        foreach(Input::get('users') as $user_id) {
            array_push($messages_notifications, new MessageNotification(array('user_id' => $user_id, 'read' => false, 'conversation_id' => $conversation->id)));

            // Publish Data To Redis
            $data = array(
                'room'    => $user_id,
                'message' => array('conversation_id' => $conversation->id)
            );

            Event::fire(ChatConversationsEventHandler::EVENT, array(json_encode($data)));
        }

        $message->messages_notifications()->saveMany($messages_notifications);
        return [];
        return Redirect::route('chat.index', array('conversation', $conversation->name));
    }
}
