<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Stream</title>
    <script src="https://unpkg.com/peerjs@1.5.4/dist/peerjs.min.js"></script>
</head>

<body>
    <h1>Client Stream</h1>
    <input type="text" id="peerIdInput" placeholder="Enter Host Peer ID">
    <button id="connectBtn">Connect to Host</button>
    <video id="remoteVideo" autoplay playsinline></video>
    <script>
        const peer = new Peer(); // Create a Peer instance
        const remoteVideoElement = document.getElementById('remoteVideo');

        // Display the Peer ID for the client
        peer.on('open', function(id) {
            console.log('My peer ID is: ' + id);
            document.body.insertAdjacentHTML('beforeend', `<p>Your peer ID: <strong>${id}</strong></p>`);
        });

        // Connect to the host when the button is clicked
        document.getElementById('connectBtn').addEventListener('click', function() {
            const hostPeerId = document.getElementById('peerIdInput').value;

            // Make sure the hostPeerId is not empty
            if (!hostPeerId) {
                alert('Please enter a valid Host Peer ID.');
                return;
            }

            // Call the host
            try {
                const call = peer.call(hostPeerId, null); // Call the host with no media stream

                // Handle the stream received from the host
                call.on('stream', function(stream) {
                    remoteVideoElement.srcObject = stream; // Display the host's video
                });

                // Handle call error
                call.on('error', function(err) {
                    console.error('Error during call:', err);
                    alert('Error during the call. Please check the console for more details.');
                });

            } catch (error) {
                console.error('Failed to initiate call:', error);
                alert('Failed to initiate call. Please check the Host Peer ID and try again.');
            }
        });
    </script>
</body>

</html>
