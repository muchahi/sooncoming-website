<!DOCTYPE html>
<html>

<head>
    <title>WebRTC Live Streaming</title>
    <script src="https://cdn.rawgit.com/peers/peerjs/master/dist/peerjs.min.js"></script>
</head>

<body>
    <h1>Live Streaming</h1>
    <video id="videoElement" autoplay></video>
    <script>
        const peer = new Peer();
        const videoElement = document.getElementById('videoElement');

        peer.on('call', function(call) {
            call.answer(videoElement); // Answer the call with an A/V stream.
            call.on('stream', function(stream) {
                videoElement.srcObject = stream; // Show stream in some video/canvas element.
            });
        });

        navigator.mediaDevices.getUserMedia({
                video: true,
                audio: true
            })
            .then(function(stream) {
                // Make a call to the host (streamer).
                const call = peer.call('streamerId', stream);
                call.on('stream', function(remoteStream) {
                    videoElement.srcObject = remoteStream; // Show the remote stream.
                });
            });
    </script>
</body>

</html>
