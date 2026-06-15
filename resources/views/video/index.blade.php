<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Stream</title>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
</head>

<body>
    <h1>Live Stream</h1>
    <video id="video" controls autoplay style="width: 100%; height: auto;"></video>

    <script>
        if (Hls.isSupported()) {
            var video = document.getElementById('video');
            var hls = new Hls();
            hls.loadSource("{{ route('stream') }}");
            hls.attachMedia(video);
            hls.on(Hls.Events.MANIFEST_PARSED, function() {
                video.play();
            });
        } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
            // For Safari support
            video.src = "{{ route('stream') }}";
            video.addEventListener('canplay', function() {
                video.play();
            });
        }
    </script>
</body>

</html>
