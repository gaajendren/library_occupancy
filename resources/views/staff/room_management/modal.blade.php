<div id="edit-room" tabindex="-1" class="hidden py-14  overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-[100%] ">
    <div class="absolute top-0 left-0 bg-gray-700 w-full min-h-[110%] h-full opacity-60" style="bottom: auto;"></div>
    <div class="relative p-4 w-2/3  max-h-full my-10">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="title text-xl font-semibold text-gray-900 dark:text-white">
                  Room Name Management
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="edit-room">
                    <svg class="w-3 h-3"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-4 space-y-5">

                <div class="flex flex-row justify-between">

                    <button type="button" data-modal-target="add-room"  data-modal-toggle="add-room" class="text-white bg-gray-700 hover:bg-gray-500  rounded-xl shadow-sm border-2 border-gray-200 p-2 px-2.5 text-sm mr-4">Add+</button>
                    
                    <button type="button" onclick="update_data()"  class="text-white bg-blue-700 hover:bg-blue-500  rounded-xl shadow-sm  border-none p-2 px-2.5 text-sm ml-4">Save</button>
                   
                </div>
              
           
                    <div id="main_contain" class="">
                                    

                    </div>
              
                   
            </div>
        </div>
    </div>
</div>



<div id="add-room" tabindex="-1" class="hidden py-14  overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-[100%] ">
    <div class="absolute top-0 left-0 bg-gray-700 w-full min-h-[110%] h-full opacity-60" style="bottom: auto;"></div>
    <div class="relative p-4 w-1/3  max-h-full my-10">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="title text-xl font-semibold text-gray-900 dark:text-white">
                  Add Room
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="add-room">
                    <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-4 space-y-5">

                <div class="mb-5">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                    <input type="text" name='name' id="name"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  required />
                </div>

                <div class="mb-5">
                    <label for="location" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                    <input type="text" name='location' id="location"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  required />
                </div>

                <button type="button" onclick="add_room(this)"   class="text-white bg-gray-700 hover:bg-gray-500  rounded-xl shadow-sm border-2 border-gray-200 p-2 px-2.5 text-sm mr-4">Submit</button>

   
            </div>
        </div>
    </div>
</div>



<script>

    let room_id;

    function update_data(){
     
        let rooms = [];

        document.querySelectorAll("#tableBody tr").forEach((row) => {
            let roomId = row.querySelector("input[type='text']").name; 
            let roomName = row.querySelector(`input[id^="room_"]`).value;
            let roomLocation = row.querySelector(`input[id^="location_"]`).value;

            rooms.push({
                id: roomId,
                name: roomName,
                location: roomLocation
            });
        });

      
        axios.patch("/staff/edit/all_room_name", {
            rooms: rooms
        }, {
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => {
          alert('Successfully updated.')
            document.querySelector('[data-modal-hide="edit-room"]').click();

            
        })
        .catch(error => {
            console.error("Error:", error);
        });

    }

 
    function add_room(){

       
        axios.post(`/staff/add/room_name/${room_id}`,{
             name: document.getElementById('name').value,
             location: document.getElementById('location').value
        })
        .then(response => {

            if(response.data.success){
                load_roomNames(room_id);

                document.getElementById('name').value = ''
                document.getElementById('location').value = ''
                 
                document.querySelector('[data-modal-hide="add-room"]').click();

            }else{
                alert('Please add again the room name. Thank You!!');
            }

        })
        .catch(error => {
            console.error("Error fetching room name:", error);
        });
    }
    
     function load_roomNames(id){

        room_id = id;

        const div = document.getElementById('main_contain');

        div.innerHTML = `
             <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-200 text-slate-800 font-medium">
                    <tr>
                        <th class="px-4 py-2">Room Name</th>
                        <th class="px-4 py-2">Location</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody id="tableBody"></tbody>
            </table>`;

        const tableBody = document.getElementById("tableBody");

       
        axios.get(`/staff/room_name/${id}`)
        .then(response => {
        
        
            response.data.forEach((room,index) => {
                const tr = document.createElement("tr");
                tr.className = "bg-white";

                tr.innerHTML = `
                    <td class="px-4 py-2">
                        <input id="room_${index + 1}" name="${room.id}" type="text" value="${room.name}"
                            class="bg-transparent text-slate-800 h-9 text-sm px-3 w-full focus:outline-none"
                            placeholder="Room Name">
                    </td>

                    <td class="px-4 py-2">
                        <input id="location_${index + 1}" name="${room.id}" type="text" value="${room.location || ''}"
                            class="bg-transparent text-slate-800 h-9 text-sm px-3 w-full focus:outline-none"
                            placeholder="Room Location">
                    </td>

                    <td class="px-4 py-2">
                        <button type="button" class="bg-red-500 text-white px-3 py-1 rounded-lg text-sm hover:bg-red-600"
                            onclick="removeRow(${room.id})">
                            Remove
                        </button>
                    </td>
                `;

                tableBody.appendChild(tr);
            });


        })
        .catch(error => {
            console.error("Error fetching room name:", error);
        });


     }
      
     function removeRow(id) {
        const statusAlert = confirm('Confirm Delete?');

        if(statusAlert){
            axios.delete(`/staff/delete/room_name/${id}`)
            .then(response => {

                if(response.data.success){
                    load_roomNames(id);
                }else{
                    alert('Please delete again the room name. Thank You!!');
                }

            })
            .catch(error => {
                console.error("Error fetching room name:", error);
            });
        }
      
    }
    
       
   
</script>


