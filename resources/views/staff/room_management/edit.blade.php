<x-staff-app-layout>
    <div class='dark flex flex-col min-h-screen bg-slate-200'>
        <div class="mx-auto  montserrat-regular text-2xl tracking-wider text-slate-700" >
            <h1 class="text-center pt-[50px]">Update Room</h1>
        </div>
        <div class="max-w-screen-xl w-3/4 mx-auto">
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
    
                            @error('img.*')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @error('img')
                             <span class="text-danger">{{ $message }}</span>
                            @enderror
    
                        </div>
    
                      
                        <div class="flex flex-col text-slate-600 mb-3"> 
                            <label for="title" class="mb-3 ">Title</label>
                            <input type="text" value="{{$room->title}}"  class="rounded-lg bg-gray-200  border-gray-300 text-slate-600 h-10 p-4" name="title" id="title">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    
                       
                        <div class="flex flex-col text-slate-600 mb-3"> 
                            <label for="quantity" class="mb-3 ">Quantity</label>
                            <input type="number"   value="{{$room->quantity}}" class="rounded-lg bg-gray-200 border-gray-300 text-slate-600 h-10 p-4" name="quantity" id="quantity">
                            @error('quantity')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col text-slate-600 mb-3"> 
                            <label for="seat" class="mb-3 ">Seat</label>
                            <input type="number"  value="{{$room->seat}}"  class="rounded-lg bg-gray-200 border-gray-300 text-slate-600 h-10 p-4" name="seat" id="seat">
                            @error('seat')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col text-slate-600 mb-3"> 
                            <label for="location" class="mb-3 ">Location</label>
                            <input type="text"  value="{{$room->location}}" class="rounded-lg bg-gray-200  border-gray-300 text-slate-600 h-10 p-4" name="location" id="location">
                            @error('location')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col text-slate-600 mb-3"> 
                            <label for="desc" class="mb-3 ">Description</label>
                            <textarea     class="rounded-lg bg-gray-200  border-gray-300 text-slate-600  p-4" name="description" id="desc" rows="3">{{$room->description}}</textarea>
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

        
    </script>


</x-staff-app-layout>
