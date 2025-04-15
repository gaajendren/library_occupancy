
<main class="pt-[98px] w-full flex justify-center items-center">
    <div class="container h-[80%] max-[500px]:mt-[30px] mt-[50px] flex items-center justify-center mx-auto p-10 pt-2 min-[1300px]:p-5 max-w-screen-xl">
        <div class="text-center flex-1 content flex flex-col justify-center box-border max-w-[700px]">
            <h1 class="max-[500px]:text-xl text-slate-300 montserrat-medium text-3xl tracking-widest mb-10">
                <span class="text-teal-200 block">{{$setting->title}}</span> Room Reservation
            </h1>
            <p class="max-[500px]:text-xs montserrat-regular text-slate-300 text-sm tracking-wider leading-relaxed">
                {!! $setting->description !!}
            </p>
            <div class="flex justify-center flex-row max-sm:gap-3 gap-10 mt-10"> 
               
                    <button class="max-lg:text-xs text-slate-200 uppercase montserrat-regular border-2 rounded-lg p-3 border-teal-200 hover:bg-teal-600 hover:border-teal-600 hover:text-white">
                        Reserve a Room
                    </button>
               
            </div>
        </div>
    </div>
</main>