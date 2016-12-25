<?php

use Chat\Repositories\Conversation\ConversationRepository;

class ChatController extends \BaseController {

    /**
     * @var LaravelRealtimeChat\Repositories\ConversationRepository
     */
    private $conversationRepository; 

    public function __construct(ConversationRepository $conversationRepository)
    {
        $this->conversationRepository = $conversationRepository;
    }

    /**
     * Display the chat
     *
     * @return Response
     */
    public function conversation() {
        $current_conversation = false;
        if(Input::has('conversation')) {
            $current_conversation = $this->conversationRepository->getByName(Input::get('conversation'));
        } /*else {
            $current_conversation = Auth::user()->conversations()->first();
        }*/
        if ($current_conversation) {
            Session::set('current_conversation', $current_conversation->name);
            foreach($current_conversation->messages_notifications as $notification) {
                $notification->read = true;
                $notification->save();
            }
        } else {
            $current_conversation = new stdClass() ;
            $current_conversation->name=null;
        }

        $messages=[];
        $conversations = Auth::user()->conversations->map(function($conversation) use (&$current_conversation)
        {
            $users=$conversation->users->map(function($user){
                return [
                    'img'       => $user->img,
                    'full_name' => $user->nombre." ".$user->paterno." ".$user->materno,
                    'area'      => $user->area_id,
                ];
            });
            $current=false;
            if ($conversation->name==$current_conversation->name){
                $current_conversation->messages = $conversation->messages->map(function($message){
                    return [
                        'created_at'    => $message->created_at->format('Y-m-d H:i:s'),
                        'user'          => $message->user,
                        'img'           => $message->user->img,
                        //'nemonico'      => $message->user->areas->nemonico,
                        'body'          => $message->body,
                    ];
                });
                $current=true;
            }
            return [
                'users'    => $users,
                'messages' => $conversation->messages,
                'name' => $conversation->name,
                'messages_notifications_count'=> $conversation->messages_notifications->count(),
                'last_message'=> Str::words($conversation->messages->last()->body, 5),
                'current'=> $current,
            ];
        });
        $response=[
            'current_conversation'   =>$current_conversation,
            'conversations'   =>$conversations,
            //'messages'   =>$messages,
        ];
        return Response::json($response);
    }
}
