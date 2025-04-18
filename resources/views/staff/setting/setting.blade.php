<x-staff-app-layout>

    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
    <style>
        .ql-toolbar {
            background-color: white !important;
            border: 1px solid #ccc !important;
        }
        
        .ql-toolbar button, 
        .ql-toolbar .ql-picker {
            color: black !important;
        }
        </style>

       


    <main class="min-h-screen bg-slate-200 py-14 max-sm:px-5 pt-5" > 
        @include('staff.message.success')
        @include('staff.message.error')
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="p-4 w-full pt-2 pl-7">
            <h1 class="text-xl font-bold text-black inter">Settings</h1>

            <p class="text-md font-extrabold text-black mt-6  inter">Appearance</p>
            <p class="text-slate-700 text-sm inter leading-6">Change how user UI looks and feels</p>

            <hr class="mt-3 mb-5 h-[2px] w-full bg-slate-300">
       
            <form action="{{route('staff.update.setting')}}" method="post" name="main-form" id="main_form" enctype="multipart/form-data"> 
            @csrf
            @method('PATCH')
      
            <div class="flex flex-row w-full items-center  gap-3">
                    <p class="w-[40%] max-w-[250px] text-sm font-semibold text-black inter">Logo</p>
                    <div class="relative w-[60%]">
                        <div onclick="logo_input()" class="w-[150px] aspect-square rounded-md shadow-sm bg-white cursor-pointer hover:bg-gray-100"><img id="img" src="{{url($setting->logo)}}" alt="">
                        <input type="file" accept="image/*" id="logo_input" class="w-full h-full" name="logo" hidden></div>
                    </div>
            </div>

            <input type="hidden" name="start_time" id="start_time">
            <input type="hidden" name="end_time" id="end_time">
            <input type="hidden" name="is_manual" id="is_manual">


            <br>

            <div class="flex flex-row w-full items-center gap-3">
                <p class="w-[40%] max-w-[250px] text-sm font-semibold text-black  inter">Title</p>
                <div class=" w-[60%]">
                    <input type="text" value="{{$setting->title}}" class="text-sm w-full max-w-[300px] text-slate-700 border-none shadow-sm rounded-md" name="title" id="">
                </div>
            </div>

            <br>

            <div class="flex flex-row w-full items-center gap-3">
                <p class="w-[40%] max-w-[250px] text-sm font-semibold text-black  inter">Description</p>
                <div class=" w-[60%]">
                    <div id="editor" class="bg-white text-sm shadow-sm text-slate-700">{!! $setting->description !!}</div>
                    <input type="hidden" name="description" id="description">
                </div>
            </div>

            <br>

            <hr class="mt-3 mb-5 h-[2px] w-full bg-slate-300">

            <br>

            <p class="text-md font-extrabold text-black   inter">Banner</p>
            <p class="text-slate-700 text-sm inter leading-6">Change banner image</p>

            <br>

            @php
            $banners = json_decode($setting->banner, true);
            @endphp

            <hr class="mt-3 mb-2 h-[2px] w-full bg-slate-300">

            <div class="flex flex-row w-full items-center gap-3">
                <p class="w-[40%] max-w-[250px] text-sm font-semibold text-black  inter">Side Banner</p>

                <div class=" w-[60%] flex flex-row gap-4">
                    <div onclick="banner2()" class="w-full aspect-[2] rounded-md bg-white cursor-pointer">
                        <img class="w-full h-full" id="holder_2" src="{{asset('img/' . ($banners['banner_2'] ))}}" alt="">
                        <input type="file" name="banner_2" class="hidden w-full h-full" accept="image/*" id="banner2"  >
                    </div>
                    <div onclick="banner3()" class="w-full aspect-[2] rounded-md bg-white cursor-pointer">
                        <img class="w-full h-full " id="holder_3" src="{{asset('img/' . ($banners['banner_3']))}}" alt="">
                        <input type="file" name="banner-3" class="hidden w-full h-full" accept="image/*" id="banner3" >
                    </div>
                </div>
            </div>    


            <br>

            <div class="flex flex-row w-full items-center gap-3">
                <p class="w-[40%] max-w-[250px] text-sm font-semibold text-black  inter">Slider Image</p>
                <div class=" w-[60%]">
                    <div class="flex flex-col text-slate-300 mb-3">
                        <div class="flex flex-row flex-wrap  gap-3 p-3 pl-0 " id="imageContainer">

                          

                            @if(isset($banners['slider_image']))
                                @foreach($banners['slider_image'] as $key => $image)
                                    <div class=" relative max-w-[250px] min-w-[100px] w-[25%] aspect-[2] bg-white rounded-lg shadow-sm">
                                        <button type="button" class="absolute top-3 right-4 text-red-500 hover:text-red-700">
                                            <i onclick="confirmDelete('{{ $key }}')" class="fa-solid fa-trash"></i>
                                        </button>
                                        </form>
                                        <img src="{{ asset('img/' . $image) }}" alt="Banner Image" class="w-full rounded-md h-full object-cover">
                                    </div>
                                @endforeach
                            @endif

                        
                            <label class=" border-dashed border-[1px] border-slate-800 max-w-[150px] min-w-[100px] w-[15%] aspect-square p-2 cursor-pointer">
                                <div class="relative h-full w-full inset-0">
                                    <div class="absolute inset-0 w-full top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2 flex flex-col items-center justify-center">
                                        <i class="fa-solid fa-plus mb-1 text-slate-600 "></i>
                                        <label for="img" class="text-sm text-slate-600 cursor-pointer">Add Image</label>
                                        <label for="img" class="text-sm tracking-wider cursor-pointer"></label>
                                    </div>
                                </div>
                                <input type="file"  name="img[]" accept="image/*" class="hidden w-full h-full" id="img_slider" multiple>
                            </label>
                         
                        </div>

                        @error('img.*')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @error('img')
                         <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                </div>
            </div>

          
            <br>

            <hr class="mt-3 mb-5 h-[2px] w-full bg-slate-300">

            <p class="text-md font-extrabold text-black mt-6  inter">AI Detection</p>
            <p class="text-slate-700 text-sm inter leading-6">Change person counting system</p>

            <br>

            <hr class="mt-3 mb-5 h-[2px] w-full bg-slate-300">

            <br>

            @php
                $frames = $setting->frame;
            @endphp

            <div class="flex flex-row w-full items-center gap-3">
                <p class="w-[40%] max-w-[250px] text-sm font-semibold text-black  inter">Region Of Area</p>
                <div class="w-[70%] flex flex-col gap-6">
                    <button onclick="update_frame()" class="bg-blue-600 text-sm text-white rounded-lg shadow-md p-3 hover:bg-blue-800 cursor-pointer self-end">Update Frame</button>
                    <div class="w-full flex flex-row gap-2">
                        <div class="w-1/2 flex flex-col gap-3">
                            <div class="relative w-[320px] aspect-[2]">
                                 <img  class="w-full h-full cursor-pointer" id="enter_frame" src="{{ asset($frames['enter_frame']) }}" alt="">
                                 <svg class="absolute inset-0 w-full h-full pointer-events-none">
                                  
                                    <polygon id="defaultPloy" fill="none" stroke="red" stroke-width="2" />
                                </svg>
                                 <div data-action="enter" data-modal-target="default-modal" data-modal-toggle="default-modal" class="absolute modal inset-0 w-full h-full hover:bg-black hover:bg-opacity-[40%] cursor-pointer"></div>
                            </div>
                           
                        </div>
                        <div class="w-1/2 flex flex-col gap-3">
                            <div class="relative w-[320px] aspect-[2]">
                                <img class="w-full h-full cursor-pointer" id="exit_frame" src="{{ asset($frames['exit_frame']) }}" alt="">
                                <svg class="absolute inset-0 w-full h-full pointer-events-none">
                                  
                                    <polygon id="exit_defaultPloy" fill="none" stroke="red" stroke-width="2" />
                                </svg>
                                 <div data-action="exit" data-modal-target="default-modal" data-modal-toggle="default-modal" class="absolute modal inset-0 w-full h-full hover:bg-black hover:bg-opacity-[40%] cursor-pointer"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <br>

            <div class="flex flex-row w-full items-center gap-3">
                <p class="w-[40%] max-w-[250px] text-sm font-semibold text-black  inter">Detection Start Timer</p>
                <div class="w-[70%] flex flex-col gap-6">
                    <div class="w-full flex flex-row gap-2">
                      
                       
                        <div>
                            <label for="start-time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start time:</label>
                            <div class="relative w-40">
                                <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <input type="time" id="start-time" value="{{ old('start_time', $setting->start_time) }}" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  required />
                            </div>
                        </div>
                        <div>
                            <label for="end-time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End time:</label>
                            <div class="relative w-40">
                                <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <input type="time" value="{{ old('end_time', $setting->end_time) }}"  id="end-time" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                            </div>
                        </div>

                        <div class="flex items-center justify-center ml-4">
                            <input  id="manual" name="manual" {{$setting->is_manual == 1 ? 'checked' : '' }} type="checkbox"  class="w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-0 dark:focus:ring-0 dark:ring-offset-gray-800 focus:ring-0 dark:bg-gray-700 dark:border-gray-600">
                            <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Auto</label>
                        </div>
                      
                    </div>
                </div>
            </div>

           
            <br>
            
            <div class="flex flex-row items-center justify-end mt-6  gap-4 px-10">
                <button type="button"  class="border-none p-3 text-sm text-black bg-white rounded-lg shadow-sm cursor-pointer hover:bg-gray-300">Cancel</button>
                <button type="button" onclick="form_submit(event)" class="border-none p-3 text-sm text-white bg-blue-500 rounded-lg shadow-sm cursor-pointer hover:bg-blue-700">Save Changes</button>
            </div>

            </form>

            <form  method="POST" id="banner_delete" action="{{route("staff.setting.delete")}}" >
                @csrf
                @method('DELETE')
                <input type="hidden" name="key" id="key">
            </form>

         </div>

         @include('staff.setting.coordinate_setting');

       

    </main>


<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>



<!-- Initialize Quill editor -->
<script>
  const quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: [
        [{ 'font': [] }], 
        [{ 'color': [] }], 
        ['bold', 'italic', 'underline'], 
        [{ 'list': 'ordered' }, { 'list': 'bullet' }],
        [{ 'align': [] }],
        ['link']
      ]
    }
  });


function form_submit(e) {
    e.preventDefault();
    const form = document.getElementById('main_form');
    document.getElementById('description').value = quill.root.innerHTML;
    document.getElementById('start_time').value = document.getElementById('start-time').value
    document.getElementById('end_time').value = document.getElementById('end-time').value
    document.getElementById('is_manual').value = document.getElementById('manual').checked ? "1" : "0"
    console.log( document.getElementById('is_manual').value)
    form.submit();    
}


 async function update_frame(){

  try {
    const response = await axios.get('http://127.0.0.1:5000/frame_update');

    let [enterFrame, exitFrame] = response.data.frame;

    document.getElementById('enter_frame').src = `data:image/jpeg;base64,${enterFrame}`;
    document.getElementById('exit_frame').src = `data:image/jpeg;base64,${exitFrame}`;
   
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const patchResponse = await axios.patch('/staff/frame', {
            enter_frame: enterFrame,
            exit_frame: exitFrame
        }, {
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

    console.log(patchResponse.data)


  } catch (error) {
    console.error(error);
  }

 }


  function confirmDelete(key) {
        if (confirm("Are you sure you want to delete this banner?")) {
            document.getElementById('key').value = key;
            document.getElementById("banner_delete").submit();
        }
    }


  function logo_input(){

    const input =  document.getElementById('logo_input');
    input.click();

    document.getElementById("logo_input").addEventListener("change", function(event) {
    const file = event.target.files[0]; 
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("img").src = e.target.result;
        };
        reader.readAsDataURL(file); 
    }
    });
  }


  function banner2(){

    document.getElementById('banner2').click();

    document.getElementById('banner2').addEventListener('change', (event)=>{
            const banner_img2 = document.getElementById('holder_2');

            const file = event.target.files[0]; 

            if(file){
                const fileReader = new FileReader();

                fileReader.onload = function(e){
                   banner_img2.src = e.target.result;
                };

                fileReader.readAsDataURL(file); 
            }
           
        });
  }


    function banner3(){
        document.getElementById('banner3').click();

        document.getElementById('banner3').addEventListener('change', (event)=>{
                const banner_img3 = document.getElementById('holder_3');

                const file = event.target.files[0]; 

                if(file){
                    const fileReader = new FileReader();

                    fileReader.onload = function(e){
                    banner_img3.src = e.target.result;
                    };

                    fileReader.readAsDataURL(file); 
                }
            
            });
  }


        const imageInput = document.getElementById('img_slider');
        const imageContainer = document.getElementById('imageContainer');

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
                        divElement.className = "imageHolder relative max-w-[250px] min-w-[100px] w-[25%] aspect-[2] bg-white rounded-lg shadow-sm";
                        
                        const deleteIcon = document.createElement('i');
                        deleteIcon.className = "fa-solid fa-trash absolute top-3 rounded-full p-2 cursor-pointer text-red-500 hover:text-red-700 bg-slate-300 bg-opacity-[30%] hover:bg-opacity-[60%] right-4 flex items-center justify-center text-md";
                        
                        deleteIcon.onclick = () => {
                            fileArray.splice(index, 1); 
                            divElement.remove(); 
                        };

                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.className = "w-full rounded-md h-full";
                        
                        divElement.append(deleteIcon, imgElement);
                       
                        imageContainer.insertAdjacentElement('afterbegin', divElement);
                    };
    
                    reader.readAsDataURL(file); 
                }
            });
           
        });

                
        let setting_roi = @json($setting->roi);
     
        let exit_setting_roi = @json($setting->exit_roi);


        document.querySelectorAll('.modal').forEach((btn)=>{
            btn.addEventListener('click', (e)=>{
               const type = e.currentTarget.getAttribute('data-action');
               let ro; 

               if(type == 'exit'){
                  ro = `${exit_setting_roi[0].x},${exit_setting_roi[0].y} ${exit_setting_roi[1].x},${exit_setting_roi[1].y} ${exit_setting_roi[3].x},${exit_setting_roi[3].y} ${exit_setting_roi[2].x},${exit_setting_roi[2].y}`;
                 document.querySelector('.frame_model').src = "{{ asset($frames['exit_frame']) }}";
                 document.getElementById("CardPloy").setAttribute("points", ro);
                 document.getElementById('upd_btn').addEventListener('click', ()=>{
                    update_roi('exit');
                 });
               }else{
                  ro = `${setting_roi[0].x},${setting_roi[0].y} ${setting_roi[1].x},${setting_roi[1].y} ${setting_roi[3].x},${setting_roi[3].y} ${setting_roi[2].x},${setting_roi[2].y}`;
                 document.querySelector('.frame_model').src = "{{ asset($frames['enter_frame']) }}";
                 document.getElementById("CardPloy").setAttribute("points", ro);
                 document.getElementById('upd_btn').addEventListener('click', ()=>{
                    update_roi('enter');
                 });
               }
              
            });
        });

        
        let selectedP = null; 
        let points = {
            a: { x: 0, y: 0 },
            b: { x: 0, y: 0 },
            c: { x: 0, y: 0 },
            d: { x: 0, y: 0 },
        };

        const image = document.getElementById("enter_frame_model");
        const coordinates = document.getElementById("coordinates");
       

        image.addEventListener("mousemove", (event) => {
            
            const rect = image.getBoundingClientRect();
            
            
            const x = Math.floor(event.clientX - rect.left);
            const y = Math.floor(event.clientY - rect.top);

          
            coordinates.textContent = `X: ${x}, Y: ${y}`;
            coordinates.style.left = `${event.clientX - rect.left + 10}px`;
            coordinates.style.top = `${event.clientY - rect.top + 10}px`;
            coordinates.style.display = "block";
        });

        image.addEventListener("mouseleave", () => {
            coordinates.textContent = "X: 0, Y: 0"; 
            coordinates.style.display = "none";

         
        });

        image.addEventListener("contextmenu", (event) => {
            event.preventDefault(); 

            if (selectedP) {
                const rect = image.getBoundingClientRect();
                const x = Math.floor(event.clientX - rect.left);
                const y = Math.floor(event.clientY - rect.top);
                selectedP.textContent = `( ${x} , ${y} )`; 

                points[selectedP.id] = { x, y };

                updatePolygon();
            }
        });

        function updatePolygon() {
            const pts = `${points.a.x},${points.a.y} ${points.b.x},${points.b.y} ${points.d.x},${points.d.y} ${points.c.x},${points.c.y}`;
            document.getElementById("polygon").setAttribute("points", pts);
        }

     
        if(setting_roi) {
            const rois = `${setting_roi[0].x},${setting_roi[0].y} ${setting_roi[1].x},${setting_roi[1].y} ${setting_roi[3].x},${setting_roi[3].y} ${setting_roi[2].x},${setting_roi[2].y}`;
            document.getElementById("defaultPloy").setAttribute("points", rois);
        }

        if(exit_setting_roi) {
            const rois = `${exit_setting_roi[0].x},${exit_setting_roi[0].y} ${exit_setting_roi[1].x},${exit_setting_roi[1].y} ${exit_setting_roi[3].x},${exit_setting_roi[3].y} ${exit_setting_roi[2].x},${exit_setting_roi[2].y}`;
            document.getElementById("exit_defaultPloy").setAttribute("points", rois);
        }
       
       
        function select_pointer(button, pId) {
           
            document.querySelectorAll(".btn").forEach(btn => {
                btn.classList.remove("bg-blue-300");
                btn.classList.add("bg-blue-500");
            });

            button.classList.remove("bg-blue-500");
            button.classList.add("bg-blue-300");

            selectedP = document.getElementById(pId);
        }


       async function update_roi(way){
        try {
          
            const roi = [points.a, points.b, points.c, points.d];

            let response;

            if (way == 'enter'){
                 response = await axios.patch('/staff/roi', { roi } );
            }else{
                 response = await axios.patch('/staff/roi/exit', { roi } );
            }

            if(response){

                if(response.data.message == 'Succesfully Updated'){

                  const res =  await axios.get('http://127.0.0.1:5000/setting_update')

                }


                window.location.href = "/staff/setting";

            }
           
            console.log(response.data)


        } catch (error) {
            console.error(error);
        }
        }


       

</script>

</x-staff-app-layout>