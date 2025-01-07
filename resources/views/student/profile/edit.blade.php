<x-app-layout > 
  
    @include('student.partials.nav_bar')
    @include('staff.message.success')

    <div class="bg-[#0c0f16] pb-14 max-sm: px-5 pt-20 relative">
        <h2 class="font-semibold text-2xl py-12 mb-10 h-10 text-white text-center w-full   leading-tight">
            Profile Update
        </h2>
        
        <div class="max-w-7xl h-fit mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="max-w-xl bg-white">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

   
    <div class="absolute top-[35%] left-[80%]  rounded-full blur-[120px] opacity-60 bg-teal-300 w-[10%] h-[140px]"></div>

</x-app-layout >