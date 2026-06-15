<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Host Stream</title>
    <script src="https://unpkg.com/peerjs@1.5.4/dist/peerjs.min.js"></script>
</head>

<body>
    <h1>Host Stream</h1>
    <video id="video" autoplay playsinline></video>
    <script>
        const peer = new Peer(); // Create a Peer instance

        navigator.mediaDevices.getUserMedia({
                video: true,
                audio: true
            })
            .then(function(stream) {
                const videoElement = document.getElementById('video');
                videoElement.srcObject = stream;

                peer.on('call', function(call) {
                    call.answer(stream); // Answer the call with the stream
                });

                // Display the Peer ID for clients to connect
                peer.on('open', function(id) {
                    console.log('My peer ID is: ' + id);
                    document.body.insertAdjacentHTML('beforeend',
                        `<p>Share this ID with clients: <strong>${id}</strong></p>`);
                });
            })
            .catch(function(err) {
                console.error('Failed to get local stream', err);
            });
    </script>
</body>

</html>
