<x-guest-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/css/intlTelInput.css">

    <style>
        @media (prefers-color-scheme: dark) {
    .iti {
        --iti-border-color: #5b5b5b;
        --iti-dialcode-color: #999999;
        --iti-dropdown-bg: #1f2937;
        --iti-arrow-color: #aaaaaa;
        --iti-hover-color: #30363d;
       
    }
        }

        .iti__search-input{
            background-color: #1f2937;
            color:white;
        }

        .iti__country-name{
            color:white;
        }

    </style>

    <section class="bg-gray-50 min-h-screen dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto h-full lg:py-0  w-full">
          
            <div class="w-full bg-white rounded-lg shadow-sm dark:border mt-16 mb-16  max-w-[600px] xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8 lg:p-10">
                    <div class="flex flex-row justify-between items-center gap-5">
 
                       
                        <form method="POST" id='form' action="{{ route('register') }}" class="slex flex-1 flex-col space-y-4 md:space-y-6" >
                            @csrf
                            
                            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                                Create an account
                            </h1>
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your name</label>
                                <input type="text"  name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ old('name') }}" required autocomplete="name" autofocus >
                                <x-input-error :messages="$errors->get('name')" class="mt-2 red" />
                            </div>
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" value="{{ old('email') }}" required autocomplete="email">
                                <x-input-error :messages="$errors->get('email')" class="mt-2 red" />
                            </div>

                            <div class="flex flex-row items-start justify-center">
                                <div class="flex-1 items-center">
                                    <label for="contact" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Contact</label>
                                    <div class="flex flex-row items-center gap-2">
                                        <input type="tel" oninput="process()" name="contact" id="contact" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  value="{{ old('contact') }}" required autocomplete="contact">                               
                                        <div>
                                            <div id='info_sucess' class="hidden" ><i class="fa-solid fa-circle-check fa-lg" style="color: green"></i></div>
                                            <div id='info_error' class="hidden" ><i class="fa-solid fa-circle-xmark fa-lg" style="color: red"></i></div>
                                        </div> 
                                    </div>
                                    <x-input-error :messages="$errors->get('contact')"  class="mt-2 red" />
                                    <p class="mt-2 text-red-600 hidden" id="contact-status">Invalid phone number.</p>
                                </div>

                                <div class="flex-1">
                                    <label for="ic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IC Number</label>
                                    <div class="flex flex-row items-center gap-2">
                                        <input type="text" name="ic" id="ic" maxlength='14'   placeholder="xxxx-xx-xxxx"  onblur="validateIC()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  value="{{ old('ic') }}" required autocomplete="ic">
                                        <div>
                                            <div id='ic_sucess' class="hidden" ><i class="fa-solid fa-circle-check fa-lg" style="color: green"></i></div>
                                            <div id='ic_error' class="hidden" ><i class="fa-solid fa-circle-xmark fa-lg" style="color: red"></i></div>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('ic')" class="mt-2 red" />
                                </div>

                            </div>

                            <div>
                                <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address</label>
                                <textarea name="address" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  value="{{ old('address') }}" required autocomplete="address"></textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2 red" />
                            </div>
                            <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                 
                                <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                                <p class="mb-2 mt-1 text-xs text-red-500 " id="lbl_pass"></p>
                                <x-input-error :messages="$errors->get('password')" class="mt-2 red"  />
                            </div>
                            <div>
                                <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
                                <input type="password" name="password_confirmation" id="confirm-password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                            </div>
                           
                            <button type="submit" id="btn_submit" onclick="submit_form(event)" class="cursor-pointer w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-hidden focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" >Create an account</button>
                            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                                Already have an account? <a href="/login" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Login here</a>
                            </p>
                        </form>
                    </div>
            </div>
        </div>
      </section>
                        
      <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/js/intlTelInput.min.js"></script>
      
          <script>
            const phoneInputField = document.querySelector("#contact");
            const phoneInput = window.intlTelInput(phoneInputField, {
                initialCountry: 'my',
                loadUtilsOnInit:
                "https://cdn.jsdelivr.net/npm/intl-tel-input@24.7.0/build/js/utils.js",
            });
        
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


            function submit_form(e){
              const form =   document.getElementById('form')
            
              e.preventDefault();
              
              if(validation == true){

                form.submit();
              }   
            }


            document.querySelector('#password').addEventListener('input', (e)=>{
                const password = e.target.value;
                const label = document.getElementById('lbl_pass');

                const isLongEnough = password.length >= 8;
                const hasUppercase = /[A-Z]/.test(password);
                const hasLowercase = /[a-z]/.test(password);

                if (isLongEnough && hasUppercase && hasLowercase) {
                    label.style.color = 'green';
                    label.textContent = 'Password looks good!';
                } else {
                    label.style.color = 'red';
                    label.textContent = 'Password must be at least 8 characters and include uppercase and lowercase letters.';
                }
            })

    



          </script>  
  


</x-guest-layout>
