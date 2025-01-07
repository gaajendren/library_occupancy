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
                        <label class="text-slate-600" for="img">Image</label>
                        <div class="flex flex-col text-slate-300 mb-3">
                            <div class="flex flex-row  gap-3 p-3 pl-0 " id="imageContainer">
    
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
    
                      
                        <div class="flex flex-col text-slate-600 mb-3"> 
                            <label for="title" class="mb-3 ">Title</label>
                            <input type="text" value="{{ old('title') }}" class="rounded-lg bg-gray-200  border-gray-300 text-slate-600 h-10 p-4" name="title" id="title">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col text-slate-600 mb-3"> 
                            <label for="min_seat" class="mb-3 ">Min Seat</label>
                            <input type="number"  value="{{ old('min_seat') }}"  class="rounded-lg bg-gray-200 border-gray-300 text-slate-600 h-10 p-4" name="min_seat" id="min_seat">
                            @error('min_seat')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col text-slate-600 mb-3"> 
                            <label for="max_seat" class="mb-3 ">Max Seat</label>
                            <input type="number"  value="{{ old('max_seat') }}"  class="rounded-lg bg-gray-200 border-gray-300 text-slate-600 h-10 p-4" name="max_seat" id="max_seat">
                            @error('max_seat')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col text-slate-600 mb-3"> 
                            <label for="location" class="mb-3 ">Location</label>
                            <input type="text"  value="{{ old('location') }}" class="rounded-lg bg-gray-200  border-gray-300 text-slate-600 h-10 p-4" name="location" id="location">
                            @error('location')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col text-slate-600 mb-3"> 
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
    </script>


</x-staff-app-layout>
