<x-staff-app-layout>
    <div class='dark min-h-screen bg-slate-200'>
        <div class="mx-auto  montserrat-regular text-2xl tracking-wider text-slate-700" >
            <h1 class="text-center pt-[50px]">Add Room</h1>
        </div>
        <div class="max-w-[900px]  mx-auto">
            <div class=" mx-auto md:gap-10 sm:gap-6 gap-4 md:m-[3rem] sm:m-[2rem] m-[1rem]">
                <div class="w-full">
                    <form action="{{route('staff.store.room')}}" class="flex flex-col bg-white rounded-xl shadow-lg p-5 max-sm:rounded-none max-sm:shadow-none max-sm:bg-inherit" enctype="multipart/form-data" method="POST">
                        @csrf
                        @if($errors->any())
                        {!! implode('', $errors->all('<div>:message</div>')) !!}
                        @endif
                        <label class="text-slate-600" for="img">Image</label>
                        <div class="flex flex-col text-slate-300 mb-3">
                            <div class="flex flex-row flex-wrap  gap-3 p-3 pl-0 " id="imageContainer">
    
                                <label class=" border-dashed border-[1px] border-slate-800 max-w-[150px] min-w-[100px] w-[15%] aspect-square p-2 cursor-pointer">
                                    <div class="relative h-full w-full inset-0">
                                        <div class="absolute inset-0 w-full top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 flex flex-col items-center justify-center">
                                            <i class="fa-solid fa-plus mb-1 text-slate-600 "></i>
                                            <label for="img" class="text-s text-slate-600 cursor-pointer">Add Image</label>
                                            <label for="img" class="text-s tracking-wider cursor-pointer"></label>
                                        </div>
                                    </div>
                                    <input type="file"  name="img[]" class="hidden w-full h-full" id="img" multiple>
                                </label>
                             
                            </div>
    
                            @error('img.*')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @error('img')
                             <span class="text-danger">{{ $message }}</span>
                            @enderror
    
                        </div>

                        <div class="flex flex-row text-slate-600 mb-8 gap-8 justify-start"> 
                            <div class="flex flex-col flex-1">
                                <label for="title" class="mb-3 ">Room Type</label>
                                <input type="text" value="{{ old('title') }}" class="rounded-lg bg-gray-200  border-gray-300 text-slate-600 h-10 p-4" name="title" id="title">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col">
                                <label for="min_seat" class="mb-3 ">Total Seat</label>
                                <div class="flex flex-row gap-2 items-center">
                                    <div class="flex flex-col">
                                        <input type="number"  value="{{ old('min_seat') }}"  class="rounded-lg bg-gray-200 border-gray-300 text-slate-600 h-10 p-4 max-w-[100px]" name="min_seat" id="min_seat">
                                        @error('min_seat')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <p><i class="fa-solid fa-minus fa-sm"></i></p>
                                    <div class="flex flex-col">
                                        <input type="number"  value="{{ old('max_seat') }}"  class="rounded-lg bg-gray-200 border-gray-300 text-slate-600 h-10 p-4 max-w-[100px]" name="max_seat" id="max_seat">
                                        @error('max_seat')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>                           
                            </div>   
                        </div>


                        <div class="flex flex-row text-slate-600 mb-8 gap-8 justify-start"> 
                            <div class="flex flex-col"> 
                                <label for="slot" class="mb-3 ">Slot Duration</label>
                                <select id="slot" name="slot" onchange="update_maxSlot(this)" class="bg-white border-gray-300  focus:ring-0    rounded-lg  w-full  dark:bg-gray-200 dark:text-slate-600 ">
                                    <option value="hour" {{ old('slot') == 'hour' ? 'selected' : '' }}>1 Hour</option>
                                    <option value="day" {{ old('slot') == 'day' ? 'selected' : '' }}>1 Day</option>
                                    <option value="month" {{ old('slot') == 'month' ? 'selected' : '' }}>1 Month</option>
                                </select>
                                @error('slot')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div id="container_slot" class="flex flex-col"> 
                                <label for="max_slot" class="mb-3 ">Max Reserve Slots</label>
                                <input type="number"  value="{{ old('max_slot') }}"  class="rounded-lg bg-gray-200 border-gray-300 text-slate-600 h-10 p-4" name="max_slot" id="max_slot">
                                @error('max_slot')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col">
                                <label for="qnty" class="mb-3 ">Total Quantity</label>
                                <input type="number" oninput="roomNameInput()"  value="{{ old('qnty') }}" min="1" class="rounded-lg bg-gray-200 border-gray-300 text-slate-600 h-10 p-4" name="qnty" id="qnty">
                                @error('qnty')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex items-center relative self-center">
                                <input onclick="auto_name()"  id="checked-checkbox" type="checkbox" value="" class="w-4 h-4 text-slate-600  bg-gray-200 border-none rounded-xs focus:ring-0 focus:outline-hidden peer">
                                <label for="checked-checkbox" class="ms-2 text-sm font-medium text-slate-600">Auto Naming</label>
                                <div class="absolute left-0 bottom-full mb-2 hidden w-max bg-gray-700 text-white text-sm px-2 py-1 rounded-md peer-hover:block">
                                    This will auto-generate a name for the room.
                                </div>
                            </div>
                        </div>


                        <div id="roomNameContainer" class="flex flex-col text-slate-600 mb-8"> 
                            <div  onclick="card_expand(this)" id="card_header" class="rounded-md cursor-pointer shadow-xs w-full border-[1px] border-gray-300 bg-gray-300 p-4 flex flex-row justify-center items-center gap-2">
                                <p class="font-medium text-slate-600">All Room Specific Name</p>
                                <i id="expand" class="fa-solid fa-chevron-down"></i>
                            </div>
                            <div id="sub_child" class="hidden rounded-b-md shadow-xs w-full border-[1px] border-none bg-gray-200 p-4 h-18">

                            </div>
                        </div>

                        
                        <div class="flex flex-col text-slate-600 mb-8"> 
                            <label for="desc" class="mb-3 ">Description</label>
                            <textarea  value="{{ old('description') }}"   class="rounded-lg bg-gray-200  border-gray-300 text-slate-600  p-4" name="description" id="desc" rows="3"></textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="mt-2 mx-auto">
                            <button type="submit" class="text-white bg-gray-700 hover:bg-gray-500 min-w-20 rounded-xl shadow-lg border-2 border-gray-200 p-3 px-5">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
       
    </div>
   

    <script>
        const imageInput = document.getElementById('img');
        const imageContainer = document.getElementById('imageContainer');
        const form = document.querySelector('form');

        let allFiles = [];

        function createFileList(files) {
            const dataTransfer = new DataTransfer(); 
            files.forEach(file => dataTransfer.items.add(file));
            return dataTransfer.files; 
        }

    
        imageInput.addEventListener('change', (event) => {
            const newFiles = Array.from(event.target.files);
            allFiles = [...allFiles, ...newFiles];
          
            const updatedFileList = createFileList(allFiles);
            imageInput.files = updatedFileList
           

            const imgElements = imageContainer.querySelectorAll('.imageHolder');
            imgElements.forEach(img => img.remove());


            let fileArray = Array.from(updatedFileList);
        
            fileArray.forEach((file, index) => {
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    
                    reader.onload = (e) => {

                        const divElement = document.createElement('div');
                        divElement.className = "imageHolder relative max-w-[150px] min-w-[100px] w-[17%] p-1 bg-white rounded-lg shadow-xs";
                        
                        const deleteIcon = document.createElement('i');
                        deleteIcon.className = "fa-solid fa-trash absolute top-3 rounded-full p-2 cursor-pointer text-red-500 hover:text-red-700 bg-slate-300 bg-opacity-[30%] hover:bg-opacity-[60%] right-4 flex items-center justify-center text-md";
                        
                        deleteIcon.onclick = () => {
                            fileArray.splice(index, 1); 
                            divElement.remove(); 
                        };

                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.className = "w-full rounded-md aspect-square bg-gray-200 border-gray-200";
                        imgElement.alt = "Uploaded image";
    
                        
                        divElement.append(deleteIcon, imgElement);
                       
                        imageContainer.insertAdjacentElement('afterbegin', divElement);
                    };
    
                    reader.readAsDataURL(file); 
                }
            });
           
        });

        function update_maxSlot(e){
           if (e.value != 'hour'){
             document.getElementById('max_slot').value = 1;
             document.getElementById('max_slot').disabled = true;
           }else{
            document.getElementById('max_slot').disabled = false;
           }
        }

        function roomNameInput(){
            const quantity = parseInt(document.getElementById('qnty').value, 10) + 1; 
            const subContainer = document.getElementById('sub_child');

            subContainer.innerHTML = ''; 

   
            const div = document.createElement("div");
            div.className = 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 w-full p-2';

            for (let index = 1; index < quantity; index++) {
                const div2 = document.createElement("div");
                div2.className = 'flex flex-row items-center gap-2';

                div2.innerHTML = `
                    <p class="text-sm text-slate-700">${index}.</p>
                    <input id="room_${index}" name="room_names[]" type="text" 
                        class="rounded-lg bg-gray-50 border-gray-300 text-slate-600 h-8 text-sm px-3 w-full">
                `;

                div.append(div2);
            }

            subContainer.append(div);

            document.getElementById('expand').classList.add('fa-chevron-up',);
            document.getElementById('expand').classList.remove('fa-chevron-down');
            document.getElementById('card_header').classList.add('rounded-t-md');
            document.getElementById('card_header').classList.remove('rounded-md');
            document.getElementById('sub_child').classList.remove('hidden')
        }



        function card_expand(e){
            document.getElementById('sub_child').classList.toggle('hidden');

            if( document.getElementById('sub_child').classList.contains('hidden')){

                document.getElementById('expand').classList.remove('fa-chevron-up',);
                document.getElementById('expand').classList.add('fa-chevron-down');
                e.classList.remove('rounded-t-md');
                e.classList.add('rounded-md');

            }else{

                document.getElementById('expand').classList.add('fa-chevron-up',);
                document.getElementById('expand').classList.remove('fa-chevron-down');
                e.classList.add('rounded-t-md');
                e.classList.remove('rounded-md');
            }
        }

        function auto_name(){
            const checkbox = document.getElementById("checked-checkbox");
            const quantity = parseInt(document.getElementById('qnty').value, 10); 

            if (checkbox.checked) {
              const title =  document.getElementById("title").value;

              if(!title){
                alert('Please input title.');
                checkbox.checked = false;
              }

              if(!quantity){
                alert('Please input quantity.');
                checkbox.checked = false;
              }

              let title_text = toCamelCase(title);

              for (let index = 1; index < quantity+ 1; index++) {
                
                document.getElementById(`room_${index}`).value = `${title_text}_${index}`
                
              }
            }

        }

        function toCamelCase(title) {
            return title
                .toLowerCase() 
                .split(" ")
                .map((word, index) => 
                    index === 0 ? word : word.charAt(0).toUpperCase() + word.slice(1)
                ) 
                .join("");
        }

    </script>


</x-staff-app-layout>
