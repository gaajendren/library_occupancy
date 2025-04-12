<x-app-layout >
    
    @include('student.partials.nav_bar')

    <style>
        input[type='date']{     
        color-scheme: dark;
        }
        input[type="time"]{
            color-scheme: dark;
}
    </style>

<div class='dark bg-[#0c0f16] pt-[98px] w-full min-h-screen flex justify-center items-center flex-col'>

    <div class="py-[30px] mb-[40px] flex justify-center w-full items-center">
        <h1 class="lora text-white leading-loose text-[48px]">Room Detail</h1>
    </div>

    @if(session()->has('error'))
    <div role="alert" id='status' class="mb-7 max-w-[450px] mx-auto relative flex w-full p-3 gap-3 bg-red-100 border border-red-400 rounded-lg font-regular">
        <p  id="status_text" class='text-red-700 text-lg'>{{session('error')}}</p>
        <button onclick="document.getElementById('status').classList.toggle('hidden')" class="flex items-center justify-center transition-all w-8 h-8 rounded-md text-white hover:bg-slate-100 active:bg-slate-100 absolute top-2.5 right-2.5" type="button">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 text-red-600" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    @endif
    
    <div class="max-w-screen-xl w-full flex justify-center items-start gap-20">
        <div class="flex justify-center item-center flex-col w-1/2 gap-4" id='imageContainer'>
            <div class="w-full group overflow-hidden">
                @php $imgs =  json_decode($room->img); @endphp
                <img class='w-full h-[350px] object-cover bg-no-repeat cursor-pointer transition-transform duration-300 ease-in-out group-hover:scale-110' id='0' src="{{asset('storage/room_image/' .$imgs[0])}}" alt="">
            </div>
            <div class="flex flex-row justify-center w-full items-center gap-5 overflow-hidden">
                @for ($i = 1; $i < count($imgs); $i++)
                <img class='max-w-[100px] max-h-[70px] object-cover bg-no-repeat cursor-pointer transition-transform duration-300 ease-in-out hover:scale-110' id='{{$i}}' src="{{asset('storage/room_image/' .$imgs[$i])}}" alt="">
                @endfor
            </div>
            <div class="flex flex-row mt-[20px] justify-between items-center w-full">
                <h1 class="leading-loose  text-[32px] text-white text-regular self-start">{{$room->title}}</h1>
                <button class="bg-teal-200 rounded-sm text-bg-[#0c0f16] text-md text-semibold py-2 px-3 hover:bg-teal-600 cabin">Reserve Now</button>
            </div>

            <div class="mt-[20px] w-[40%] flex flex-row justify-center items-center">
                <div class="flex flex-col w-1/2 gap-4">
                    <p class="text-gray-300 text-md self-start cabin">Seat :</p>
                    <p class="text-gray-300 text-md self-start cabin">Duration</p>
                    <p class="text-gray-300 text-md self-start cabin">Max Slot :</p>
                   
                </div>
                <div class="flex flex-col w-1/2 gap-4">
                    <p class="text-white text-md self-start cabin">{{$room->min_seat}} - {{$room->max_seat}}</p>
                    <p class="text-white text-md self-start cabin">{{ Str::title($room->slot)}}</p>
                    <p class="text-white text-md self-start cabin">{{$room->max_slot}}</p>
                  
                </div>
            </div>

            <div class="my-[20px] w-full flex flex-row justify-start items-center cabin">
                <p class="text-gray-300">{{$room->description}}</p>
            </div>
        </div>


        <div class="flex justify-center item-center flex-col w-1/2 gap-4" >
            @php
                $route = '';

                if($room->slot == 'day'){
                    $route = route('student.reservation.day', $room->id);
                }else if($room->slot == 'month'){
                    $route = route('student.reservation.month', $room->id);
                }else if($room->slot == 'hour'){
                    $route = route('student.reservation', $room->id);
                }
            @endphp
            <form action="{{$route}}" id="form" method ='post' enctype="multipart/form-data">
             @csrf
            <div class='w-full flex flex-col justify-start items-start h-fit gap-3'>
                <p class="leading-none  text-[32px] text-white text-regular align-top self-start mb-8">Your Reservation</p>

                <label for="" class='text-white text-sm '>Count of Student: </label>
                <input class="w-[70%] rounded-xl text-gray-200 dark:bg-gray-700  shadow-lg border-none p-3 px-4 mb-3" oninput='totalCount_update(event)' value="{{old('studentCount')}}" id='countStudent' name='studentCount' min="{{$room->min_seat}}" max="{{$room->max_seat}}" type="number" required>
                <div class="text-red-400 hidden" id='seat_eror'></div>
                @error('studentCount')
                <div class="text-red-400" >{{ $message }}</div>
                @enderror

                
                 <button type="button" id="slot_open" data-modal-target="slot-modal" data-modal-toggle="slot-modal" class='bg-teal-200 rounded-sm text-bg-[#0c0f16] text-md text-semibold py-2 px-3 hover:bg-teal-600 cabin w-[70%] my-4'>Choose Date & Time</button> 
                

                 @if ($room->slot == 'hour' || $room->slot == 'day')

                    <label  class='text-white text-sm '>Date: <span id='date'></span></label>
                
                    <input type="date" name="date" class="hidden">
                    <input type="hidden" name="room_id" id="roomID" >
                    @error('date')
                    <div class="text-red-400" >{{ $message }}</div>
                    @enderror
                
                @endif

                @if ($room->slot == 'hour')
                    <label  class='text-white text-sm '>Slot time: <span id='time'></span></label>
               
                    <input type="hidden" name="time">
                    
                    @error('time')
                    <div class="text-red-400" >{{ $message }}</div>
                    @enderror

                @endif

                @if ($room->slot == 'month')

                <label  class='text-white text-sm '>Month: <span id='month'></span></label>
            
                <input type="text" name="date" class="hidden">
                <input type="hidden" name="room_id" id="roomID" >
                @error('date')
                <div class="text-red-400" >{{ $message }}</div>
                @enderror
            
            @endif

                
                
                <label for="" class='text-white text-sm '>Matrix card screenshot: <sup class='text-teal-200 text-xs'> * front side only</sup> </label>
                <div class="flex flex-col w-[70%] text-slate-300 mb-3">
                    <div class="flex flex-row flex-wrap gap-3 p-3 pl-0 " id="image_container">
                        <label class=" border-dashed border-[1px] border-slate-400 max-w-[150px] min-w-[100px] w-[15%] aspect-square p-2 cursor-pointer">
                            <div class="relative h-full w-full inset-0">
                                <div class="absolute inset-0 w-full top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 flex flex-col items-center justify-center">
                                    <i class="fa-solid fa-plus mb-1 text-slate-200 "></i>
                                    <label for="img" class="text-s text-slate-200 cursor-pointer">Add Image</label>
                                    <span id='uploaded_img' class="text-s tracking-wider cursor-pointer">0<label for="img" class="text-s tracking-wider cursor-pointer" id='total_img'></label></span>
                                </div>
                            </div>
                            <input type="file" disabled name="img[]" class="hidden w-full h-full" id="img" multiple="true">
                        </label>
                    </div>
                </div>
                <div class="text-red-400 hidden" id='img_eror'></div>
                @error('img')
                <div class="text-red-400">{{ $message }}</div>
                @enderror
                @error('img.*')
                <div class="text-red-400">{{ $message }}</div>
                @enderror

                <div class="text-red-400 hidden my-4" id='full_error'></div>

                <div class="flex w-[70%] justify-center items-center">
                    <button type="submit" onclick="validator(event)" id="form_submit" class="bg-teal-200 w-full rounded-sm text-bg-[#0c0f16] text-md text-semibold py-2 px-3 hover:bg-teal-600 cabin">Reserve Now</button>
                </div>
               
            </div>
            </form>   
        </div>
    </div>
</div>
    
<div class="rounded-full blur-[120px] opacity-60 bg-teal-300 w-[10%] h-[140px] absolute top-[25%] left-[20%]"></div>

<div class="absolute top-[35%] left-[80%]  rounded-full blur-[120px] opacity-60 bg-teal-300 w-[10%] h-[140px]"></div>


<script>
 const imageContainer = document.getElementById('imageContainer')
 const imgs = imageContainer.querySelectorAll('img')
 
 imgs.forEach(img => {

    if(img.id != '0'){

        img.addEventListener('click', (e)=>{
            let imgSrc = e.target.src;
            const mainImg = imageContainer.querySelector('[id="0"]')
           

            e.target.src = mainImg.src;
            mainImg.src = imgSrc;
        });

    }
  
 });

 const total_image = document.getElementById('total_img');
 const countStudent = document.getElementById('countStudent')

 const imageInput = document.getElementById('img');
 const image_container = document.getElementById('image_container');
        
const current_tImage = document.getElementById('uploaded_img');

 function totalCount_update(event){

    validator(event);
    total_image.textContent = '/' + countStudent.value ;

    if(parseInt(countStudent.value)>0){
        imageInput.disabled = false;
    }

 }

        let allFiles = [];

        function createFileList(files) {
            const dataTransfer = new DataTransfer(); 
            files.forEach(file => dataTransfer.items.add(file));
            return dataTransfer.files; 
    }

    
        imageInput.addEventListener('change', (event) => {
            

            console.log(countStudent.value)
            console.log(current_tImage.firstChild.textContent)

            if(parseInt(countStudent.value) <= parseInt(current_tImage.firstChild.textContent)+1 ){
                console.log('yes')
                if(parseInt(countStudent.value) != 1){
                    imageInput.disabled = true;
                }
              
            }

            const newFiles = Array.from(event.target.files);
           
            allFiles = [...allFiles, ...newFiles];
            console.log(allFiles)
            const updatedFileList = createFileList(allFiles);
           
            imageInput.files = updatedFileList
           
            current_tImage.firstChild.textContent = allFiles.length;


            const imgElements = image_container.querySelectorAll('img');
            imgElements.forEach(img => img.remove());
                        
            
            Array.from(updatedFileList).forEach((file) => {
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    
                    reader.onload = (e) => {
                        
                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.className = "max-w-[150px] min-w-[100px] w-[15%] aspect-square bg-gray-200 border-gray-200";
                        imgElement.alt = "Uploaded image";
    
                       
                        image_container.insertAdjacentElement('afterbegin', imgElement);
                    };
    
                    reader.readAsDataURL(file); 
                }
            });
            console.log(imageInput.files)
        });
      
    function validator(event){
        if(event.target.id == 'countStudent'){
           let min_seat = {{$room->min_seat}};
           let max_seat = {{$room->max_seat}};

           if(event.target.value < min_seat || event.target.value > max_seat ){
                document.getElementById('seat_eror').textContent = `Only Allowed ${min_seat} - ${max_seat} students.`
                document.getElementById('seat_eror').classList.remove('hidden')
                event.target.value = ''
            }else{
                document.getElementById('seat_eror').textContent = ''
                document.getElementById('seat_eror').classList.add('hidden')
            }
        }else if(event.target.id == 'form_submit'){
           const form = document.getElementById('form')
           event.preventDefault();

            const countStudent = form.querySelector('#countStudent')?.value?.trim();
            const date = form.querySelector('[name="date"]')?.value?.trim();
            const time = form.querySelector('[name="time"]')?.value?.trim();


            let checker = @json(in_array($room->slot, ['day', 'month']))  == true ? true : false

            
            if(checker){
                if (!countStudent || !date) {
                    alert('Please fill in all required fields: Student Count, Date.');
                    return false;
                }else{
                    document.getElementById('full_error').textContent = ''
                    document.getElementById('full_error').classList.add('hidden')
                 }
            }else{

                if (!countStudent || !date || !time) {
                    alert('Please fill in all required fields: Student Count, Date, and Time.');
                    return false;
                }else{
                    document.getElementById('full_error').textContent = ''
                    document.getElementById('full_error').classList.add('hidden')
                 }
            
            }
           
           
           if(allFiles.length != parseInt(form.querySelector('#countStudent').value)){
             document.getElementById('img_eror').textContent = `Please send all ${form.querySelector('#countStudent').value} student matrix card image.`
             document.getElementById('img_eror').classList.remove('hidden')
             return false
           }else{
             document.getElementById('img_eror').textContent = ''
             document.getElementById('img_eror').classList.add('hidden')
           }

          

           form.submit();
            
        }
    }
</script>


@if ($room->slot == "day")

@include('student.room.slot_day')
    
@elseif ($room->slot == "hour")

@include('student.room.slot')

@elseif ($room->slot == "month")

@include('student.room.slot_month')
    
@endif




</x-app-layout>