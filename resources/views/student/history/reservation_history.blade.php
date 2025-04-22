<x-app-layout>

    @include('student.partials.nav_bar')



    <div class='dark bg-[#0c0f16] pt-[98px] w-full min-h-screen items-center flex flex-col'>
        @include('staff.message.error')


        <div class="relative rounded-xl shadow-lg w-fit bg-white bg-opacity-60">
            <div class="flex flex-row justify-center items-center relative">
                <button id="upcoming" class="btn border-none p-2 px-4">Upcoming</button>
                <button class="btn border-none p-2 px-4">History</button>
            </div>
        </div>



        <div
            class="mt-8 rounded-xl shadow-md py-2 px-3 flex flex-row justify-center items-center bg-white gap-2 w-[50%] max-w-[500px]">
            <i class="fa-brands fa-searchengin rounded-2xl"></i>
            <input id="search" type="search"
                class="border-none flex-1 rounded-xl p-1 text-sm focus:outline-hidden focus:ring-0"
                placeholder="Search..." name="search" id="">
        </div>

        <br>
        <br>

        <div class="w-full flex flex-col justify-center items-center" id="reservations-container"></div>

        <br>
        <br>
    </div>


    <div class="absolute top-[35%] left-[80%]  rounded-full blur-[80px] opacity-40 bg-teal-300 w-[10%] h-[60px]"></div>

    <script>

        let currentPage;

        document.getElementById('search').addEventListener('change', (event) => {
            let text_info = event.target.value;

            axios.get('/student/history/search', {
                params: { text: text_info }
            })
                .then(function (response) {
                    const reservations = response.data;
                    console.log(reservations)
                    makeCard(reservations);
                })
                .catch(function (error) {
                    console.log(error);
                });
        });

        document.addEventListener('click', (event) => {
            if (event.target.matches('#rebook')) {
                const reservationId = event.target.dataset.id;
                window.location.href = `/student/room_detail/${reservationId}`;
            }
        });

        document.querySelectorAll('.btn').forEach((btn) => {
            btn.addEventListener('click', () => {

                if (btn.id == "upcoming") {
                    currentPage = "upcoming"
                    getHistory('upcoming');
                } else {
                    console.log('eiiii')
                    currentPage = "history"
                    getHistory('history');
                }

                document.querySelectorAll('.btn').forEach((b) => {
                    b.classList.remove('rounded-xl', 'shadow-[inset_0_35px_35px_rgba(0,0,0,0.25)]', "bg-white");
                });

                btn.classList.add('rounded-xl', 'shadow-[inset_0_35px_35px_rgba(0,0,0,0.25)]', "bg-white");
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById('upcoming').click();
        });

        async function getHistory(status) {
            try {

                const response = await axios.get('/student/api/history', { params: { type: status } });
                console.log(response.data);

                const reservations = response.data;

                makeCard(reservations);

            } catch (error) {
                console.error("Error fetching reservations:", error);
            }
        }


        function makeCard(reservations) {

            const container = document.getElementById('reservations-container');

            container.innerHTML = '';


            reservations.forEach(reservation => {

                let images = [];
                try {
                    images = Array.isArray(reservation.get_room_type.img)
                        ? reservation.get_room_type.img
                        : JSON.parse(reservation.get_room_type.img || '[]');
                } catch (error) {
                    console.error("Error parsing images:", error);
                }
                const imageSrc = images.length > 0 ? `/storage/room_image/${images[0]}` : '/default-room.jpg';


                let timeSlots = [];
                try {


                    timeSlots = JSON.parse(JSON.parse(reservation.time || '[]'));
                } catch (error) {
                    console.error("Error parsing time:", error);
                }


                const formattedTime = timeSlots.length > 0 ? timeSlots.join(" - ") : "N/A";


                const formattedDate = new Date(reservation.date).toLocaleDateString('en-US', {
                    month: 'short',
                    day: '2-digit',
                    year: 'numeric'
                });


                const statusColors = {
                    'complete': 'text-teal-300',
                    'check-out': 'text-teal-300',
                    'pending': 'text-yellow-300',
                    'check-in': 'text-yellow-500',
                    'cancelled': 'text-red-500',
                    'rejected': 'text-red-500'
                };
                const statusColor = statusColors[reservation.status] || 'text-gray-500';


                const cancelBtnClass = reservation.status !== 'pending' ? 'hidden' : '';


                const rebookBtnClass = (reservation.status !== 'complete' && reservation.status !== 'rejected') ? 'hidden' : '';


                const reservationHTML = `
                <div class="relative my-3 pt-3 rounded-md bg-gray-800 pr-6 shadow-white-xl py-2 px-2 flex flex-row justify-center items-start gap-4 w-[90%] max-w-[700px]">
                    <div class="rounded-xl w-[30%] max-w-[120px] h-full">
                        <img class="w-full h-[100px] object-cover rounded-xl" src="${imageSrc}" alt="">
                    </div>
                    <div class="w-full h-full flex flex-col justify-start gap-1 items-start">
                        <p class="mt-1 text-white text-md font-bold leading-none">${reservation.get_room_type.title}</p>
                        <p class="mt-2 text-white text-sm leading-none">${formattedDate}</p>
                        <p class="mt-2 text-white text-sm leading-none">Time: ${formattedTime}</p>

                        <button onclick="print('${reservation.ticket_no}')" class="absolute w-[83px] top-4 right-[120px] border-2 rounded-md shadow-md border-teal-400 text-teal-300 bg-transparent hover:bg-teal-400 hover:text-white text-sm p-2 ">
                            <i class="fa-solid fa-print fa-sm mr-1"></i>Print
                        </button>

                        <button onclick="cancel(this)" value="${reservation.id}" data-status="${reservation.status}"  class="absolute w-[83px] top-4 right-6 border-2 rounded-md shadow-md border-red-400 text-red-300 bg-transparent hover:bg-red-400 hover:text-white text-sm p-2 ${cancelBtnClass}">
                            <i class="fa-solid fa-ban fa-sm mr-1"></i>Cancel
                        </button>
                        <button id="rebook" data-id="${reservation.get_room_type.id}" class="absolute w-[90px] top-4 right-6 shadow-md rounded-md border-yellow-300 border-2 bg-transparent text-yellow-300 p-2 text-sm hover:bg-yellow-500 hover:text-white ${rebookBtnClass}">
                            <i class="fa-solid fa-arrow-rotate-right fa-sm"></i> Rebook
                        </button>

                        <hr class="h-[1px] w-full bg-gray-200 my-2"></hr>

                        <div class="flex flex-row justify-between w-full">
                            <p class="${statusColor} font-bold">${reservation.status.charAt(0).toUpperCase() + reservation.status.slice(1)}</p>
                         
                        </div>
                    </div>
                </div>
            `;

                container.innerHTML += reservationHTML;
            });
        }

        function print(ticket_no) {
            try {
                window.location.href = `/student/print/${ticket_no}`;

            } catch (error) {
                console.log(error)
            }
        }

        async function cancel(e) {

            const status = e.getAttribute('data-status');

            if(status != 'pending'){return false}

            const ans = confirm('Are u want to cancel the reservation');

            if (ans) {

                const response = await axios.delete(`/student/reservation/delete/${e.value}`);

                if(response.data.success){
                    getHistory(currentPage);
                }
            }

        }

    </script>

</x-app-layout>