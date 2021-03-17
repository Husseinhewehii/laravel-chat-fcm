@extends('layouts.app')

@section('content')

    <style>

        .chat-container{
            display: flex;
            flex-direction: column;
        }
        .chat{
            border: 1px solid gray;
            border-radius: 3px;
            width:50%;
            padding: 0.5em;
        }

        .chat-left{
            background-color: #6cb2eb;
            align-self: flex-start;
        }

        .chat-right{
            background-color: #b3e8ca;
            align-self: flex-end;
        }

        .message-input-container{
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: white;
            border: 1px solid gray;
            padding: 1em;
        }
    </style>
<div class="container" style="margin-bottom: 480px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <div class="chat-container">
                        @if(count($chats) ===0)
                            <p>No Chats ..</p>
                        @endif
                        @foreach($chats as $chat)
                            @if($chat->sender_id == Auth::user()->id)
                                <p class="chat chat-right">
                                    <b>{{$chat->sender_name}}: </b><br>
                                    {{$chat->message}}
                                </p>
                            @else
                                <p class="chat chat-left">
                                    <b>{{$chat->sender_name}}: </b><br>
                                    {{$chat->message}}
                                </p>
                            @endif
                        @endforeach
                        {{--<p class="chat chat-left">--}}
                            {{--<b>Sender:</b><br>--}}
                            {{--Left Chat--}}
                        {{--</p>--}}
                        {{--<p class="chat chat-right">--}}
                            {{--<b>Sender:</b><br>--}}
                            {{--Right Chat--}}
                        {{--</p>--}}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="message-input-container">
        <form action="" method="POST">
            @csrf
            <div class="form-group">
                <label for="">Message</label>
                <input type="text" name="message" class="form-control">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">SEND MESSAGE</button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        const messaging = firebase.messaging();

        // Add the public key generated from the console here.
        messaging.getToken({vapidKey: "BKJGYytdXiuoWSWeNMIKUTN_RPHqzx0DTHooi6SCrKUF0ISuHcWNEA9oHHh7k6O1-wfjWrcmsYaJwFP7JBK7nwg"});

        function sendTokenToServer(fcm_token){
            const user_id = '{{Auth::user()->id}}';

            axios.post('api/save-token', {
                fcm_token, user_id
            }).then(res => {
                console.log(res);
            });
        }

        function retrieveToken(){
            // Get registration token. Initially this makes a network call, once retrieved
            // subsequent calls to getToken will return from cache.
            messaging.getToken().then((currentToken) => {
                if (currentToken) {
                    // Send the token to your server and update the UI if necessary
                    sendTokenToServer(currentToken);
                } else {
                    // Show permission request UI
                    console.log('No registration token available. Request permission to generate one.');
                    alert('please allow notifications');
                }
            }).catch((err) => {
                console.log('An error occurred while retrieving token. ', err);
                // ...
            });
        }
        retrieveToken();

        messaging.onTokenRefresh(() => {
            retrieveToken();
        });

        messaging.onMessage((payload) => {
            console.log('message erhaltet');
            console.log(payload);

            location.reload();
        });




    </script>
@endsection
