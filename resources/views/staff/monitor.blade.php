<x-staff-app-layout>
    <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <h1>Live People Counting</h1>
    <div><p id='status' class="hidden"></p></div>
    <h2>Current Count: <span id="person-count">0</span></h2>
    <div class="flex flex-row justify-center items-center">
        <img id="video-stream-exit" class="" src="http://127.0.0.1:5000/video_feed_exit" alt="Video Stream">
        <img id="video-stream" class="" src="http://127.0.0.1:5000/video_feed" alt="Video Stream">
    </div>

    <script>
        
        const socket = io('http://127.0.0.1:5000', {transports: ['websocket', 'polling', 'flashsocket']});

        // Listen for person count updates
        socket.on('person_count', function(data) {
            console.log(data)
            document.getElementById('person-count').innerText = data.count;
        });

        function load_status(){
            axios.get('http://127.0.0.1:5000/current_status')
                .then(function (response) {
                    
                    if(response == 'success'){
                        $('#status').addClass('hidden')
                        
                        console.log("sucess" + response)
                        return true
                    }else {
                        $('#status').removeClass('hidden')
                       
                        $('#status').text(response)
                        console.log("fail" +response)
                        return false
                    }
                    
                })
                .catch(function (error) {
                  
                    $('#status').removeClass('hidden')
                    $('#status').text('Camera is not found')
                    console.log("err" +error)
                   
                })
        }

        document.addEventListener('DOMContentLoaded', function () {

            load_status()
           
             setInterval(function () {
                if (load_status() === true) {
                    clearInterval(intervalId); 
                }
            }, 60000)
            });

    </script>
</x-staff-app-layout>