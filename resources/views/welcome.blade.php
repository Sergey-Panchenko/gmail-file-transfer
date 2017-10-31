<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FILE TRANSFER</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">

</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content">
        <div class="links">
            @if(!empty($gmailAuth['url']))
                @if(!empty($gmailAuth['authorized']))
                    <a style="color: #f44336;" href="{{route('gmail-logout')}}">Log Out First User</a>
                @else
                    <a href="{{$gmailAuth['url']}}">Log IN First User (GMAIL)</a>
                @endif
            @endif
        </div>
        <div class="links">
            @if(!empty($driveAuth['url']))
                @if(!empty($driveAuth['authorized']))
                    <a style="color: #f44336;" href="{{route('drive-logout')}}">Log Out Second User</a>
                @else
                    <a href="{{$driveAuth['url']}}">Log IN Second User (Google Drive)</a>
                @endif
            @endif
        </div>
        <div class="links">
            <a href="{{route('transfer')}}">START TRANSFER</a>
        </div>
        <div class="links">
            @if( !empty(session('transferredFiles')) )
                <h3>These files were transferred : </h3>
                @foreach(session('transferredFiles') as $fileName)
                    {{ $fileName }} <br>
                @endforeach
            @endif
        </div>

        @if( session('error') )
            {{ session('error') }}
        @endif
    </div>
</div>
</body>
</html>
