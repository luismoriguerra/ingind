<?php

class ConversationController extends \BaseController {

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
        //buscar en conversations_users, si el Input::get('users') y array(Auth::user()->id) ya pertenecen a la misma conversation_id
        $users = array_merge(Input::get('users'),[(string)Auth::user()->id]);
        
        $conversationsUsers = ConversationUser::whereIn('user_id',$users)
                ->groupBy('conversation_id')
                ->havingRaw("COUNT(user_id)>1")
                ->first();
        if (count($conversationsUsers)>0) {
            $conversation=Conversation::find($conversationsUsers->conversation_id);
        } else {
            $conversation = Conversation::create($params);
            $conversation->users()->attach(Input::get('users'));
            $conversation->users()->attach(array(Auth::user()->id));
        }

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
                'conversation_name' =>$conversation->name,
                'message' => array('conversation_id' => $conversation->id)
            );

            Event::fire(ChatConversationsEventHandler::EVENT, array(json_encode($data)));
        }

        $message->messages_notifications()->saveMany($messages_notifications);
        return Response::json(['conversation'=> $conversation->name,'data'=>$data]);
    }
}
