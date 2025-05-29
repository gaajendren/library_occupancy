<x-staff-app-layout>
  
        <div class=" bg-slate-200 pb-14 max-sm: px-5">
            <h2 class="font-semibold text-2xl py-12 mb-10 h-10 text-gray-800 text-center w-full  dark:text-gray-900 leading-tight">
                Profile Update
            </h2>
            
            <div class="max-w-7xl h-fit mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-sm rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

               
            </div>
        </div>

       
</x-staff-app-layout>