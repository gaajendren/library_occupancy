<x-staff-app-layout>
    <div class='dark flex flex-col min-h-screen bg-slate-200'>
        <div class="mx-auto  montserrat-regular text-2xl tracking-wider text-slate-700" >
            <h1 class="text-center pt-[50px]">Update Room</h1>
        </div>
        <div class="max-w-(--breakpoint-xl) w-3/4 mx-auto">
            <div class=" mx-auto md:gap-10 sm:gap-6 gap-4 md:m-[3rem] sm:m-[2rem] m-[1rem]">
                <div class="w-full">
                    <form action="{{route('staff.update.room', $room->id)}}" class="flex flex-col bg-white rounded-xl shadow-lg p-5 max-sm:rounded-none max-sm:shadow-none " enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('PATCH')
                        <label class="text-slate-600" for="img">Image</label>
                        <div class="flex flex-col text-slate-300 mb-3">
                            <div class="flex flex-row  gap-3 p-3 pl-0 " id="imageContainer">
                                @php
                                $image_array = json_decode($room->img);

                               
                                if($image_array){
                                    echo '<span class="flex flex-row gap-3">';
                                        $count = 0;
                                    foreach ($image_array as $img ) {
                                        $count = $count + 1;
                                        echo '<div class="relative"><img data-count="' . $count . '" class="inline max-w-[120px] aspect-square" src="' . asset('storage/room_image/' . $img) . '" alt=""> </div>';
                                    }
                                    echo '</span>';
                                    
                                }
                                    
                                @endphp
                              
                                
                                <label class="border-dashed border-[1px] border-slate-800  w-[120px]  aspect-square p-2 cursor-pointer">
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
    
    
                        </div>
    
                        <div class="flex flex-row flex-1 mb-8 gap-8 justify-start"> 
                            <div class="flex flex-col "> 
                                <label for="title" class="mb-3 ">Room Type</label>
                                <input type="text" value="{{$room->title}}"  class="rounded-lg bg-gray-200  border-gray-300 text-slate-600 h-10 p-4" name="title" id="title">
                                @error('title')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="flex flex-col">
                                <label for="min_seat" class="mb-3 ">Total Seat</label>
                                <div class="flex flex-row gap-2 items-center">
                                    <div class="flex flex-col">
                                        <input type="number" value="{{$room->min_seat}}"  class="rounded-lg bg-gray-200 border-gray-300 text-slate-600 h-10 p-4" name="min_seat" id="min_seat">
                                        @error('min_seat')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <p><i class="fa-solid fa-minus fa-sm"></i></p>
                                    <div class="flex flex-col">
                                        <input type="number" value="{{$room->max_seat}}"  class="rounded-lg bg-gray-200 border-gray-300 text-slate-600 h-10 p-4" name="max_seat" id="max_seat">
                                        @error('max_seat')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>                           
                            </div> 
                        </div>
                    
                       
                    
                        <div class="flex flex-row text-slate-600 mb-8 gap-8 justify-start"> 
                            <div class="flex flex-col "> 
                                <label for="slot" class="mb-3 ">Slot Duration</label>
                                <select name="slot" onchange="update_maxSlot(this)" id="slot" class="bg-white border-gray-300 focus:ring-0 rounded-lg w-full dark:bg-gray-200 dark:text-slate-600">
                                    <option {{$room->slot == 'hour' ? 'selected' : ''}} value="hour">1 Hour</option>
                                    <option {{$room->slot == 'day' ? 'selected' : ''}} value="day">1 Day</option>
                                    <option {{$room->slot == 'month' ? 'selected' : ''}} value="month">1 Month</option>
                                </select>
                                @error('slot')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div id="container_slot" class="flex flex-col"> 
                                <label for="max_slot" class="mb-3 ">Max Reserve Slots</label>
                                <input type="number" value="{{$room->max_slot}}"  class="rounded-lg bg-gray-200 border-gray-300 text-slate-600 h-10 p-4" name="max_slot" id="max_slot">
                                @error('max_slot')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        
                       
                        </div>



                        

                        <div class="flex flex-col text-slate-600 mb-3"> 
                            <label for="desc" class="mb-3 ">Description</label>
                            <textarea     class="rounded-lg bg-gray-200  border-gray-300 text-slate-600  p-4" name="description" id="desc" rows="3">{{$room->description}}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
    
                        <div class="mt-2 mx-auto">
                            <button type="submit" class="text-white cursor-pointer bg-gray-700 hover:bg-gray-500 min-w-20 rounded-xl shadow-lg border-2 border-gray-200 p-3 px-5">Submit</button>
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
           
            console.log(imageInput.files);
            
            const imgElements = imageContainer.querySelectorAll('img');
            imgElements.forEach(img => img.remove());
                        
            
            Array.from(updatedFileList).forEach((file) => {
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    
                    reader.onload = (e) => {
                        
                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.className = "max-w-[150px] min-w-[100px] w-[15%] aspect-square bg-gray-200 border-gray-200";
                        imgElement.alt = "Uploaded image";
    
                       
                        imageContainer.insertAdjacentElement('afterbegin', imgElement);
                    };
    
                    reader.readAsDataURL(file); 
                }
            });
           
        });

        function update_maxSlot(e){
           if (e.value != 'hour'){
             document.getElementById('container_slot').classList.add('hidden');
             document.getElementById('max_slot').value = 1;
           }else{
            document.getElementById('container_slot').classList.remove('hidden');
           }
        }


        // function edit_image(element){
        
        // const tempInput = document.createElement('input');
        // const img_count = element.closest('.relative').querySelector('img').dataset.count;

        // tempInput.type = 'file';
        // tempInput.accept = 'image/*';

        // tempInput.addEventListener('change', (event) => {
        //     const newFile = event.target.files[0];
        //     if (newFile && newFile.type.startsWith('image/')) {
               
        //         if(allFiles[img_count]){

        //         }
        //         allFiles[index] = newFile;

               
        //         const updatedFileList = createFileList(allFiles);
        //         imageInput.files = updatedFileList;

               
        //         renderImages();
        //     }
        // });

       
        // tempInput.click();
        // }


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


      
        
    </script>


</x-staff-app-layout>
