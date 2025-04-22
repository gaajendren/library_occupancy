
<style>
    input[type='date']{     
    color-scheme: dark;
    }
</style>
<div class="w-full flex  justify-center items-center">
    <div class="max-w-(--breakpoint-xl) w-full mx-auto md:gap-10 sm:gap-6 gap-4 md:m-[2rem] sm:m-[1rem] m-[1rem] md:p-[2rem] sm:p-[1rem] p-[1rem] dark">
        <div class="w-full mx-auto rounded-2xl shadow-lg max-w-(--breakpoint-xl) bg-gray-800 flex flex-col items-center justify-center border-teal-200">

            <div class="flex flex-row justify-center items-sketch w-full p-2 mx-3 mt-2 gap-3">
                <div class="w-full relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" oninput='filter(this)' id='search' name='search' class="block w-full p-4 ps-10 text-sm text-gray-900  rounded-xl shadow-lg  bg-gray-900 dark:border-none  dark:text-white" placeholder="Search" />
                </div>
            

        
                <input type="date" onchange='filter(this)' class="rounded-xl text-gray-200 dark:bg-gray-900  shadow-lg border-none p-3 px-4" name="date" id="date">
                <select oninput='filter(this)' class="rounded-xl  text-gray-200  dark:bg-gray-900 border-none  shadow-lg p-3 px-4" name="seat" id="seat">
                    <option selected disabled>Total Student:  &nbsp; &nbsp;&nbsp;&nbsp;</option>
                    <option value="all">All</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">More than 3</option>
                    <option value="10">More than 10</option>
                </select>
            </div>

            <div class="flex flex-row self-start flex-wrap gap-2 p-3">
                <div  class="rounded-xl shadow-lg montserrat-regular  hover:bg-gray-700 bg-gray-900 p-2 px-3 ">
                    <p  class="cursor-pointer  text-slate-200 text-semibold text-sm">Hikmah</p>
                </div>
                <div  class="rounded-xl shadow-lg montserrat-regular  hover:bg-gray-700 bg-gray-900 p-2 px-3 ">
                    <p  class="cursor-pointer  text-slate-200 text-semibold text-sm">Iqra</p>
                </div>
                <div  class="rounded-xl shadow-lg montserrat-regular  hover:bg-gray-700 bg-gray-900 p-2 px-3 ">
                    <p  class="cursor-pointer  text-slate-200 text-semibold text-sm">Journal</p>
                </div>
                <div  class="rounded-xl shadow-lg montserrat-regular  hover:bg-gray-700 bg-gray-900 p-2 px-3 ">
                    <p  class="cursor-pointer  text-slate-200 text-semibold text-sm">Exsplorasi</p>
                </div>
                
            </div>

        </div>
    </div>
</div>

<script>


function filter(b){

    const roomContainer = document.getElementById("room_catalog");
    roomContainer.innerHTML = ' ';

    const search = document.getElementById('search');
    const date = document.getElementById('date');
    const seat = document.getElementById('seat');


    if(b.name == 'search'){
        console.log('search')
        let rooms = JSON.parse(JSON.stringify(room_list));

        rooms = seat_filter(seat, rooms)
        rooms = search_filter(search, rooms)

        room_catalog(rooms, roomContainer)
    }
    else if(b.name == 'date'){

    }
    else if(b.name == 'seat'){
        console.log('seat')
        let rooms = JSON.parse(JSON.stringify(room_list));

        rooms = search_filter(search, rooms)
        console.log(rooms)
        rooms = seat_filter(seat, rooms)

        console.log(rooms)

        room_catalog(rooms, roomContainer)

    }

}

    

function search_filter(b, rooms){
    const searchText = b.value.toLowerCase();

    console.log(searchText)
    if(searchText == ' '){
       
        return rooms
    }
    
    let filteredRoom = rooms.filter((v,i)=>{
        console.log(v.title)
        return v.title.toLowerCase().includes(searchText)
        
    })
   
    console.log(filteredRoom)
    return filteredRoom
    
}



function seat_filter(b,rooms){
    const seat = b.value;

    if(!seat || seat.trim() === 'Total Student:'){
      
        return rooms
    }

    let filteredRoom = []

    if (seat == '1'){
        filteredRoom = rooms.filter(v => v.min_seat == 1) 
    }else if (seat == '2'){
       filteredRoom = rooms.filter(v => v.min_seat == 2)  
    }else if (seat == '3'){
        filteredRoom = rooms.filter(v => v.min_seat >= 3 && v.min_seat <= 5)
    }else if (seat == '6'){
        filteredRoom = rooms.filter(v => v.min_seat >= 6 && v.min_seat <= 10)
    } else if (seat == '10'){
        filteredRoom = rooms.filter(v => v.min_seat > 10)
    }

    if (seat == 'all'){
        filteredRoom = rooms
    }

    return filteredRoom
}



</script>