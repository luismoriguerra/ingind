@foreach($messages as $message)
    <div class="message">
        <div class="media msg ">
            <small class="pull-right time"><i class="fa fa-clock-o"></i> {{ $message->created_at }}</small>
            <a class="pull-left" href="#">
                <img class="media-object img-circle" width="30" height="30" src="img/user/{{ md5('u'.$message->user->id).'/'.$message->user->imagen }}">
            </a>
            <div class="media-body">
                <h5 class="media-heading">{{ $message->user->username }}</h5>
                <small>{{ $message->body }}</small>
            </div>
        </div>
    </div>
@endforeach
