<x-staff-app-layout>
    <script src="https://cdn.socket.io/4.5.4/socket.io.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   
    <main class="min-h-screen flex flex-col w-full  bg-slate-200 p-4">

        <div role="alert" id='status' class="hidden mt-3 max-w-[450px] mx-auto relative flex  w-full p-3 gap-3  bg-red-100 border border-red-400 rounded-lg font-regular">
            <p  id="status_text" class='text-red-700 text-lg'></p>
            <button onclick="document.getElementById('status').classList.toggle('hidden')" class="flex items-center justify-center transition-all w-8 h-8 rounded-md text-white hover:bg-red-800 active:bg-slate-100 absolute top-2.5 right-2.5" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 text-red-600 hover:text-red-200" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="mx-auto flex flex-col my-6 bg-white shadow-xs border  border-slate-300 rounded-lg w-96">      
            <div class="p-4 border-none">
                <div class=" border-l-2 border-l-red-600 pl-2">
                    <p class="mb-2 text-slate-800">
                       Current Count
                    <p>
                    <h5 class="text-slate-900 text-xl font-semibold "><span id="person-count"></span></h5>
    
                </div> 
            </div>  
        </div>

        <div class="w-full flex flex-row gap-4 justify-center items-center">
            <div id="video-enter" class="w-1/2"></div>
            <div id="video-exit"  class="w-1/2"></div>
        </div>
    </main>
   

    <script>
        
        const socket = io('http://127.0.0.1:5000', {transports: ['websocket', 'polling', 'flashsocket']});

        socket.binaryType = 'arraybuffer';
        
        socket.on('person_count', function(data) {
            console.log(data)
            document.getElementById('person-count').innerText = data.count;
        });

        function setupStream(way) {
            const container = document.getElementById(`video-${way}`);
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            container.appendChild(canvas);

            let canvasInitialized = false;

            socket.on(`video_frame_${way}`, async (data) => {
                    try {
                        const blob = new Blob([data], { type: 'image/jpeg' });
                        const bitmap = await createImageBitmap(blob);

                        if (!canvasInitialized) {
                            canvas.width = bitmap.width;
                            canvas.height = bitmap.height;
                            canvasInitialized = true;
                        }

                        ctx.drawImage(bitmap, 0, 0);
                    } catch (err) {
                        console.error(`Failed to decode ${way} frame`, err);
                    }
            });
        }
      
        setupStream('enter');
        setupStream('exit');
        socket.emit('request_video_feeds', {ways: ['enter', 'exit']});
       
        function load_status(){
            axios.get('http://127.0.0.1:5000/current_status')
                .then(function (response) {

                    if(response.data == 'success'){
                        $('#status').addClass('hidden')
                        
                        console.log("sucess" + response)
                        return true
                    }else {
                        $('#status').removeClass('hidden')
                       
                        $('#status_text').text(response.data)

                        console.log("fail" +response.data)
                        return false
                    }
                    
                })
                .catch(function (error) {
                  
                    $('#status').removeClass('hidden')
                    $('#status_text').text('Camera is not found')
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