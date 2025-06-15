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

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .gradient-header {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
        }

        .settings-section {
            border-left: 4px solid #6366f1;
            padding-left: 1.5rem;
            margin: 2rem 0;
        }

        .image-upload-card {
            @apply transition-all duration-300 border-2 border-dashed border-gray-200 hover:border-indigo-300 hover:bg-gray-50;
        }
    </style>




    <main class="min-h-screen  py-8 px-4 sm:px-6 lg:px-8">
        
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

        <div class="gradient-header rounded-2xl p-6 mb-8 text-white">
            <h1 class="text-3xl font-bold mb-2">System Settings</h1>
            <p class="opacity-90">Manage application appearance and detection configurations</p>
        </div>

        <form action="{{route('staff.update.setting')}}" method="post" name="main-form" id="main_form"
            enctype="multipart/form-data">
            @csrf
            @method('PATCH')


            <div class="glass-card rounded-xl p-6 mb-8">
                <div class="settings-section">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                        Appearance Settings
                    </h2>

                    <!-- Logo Upload -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                            <div onclick="logo_input()" class="image-upload-card w-[150px] aspect-square rounded-xl bg-white cursor-pointer flex items-center justify-center overflow-hidden">
                                <img id="img" src="{{url($setting->logo)}}" alt="Logo" class="w-full h-full object-contain p-4">
                                 <input type="file" accept="image/*" id="logo_input" class="w-full h-full" name="logo" hidden>
                            </div>
                        </div>

                        <!-- Title Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Application Title</label>
                            <input type="text" value="{{$setting->title}}" name="title" 
                                   class="w-full rounded-lg border-gray-200 focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition">
                        </div>
                    </div>

                    <!-- Description Editor -->
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <div id="editor" class="bg-white  border border-gray-200">{!! $setting->description !!}</div>
                         <input type="hidden" name="description" id="description">
                    </div>

                         <input type="hidden" name="start_time" id="start_time">
                        <input type="hidden" name="end_time" id="end_time">
                        <input type="hidden" name="is_manual" id="is_manual">

                </div>

                  @php
                    $banners = json_decode($setting->banner, true);
                  @endphp

                 <div class="settings-section mt-10">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Banner Configuration
                    </h3>

                    <!-- Side Banners -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="max-w-72">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Left Banner</label>
                                <div onclick="banner2()" class="image-upload-card aspect-[2/1] rounded-xl bg-gray-50 cursor-pointer overflow-hidden">
                                    <img id="holder_2" src="{{asset('img/' . ($banners['banner_2']))}}" class="w-full h-full object-cover">
                                    <input type="file" name="banner_2" class="hidden w-full h-full" accept="image/*" id="banner2">
                                </div>
                            </div>
                            <div class="max-w-72">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Right Banner</label>
                                <div onclick="banner3()" class="image-upload-card aspect-[2/1] rounded-xl bg-gray-50 cursor-pointer overflow-hidden">
                                    <img id="holder_3" src="{{asset('img/' . ($banners['banner_3']))}}" class="w-full h-full object-cover">
                                    <input type="file" name="banner-3" class="hidden w-full h-full" accept="image/*" id="banner3">
                                </div>
                            </div>
                        </div>    
                    </div>

                    <!-- Slider Images -->
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Slider Images</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="imageContainer" >
                            @foreach($banners['slider_image'] as $key => $image)
                            <div class="group relative  rounded-lg overflow-hidden aspect-video">
                                <img src="{{ asset('img/' . $image) }}" class="w-full h-full object-cover">
                                <button type="button" onclick="confirmDelete('{{ $key }}')" 
                                        class="absolute top-2 right-2 p-1.5 bg-white/90 rounded-full shadow-sm hover:bg-red-100 transition">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                            @endforeach
                            
                            <label class="image-upload-card aspect-video rounded-lg flex flex-col items-center justify-center cursor-pointer">
                                <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <span class="text-sm text-gray-500 cursor-pointer">Upload Images</span>
                                <input type="file" name="img[]" accept="image/*" class="hidden" id="img_slider" multiple>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
       



        @error('img.*')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        @error('img')
            <span class="text-danger">{{ $message }}</span>
        @enderror


        @php
            $frames = $setting->frame;
        @endphp

         <!-- AI Detection Section -->
            <div class="glass-card rounded-xl p-6 mb-8">
                <div class="settings-section">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                        </svg>
                        AI Detection Settings
                    </h3>

                    <!-- Region of Interest -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4">Detection Zones</label>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="relative w-[320px] aspect-[2] rounded-xl overflow-hidden shadow-sm">
                                    <img id="enter_frame" src="{{ asset($frames['enter_frame']) }}" class="w-full h-auto">
                                    <div class="absolute bottom-0 left-0 right-0 bg-black/50 text-white p-2 text-sm">
                                        Entry Detection Zone
                                    </div>
                                     <svg class="absolute inset-0 w-full h-full pointer-events-none">
                                        <polygon id="defaultPloy" fill="none" stroke="red" stroke-width="2" />
                                    </svg>
                                    <div data-action="enter" data-modal-target="default-modal" data-modal-toggle="default-modal"
                                        class="absolute modal inset-0 w-full h-full hover:bg-black/40 hover:bg-opacity-[40%] cursor-pointer">
                                    </div>
                                </div>
                                <div class="relative w-[320px] aspect-[2] rounded-xl overflow-hidden shadow-sm">
                                    <img id="exit_frame" src="{{ asset($frames['exit_frame']) }}" class="w-full h-auto">
                                    <div class="absolute bottom-0 left-0 right-0 bg-black/50 text-white p-2 text-sm">
                                        Exit Detection Zone
                                    </div>
                                    <svg class="absolute inset-0 w-full h-full pointer-events-none">
                                        <polygon id="exit_defaultPloy" fill="none" stroke="red" stroke-width="2" />
                                    </svg>
                                    <div data-action="exit" data-modal-target="default-modal" data-modal-toggle="default-modal"
                                            class="absolute modal inset-0 w-full h-full hover:bg-black/40 cursor-pointer">
                                    </div>
                                </div>
                            </div>
                            <button type="button" onclick="update_frame()" 
                                    class="mt-4 w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Update Detection Frames
                            </button>
                        </div>

                        <!-- Detection Timing -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4">Detection Schedule</label>
                            <div class="space-y-4 bg-gray-50 rounded-xl p-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm text-gray-600 mb-2">Start Time</label>
                                        <input type="time" id="start-time" value="{{ old('start_time', $setting->start_time) }}" 
                                               class="w-full rounded-lg border-gray-200 focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition">
                                    </div>
                                    <div>
                                        <label class="block text-sm text-gray-600 mb-2">End Time</label>
                                        <input type="time" id="end-time" value="{{ old('end_time', $setting->end_time) }}" 
                                               class="w-full rounded-lg border-gray-200 focus:border-indigo-300 focus:ring-1 focus:ring-indigo-200 transition">
                                    </div>
                                </div>
                                <label class="flex items-center space-x-2">
                                    <input id="manual" name="manual" type="checkbox" {{$setting->is_manual == 1 ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm text-gray-600">Enable Automatic Detection</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

     
        <div class="glass-card rounded-xl p-4 flex justify-end gap-4">
                <button type="button" class="px-6 py-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    Cancel
                </button>
                <button type="button" onclick="form_submit(event)"
                        class="px-6 py-2 cursor-pointer bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Save Changes
                </button>
            </div>
        </form>

    
        <form method="POST" id="banner_delete" action="{{route("staff.setting.delete")}}">
            @csrf
            @method('DELETE')
            <input type="hidden" name="key" id="key">
        </form>
        
        @include('staff.setting.coordinate_setting')

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
            console.log(document.getElementById('is_manual').value)
            form.submit();
        }


        async function update_frame() {

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


        function logo_input() {

            const input = document.getElementById('logo_input');
            input.click();

            document.getElementById("logo_input").addEventListener("change", function (event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById("img").src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }


        function banner2() {

            document.getElementById('banner2').click();

            document.getElementById('banner2').addEventListener('change', (event) => {
                const banner_img2 = document.getElementById('holder_2');

                const file = event.target.files[0];

                if (file) {
                    const fileReader = new FileReader();

                    fileReader.onload = function (e) {
                        banner_img2.src = e.target.result;
                    };

                    fileReader.readAsDataURL(file);
                }

            });
        }


        function banner3() {
            document.getElementById('banner3').click();

            document.getElementById('banner3').addEventListener('change', (event) => {
                const banner_img3 = document.getElementById('holder_3');

                const file = event.target.files[0];

                if (file) {
                    const fileReader = new FileReader();

                    fileReader.onload = function (e) {
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
                        divElement.className = "imageHolder group relative rounded-lg overflow-hidden aspect-video";


                        const deleteIcon = document.createElement('i');
                        deleteIcon.className = "fa-solid fa-trash text-red-600 absolute top-2 right-2 p-1.5 bg-white/90 rounded-full shadow-sm hover:bg-red-100 transition";

                        deleteIcon.onclick = () => {
                            fileArray.splice(index, 1);
                            divElement.remove();
                        };

                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.className = "w-full h-full object-cover";

                        divElement.append(imgElement, deleteIcon);

                        imageContainer.insertAdjacentElement('afterbegin', divElement);
                    };

                    reader.readAsDataURL(file);
                }
            });

        });


        let setting_roi = @json($setting->roi);

        let exit_setting_roi = @json($setting->exit_roi);


        document.querySelectorAll('.modal').forEach((btn) => {
            btn.addEventListener('click', (e) => {
                const type = e.currentTarget.getAttribute('data-action');
                let ro;

                if (type == 'exit') {
                    ro = `${exit_setting_roi[0].x},${exit_setting_roi[0].y} ${exit_setting_roi[1].x},${exit_setting_roi[1].y} ${exit_setting_roi[3].x},${exit_setting_roi[3].y} ${exit_setting_roi[2].x},${exit_setting_roi[2].y}`;
                    document.querySelector('.frame_model').src = "{{ asset($frames['exit_frame']) }}";
                    document.getElementById("CardPloy").setAttribute("points", ro);
                    document.getElementById('upd_btn').addEventListener('click', () => {
                        update_roi('exit');
                    });
                } else {
                    ro = `${setting_roi[0].x},${setting_roi[0].y} ${setting_roi[1].x},${setting_roi[1].y} ${setting_roi[3].x},${setting_roi[3].y} ${setting_roi[2].x},${setting_roi[2].y}`;
                    document.querySelector('.frame_model').src = "{{ asset($frames['enter_frame']) }}";
                    document.getElementById("CardPloy").setAttribute("points", ro);
                    document.getElementById('upd_btn').addEventListener('click', () => {
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


        if (setting_roi) {
            const rois = `${setting_roi[0].x},${setting_roi[0].y} ${setting_roi[1].x},${setting_roi[1].y} ${setting_roi[3].x},${setting_roi[3].y} ${setting_roi[2].x},${setting_roi[2].y}`;
            document.getElementById("defaultPloy").setAttribute("points", rois);
        }

        if (exit_setting_roi) {
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


        async function update_roi(way) {
            try {

                const roi = [points.a, points.b, points.c, points.d];

                let response;

                if (way == 'enter') {
                    response = await axios.patch('/staff/roi', { roi });
                } else {
                    response = await axios.patch('/staff/roi/exit', { roi });
                }

                if (response) {

                    if (response.data.message == 'Succesfully Updated') {

                        const res = await axios.get('http://127.0.0.1:5000/setting_update')

                    }


                    window.location.href = "/staff/setting";

                }

                console.log(response.data)


            } catch (error) {
                console.error(error);
            }
        }




    </script>

</x-staff-app-layout> =