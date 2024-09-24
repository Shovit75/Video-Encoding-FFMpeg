<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://vjs.zencdn.net/7.21.1/video-js.css" rel="stylesheet">
    <script src="https://vjs.zencdn.net/7.21.1/video.min.js"></script>
</head>
<body>
    <h1 class="text-center mt-4">Encoded Video using FFMpeg and Video.js</h1>
    <br>
    <form action="{{route('store')}}" method="POST" class="text-center" enctype="multipart/form-data">
        @csrf
        <label for="name">Name</label>
        <input type="text" name="name">
        <label for="video">Video</label>
        <input type="file" name="video">
        <button type="submit" class="btn btn-success">Submit</button>
    </form>

    <div class="row px-5">
        @if($videoFiles)
            @foreach($videoFiles as $v)
                @if(strlen($v) < 28) <!-- exclude the bitrate videos -->
                    <div class="col-md-6 my-4 d-flex justify-content-around">
                        <video
                            id="my-video"
                            class="video-js vjs-default-skin"
                            controls
                            preload="auto"
                            autoplay
                            muted 
                            width="500" 
                            height="282" 
                            data-setup="{}">
                            <source src="{{ asset('storage/' . $v) }}" type="application/x-mpegURL">
                        </video>
                    </div>
                @endif
            @endforeach
        @else
            <h1 class="text-center pt-4">Nothing added</h1>
        @endif
    </div>

</body>
</html>
