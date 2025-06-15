<x-staff-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <div class="h-full w-full flex items-start justify-center contains">
        <div class="w-full h-full  max-w-[1900px]">
            <header class="text-slate-800 pt-5 font-semibold text-xl tracking-wider text-center w-full">Person</header>
            
            <div class="w-full flex justify-end   items-end flex-col p-4 ">
                <div class="w-fit rounded-lg shadow-md bg-white flex flex-row p-1 justify-center items-center ">
                    <button class="cursor-pointer bg-none p-2  hover:bg-gray-200 hover:rounded-lg" onclick="if (isDouble) { return false; } else { double_switch(); }"><i class="fa-solid fa-table-columns text-gray-600"></i></button>
                    <div class="self-stretch w-px bg-gray-300 mx-1"></div>
                    <button class="cursor-pointer bg-none p-2  hover:bg-gray-200 hover:rounded-lg" onclick="if (!isDouble) { return false; } else { exit_double_switch(); } "><i class="fa-regular fa-square text-gray-600"></i></button>
                </div>
            </div>

            <div class="p-4 rounded-lg mx-4 shadow-xs bg-white h-fit my-4 ">
                <div class="flex w-full justify-start gap-5  items-center">
                    <div class="form-group group ">
                        <div class='p-2.5 py-0  flex flex-row items-center rounded-lg justify-start border border-1 border-gray-300'>
                            <p class="font-bold text-sm text-gray-800">Date</p>
                            <div class="relative max-w-sm">
                                <div class="absolute inset-y-0 end-0 flex items-center  pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                    </svg>
                                </div>
                                <input id="datepicker-actions" datepicker datepicker-buttons datepicker-autoselect-today  type="text" class="bg-white border border-none focus:ring-0  text-gray-900 text-sm rounded-lg  block max-w-36  ps-4 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  autocomplete='off'  placeholder="Select date">
                            </div>
                        </div>
                    </div>
                    {{-- <div class="form-group group " onclick="this.querySelector('.time').focus(); return true;">
                        <div for='time' class='p-2.5 py-0  flex flex-row items-center rounded-lg justify-start border border-1 border-gray-300' >
                            <p for='time' class="font-bold text-sm block w-full text-gray-800">Start Time</p>
                            <input type="time" id="time" class="bg-white border cursor-pointer time border-none text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-none w-full p-2.5 " min="09:00" max="18:00" value="00:00" required />
                            <div class="flex items-center" for='time'>
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="form-group group " onclick="this.querySelector('.end_time').focus(); return true;">
                        <div for='time' class='p-2.5 py-0  flex flex-row items-center rounded-lg justify-start border border-1 border-gray-300' >
                            <p for='time' class="font-bold text-sm block w-full text-gray-800">Start Time</p>
                            <input type="time" id="end_time" class="bg-white border cursor-pointer end_time border-none text-gray-900 text-sm rounded-lg focus:ring-0 focus:border-none w-full p-2.5 " min="09:00" max="18:00" value="00:00" required />
                            <div class="flex items-center" for='time'>
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                    </div> --}}
                    <div class="form-group group">
                        <div class='p-2.5 py-0.5 flex flex-row items-center rounded-lg justify-start border border-1 border-gray-300'>
                            <p class="font-bold text-sm text-gray-800">Sort</p>
                            <select id="p_type"  class="bg-white border border-none  focus:ring-0  text-gray-800 text-sm rounded-lg block w-full  dark:bg-gray-700 dark:text-white ">
                                <option value="still" class="text-gray-800" selected>Still at library</option>
                                <option value="exit" class="text-gray-800">Exited</option> 
                                <option value="enter" class="text-gray-800">Walk In</option> 
                                <option value="no_detect" class="text-gray-800">Not Detected</option>
                            </select>
                        </div>
                       
                    </div>
                    <div class="form-group group flex ">
                        <button type="button" class="text-white bg-gray-600 hover:bg-gray-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5   dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-hidden dark:focus:ring-blue-800" onclick='filter()'>Apply</button>
                    </div>
                
                </div>
            </div>

            <div class="mx-4 rounded-lg border border-gray-300 shadow-xs bg-white my-4 flex flex-wrap flex-col  h-fit">
                <div class="self-end rounded-t-lg p-2 text-gray-600 content-end w-full bg-gray-100 border-b border-gray-300">Person count</div>
                <div class="flex flex-row p-4 max-h-[110px]">
                    <div class= "border-l-4 p-2 m-2 w-1/4 h-fit border-emerald-500 ">
                        <div class="flex flex-col pl-2 justify-start items-start">
                            <label class="text-slate-500 text-sm" for="">In the library</label>
                            <p id='person_at_library' class="text-slate-600 text-lg font-bold">{{$sum_person_at_library ?? ''}}</p>
                        </div>
                    </div>
                    <div class=" border-l-4 p-2 m-2 w-1/4 h-fit border-yellow-500 ">
                        <div class="flex flex-col pl-2 justify-start items-start">
                            <label class="text-slate-500 text-sm" for="">Exited</label>
                            <p id='person_exit' class="text-slate-600 text-lg font-bold">{{$sum_person_exit ?? ''}}</p>
                        </div>
                    </div>
                    <div class="border-l-4 p-2 m-2 w-1/4 h-fit border-blue-500 ">
                        <div class="flex flex-col pl-2 justify-start items-start">
                            <label class="text-slate-500 text-sm" for="">Walked In</label>
                            <p id='person_enter' class="text-slate-600 text-lg font-bold">{{$sum_person_enter ?? ''}}</p>
                        </div>
                    </div>
                    <div class=" border-l-4 p-2 m-2 w-1/4 h-fit border-red-500 ">
                        <div class="flex flex-col pl-2 justify-start items-start">
                            <label class="text-slate-500 text-sm " for="">Not detected</label>
                            <p id='no_detect' class="text-slate-600 text-lg font-bold"> {{$sum_no_detect}}</p>
                        </div>
                    </div>
                </div>
               
            </div>

            

           

            <div class="w-full p-4">
                <div id="bg" class="absolute inset-0 w-full  bg-black bg-opacity-80 hidden z-10"></div>
                <div id='img_wrapper' class="flex flex-row gap-3">
                    <div id="img_holder" name='' class="flex flex-row flex-wrap sm:gap-2 md:gap-5 gap-5 justify-start items-center w-full">
                        @foreach ($person as $item)
                            
                            <div  class="img-item w-[17%] max-w-[120px] min-w-[90px] h-[220px] bg-white rounded-xl shadow-xs aspect-auto overflow-hidden cursor-pointer " onclick="checker(event)" >
                                <img src="http://127.0.0.1:5000/person_img/{{$item->img}}" alt="img" class=" w-full h-full  object-fill object-center">
                                <div aria-hidden="true"  class="absolute inset-0 top-0  flex justify-center items-center w-full h-full  aspect-auto overflow-hidden hidden modalView z-20">
                                
                                    @if ($item->personExit)
                                    <div class="rounded-xl shadow-xs bg-white w-[190px] aspect-auto p-3 flex flex-col items-center justify-center">
                                        <img src="http://127.0.0.1:5000/person_img/{{$item->personExit->img}}" alt="img" class=" w-full max-w-[140px] min-w-[90px] h-[250px]  object-fill object-center"> 
                                      
                                    </div>
                                    @else
                                    <p class="text-white">Sorry that person not exited yet or not detected</p>
                                    @endif
                                </div>
                            </div>  
                      
                        @endforeach
                        
                    </div>

                </div>
              
                   
            </div> 
        </div>
    </div>

    <script>
        const template = (item, opposite_item) => `<div class="img-item w-[17%] max-w-[120px] min-w-[90px] h-[220px] bg-white rounded-xl shadow-xs aspect-auto overflow-hidden  cursor-pointer " onclick="checker(event)" >
                            <img src="http://127.0.0.1:5000/person_img/${item["img"]}" alt="img" class=" w-full h-full  object-fill object-center">
        
                            <div aria-hidden="true"  class="absolute inset-0 top-0  flex justify-center items-center w-full h-full  aspect-auto overflow-hidden hidden modalView z-20">                       
                        
                            <div class="rounded-xl shadow-xs bg-white w-[190px] aspect-auto p-3 flex flex-col items-center justify-center">
                                <img src="http://127.0.0.1:5000/person_img/${opposite_item['img']}" alt="img" class=" w-full max-w-[140px] min-w-[90px] h-[250px]  object-fill object-center"> 
                                <button class="rounded-xl bg-blue-400 hover:bg-blue-700 p-1 px-2 mt-3 " >No</button>
                            </div>
                                                        
                         </div></div>`

        const no_detect_template = (item , isSecondWindow) => `<div class="img-item w-[17%] max-w-[120px] min-w-[90px] h-[220px] bg-white rounded-xl shadow-xs aspect-auto overflow-hidden cursor-pointer " onclick="checker(event)" >
                                                <img src="${isSecondWindow ? '/img/person_sign.png' : `http://127.0.0.1:5000/person_img/${item['img']}`}" alt="img" class=" w-full h-full  object-fill object-center">
                                                <div aria-hidden="true"  class="absolute inset-0 top-0  flex justify-center items-center w-full h-full  aspect-auto overflow-hidden hidden modalView z-20">
                                                    <p class="text-white">Sorry that person not exited yet or not detected</p>
                                                    </div>
                                    </div>`


        const person_at_library = document.getElementById('person_at_library')
        const person_exit = document.getElementById('person_exit')
        const person_enter = document.getElementById('person_enter')
        const no_detect = document.getElementById('no_detect')
        const img_holder = document.getElementById('img_holder')
     
        let isDouble = false;


        function checker(e){
          
           const modal = e.currentTarget.closest('div').querySelector('.modalView')
           const Bgopacity = document.getElementById('bg')
           modal.classList.toggle('hidden')
           Bgopacity.classList.toggle('hidden')
           
        }


        function filter(){
           const date = document.getElementById('datepicker-actions');
           const sort = document.getElementById('p_type');

           if(isDouble == true){
           const second_img_holder = document.getElementById('second_img_holder');
           }

           const dateValue = date.value || new Date().toLocaleDateString(); 
           const sortValue = sort.value || ''; 
        
           const params = new URLSearchParams();

            if (dateValue) params.append('date', dateValue); 
            if (sortValue) params.append('sort', sortValue); 

            console.log(sortValue)

            occupancy_api(params, isDouble).then(function (result) {

                const { new_html, second_new_html } = result;

                if(second_new_html){
                    img_holder.innerHTML = new_html;
                    second_img_holder.innerHTML = second_new_html;
                }else{
                    img_holder.innerHTML = new_html;
                }
            });    
        }

        function double_switch(){

           const date = document.getElementById('datepicker-actions');
           const img_wrapper = document.getElementById('img_wrapper');
           
           const dateValue = date.value || new Date().toLocaleDateString(); 
             
          
           isDouble = true;
            
           img_holder.classList.remove('w-full')
           img_holder.classList.add('w-1/2')

        //    const opposite_sort = img_holder.getAttribute('name')


        //    const params = new URLSearchParams();

        //     if (dateValue) params.append('date', dateValue); 
        //     if (sort) params.append('sort', sort); 

            if(! document.getElementById('second_img_holder')){
                const second_img_holder = document.createElement('div');
                second_img_holder.id = 'second_img_holder';
                second_img_holder.className = 'flex flex-row flex-wrap sm:gap-2 md:gap-5 gap-5 justify-start items-center w-1/2';
                const divider = document.createElement('div');
                divider.id = 'divider';
                divider.className = 'self-stretch w-[3px] bg-gray-500 mx-1';
                img_wrapper.appendChild(divider)
                img_wrapper.appendChild(second_img_holder);
            }

           filter()

        }

        function exit_double_switch(){
            isDouble = false;

            img_holder.classList.add('w-full')
            img_holder.classList.remove('w-1/2')

            const second_img_holder = document.getElementById('second_img_holder');
            const divider = document.getElementById('divider')
            
            if (second_img_holder) {
                second_img_holder.remove();
                divider.remove();
            } else {
                console.log('Element not found');
            }

            filter()
            
        }


        function occupancy_api(params, isDouble){

        return axios.get(`/api/occupancy?${params.toString()}`)
           .then(function (response) {
                let new_html = ''
                let second_new_html = ''

              
                const data = response.data['data']; 
                const opposite_way = response.data['opposite']
                const sort = response.data['sort']

                console.log(data)

                 person_at_library.innerHTML = response.data['sum_person_at_library']
                 person_exit.innerHTML = response.data['sum_person_exit']
                 person_enter.innerHTML = response.data['sum_person_enter']
                 no_detect.innerHTML = response.data['sum_no_detect']


                const items = Array.isArray(data) ? data : Object.values(data);
                let opposite = [];

                 
                opposite = Array.isArray(opposite_way) ? opposite_way : Object.values(opposite_way);
                
               
                items.forEach(function(item){
                    console.log(item);  
                    console.log(item['img']);
                    let item_html = '';
                    let second_item_html = '';

                    if(sort != 'still'  && sort != 'no_detect') {

                        if(sort == 'enter' && item['person_id_exit'] == null){

                                    item_html   += no_detect_template(item , false)
                                    if(isDouble){
                                    second_item_html   += no_detect_template(item , true)
                                    }
                                             
                        }
                       
                        opposite.forEach(function(opposite_item){
                            if(sort == 'enter' ){
                                
                                if(item['person_id_exit'] == opposite_item['id']){

                                    item_html +=  template(item , opposite_item)

                                    if(isDouble){
                                        console.log('here pass')
                                        second_item_html +=  template(opposite_item, item)
                                    }
                                }

                              
                            }else if(sort == 'exit'){
                                 
                                if(item['id'] == opposite_item['person_id_exit']){

                                item_html +=  template(item , opposite_item)

                                if(isDouble){
                                    console.log('here pass')
                                    second_item_html +=  template(opposite_item, item)
                                }
                                }
                            }
                        });
                    }else{
                        item_html   += no_detect_template(item , false)
                    } 

                    new_html += item_html;

                    if(isDouble){
                        second_new_html +=  second_item_html
                    }
                    
                });
                img_holder.setAttribute('name', sort)
                
                if(sort == 'still' || sort == 'no_detect'){
                    opposite.forEach(function(opposite_item){
                        if(isDouble){
                            second_new_html += no_detect_template(opposite_item , false)
                        }
                    });
                }
                    
                return { new_html, second_new_html };
                
                
            })
            .catch(function (error) { 
                console.log(error);
                return { new_html: '', second_new_html: '' };
            })
           

        }


        function template_generator(item , opposite_item){
            if(item['person_id_exit'] == opposite_item['id']){

            item_html +=  template(item , opposite_item)

            if(isDouble){
                console.log('here pass')
                second_item_html +=  template(opposite_item, item)
            }
         }
        }

    </script>
   
</x-staff-app-layout>
