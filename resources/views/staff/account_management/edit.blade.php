<div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 min-h-[100%] ">
    <div class="absolute top-0 left-0 bg-gray-700 w-full min-h-[120%] h-full opacity-60" style="bottom: auto;"></div>
    <div class="relative p-4 w-full sm:max-w-md md:max-w-lg  max-w-md  max-h-full my-10">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="title text-xl font-semibold text-gray-900 dark:text-white">
                 
                </h3>
                <button type="button" onclick="reset()" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-4 space-y-5">
                <form method="POST" action="" id='form' class="max-w-sm mx-auto">
                    @csrf
                    <input type="hidden" name="_method" id='method' value="PATCH">
                    <div class="mb-5">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" id="name" name='name'  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                        @error('name')
                        <div class="text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-5">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name='email' id="email"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  required />
                        @error('email')
                        <div class="text-red-400">{{ $message }}</div>
                        @enderror   
                    </div>

                    <div class="mb-5 flex flex-row w-full">
                        <div class="flex flex-col w-1/2 items-start justify-start">
                            <label for="contact" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact</label>
                            <div class="flex flex-row items-center gap-2">
                                <input type="tel" oninput="process()" name="contact" id="contact" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  value="{{ old('contact') }}" required autocomplete="contact">                               
                                <div>
                                    <div id='info_sucess' class="hidden" ><i class="fa-solid fa-circle-check fa-lg mr-2" style="color: green"></i></div>
                                    <div id='info_error' class="hidden" ><i class="fa-solid fa-circle-xmark fa-lg mr-2" style="color: red"></i></div>
                                </div> 
                            </div>
                            <p class="mt-2 text-red-600 hidden" id="contact-status">Invalid phone number.</p>
                            @error('contact')
                            <div class="text-red-400">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="flex flex-col  w-1/2 items-start justify-start">
                            <label for="ic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IC No</label>
                            <div class="flex flex-row items-center gap-2">
                                <input type="text" name="ic" id="ic" maxlength='14'   placeholder="xxxx-xx-xxxx"  onblur="validateIC()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  value="{{ old('ic') }}" required autocomplete="ic">
                                <div>
                                    <div id='ic_sucess' class="hidden" ><i class="fa-solid fa-circle-check fa-lg" style="color: green"></i></div>
                                    <div id='ic_error' class="hidden" ><i class="fa-solid fa-circle-xmark fa-lg" style="color: red"></i></div>
                                </div>
                            </div>
                        </div>
                        @error('ic')
                        <div class="text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                        <textarea name="address" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  value="{{ old('address') }}" required autocomplete="address"></textarea>

                        @error('address')
                        <div class="text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-5">
                        <label for="roles" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Role</label>
                        <select id="roles" name='roles' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                          <option id='student' value='0' >Student</option>
                          <option id='staff' value='1' >Staff</option>
                        </select>
                        @error('roles')
                        <div class="text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                   
        
                    <button type="submit" id='submit' class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mb-2">Submit</button>
                </form>
            </div>
        
           
        </div>
    </div>
</div>



      
<script>
  const phoneInputField = document.querySelector("#contact");
  const phoneInput = window.intlTelInput(phoneInputField, {
      initialCountry: 'my',
      loadUtilsOnInit:
      "https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/js/utils.js",
  });

  
  function reset(){
    document.getElementById('name').value = ""
    document.getElementById('ic').value = ""
    document.getElementById('contact').value = ""
    document.getElementById('address').value = ""
    document.getElementById('email').value = ""
    document.getElementById('roles').value =""
    
  }

  const error = document.querySelector("#contact-status");
  const info_sucess = document.querySelector("#info_sucess");
  const info_error = document.querySelector("#info_error");
  
  let validation = false

  function process() {

    const phoneNumber = phoneInput.getNumber();
    console.log(phoneInput.isValidNumber()); 

      if (phoneInput.isValidNumber()) {
          info_sucess.classList.add('visible')
          info_sucess.classList.remove('hidden')
          info_error.classList.add('hidden')
          info_error.classList.remove('visible')
          error.classList.remove("red")

          error.classList.add("hidden")
          error.classList.remove('visible')
          validation = true
      } else {
          info_sucess.classList.remove('visible')
          info_sucess.classList.add('hidden')
          info_error.classList.add('visible')
          info_error.classList.remove('hidden')

          error.classList.add("visible")
          error.classList.remove('hidden')
          validation = false
        
      }
  }


  function validateIC() {
                let icNumber = document.getElementById('ic').value;

                icNumber = icNumber.replace(/\D/g, '');

               
                if (icNumber.length >= 7) {
                    
                    icNumber = icNumber.slice(0, 6) + '-' + icNumber.slice(6, 8) + '-' + icNumber.slice(8, 12);
                }
              
                document.getElementById('ic').value = icNumber;

                const regex = /^((([02468][048]|[13579][26])(02)(29))|((\d{2})((0[1-9]|1[0-2])(0[1-9]|1\d|2[0-8])|(0[1|3-9]|1[0-2])(29|30)|(0[13578]|1[02])(31))))\-(\d{2})\-(\d{4})$/;

                const ic_sucess = document.querySelector("#ic_sucess");
                const ic_error = document.querySelector("#ic_error");
               
                if (regex.test(icNumber)) {
                    ic_sucess.classList.add('visible')
                    ic_sucess.classList.remove('hidden')
                    ic_error.classList.add('hidden')
                    ic_error.classList.remove('visible')
                    validation = true
                }else{
                    ic_sucess.classList.remove('visible')
                    ic_sucess.classList.add('hidden')
                    ic_error.classList.add('visible')
                    ic_error.classList.remove('hidden')
                    validation = false
                }
            }

  </script>



