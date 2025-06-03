<x-staff-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-matrix"></script>
  <style>
    @keyframes pulseWave {
      0% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(249, 128, 128, 0.4);
      }

      70% {
        transform: scale(1.1);
        box-shadow: 0 0 0 8px rgba(249, 128, 128, 0);
      }

      100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(249, 128, 128, 0);
      }
    }

    .animate-pulse-wave {
      animation: pulseWave 2s infinite;
      position: relative;
      display: inline-flex;
      align-items: center;
      justify-content: center;

    }
  </style>

  <div class="min-h-screen bg-gray-50 p-8">
    <!-- Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-800">Library Dashboard</h1>
      <p class="text-gray-500">Real-time occupancy and reservations monitoring</p>
    </div>

    <!-- Bento Grid Container -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

      <!-- Current Occupancy Card -->
      <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-500 text-sm">Current Occupancy</p>
            <p class="text-4xl font-bolder text-black mt-2"><button
                class="px-2.5 py-1 bg-teal-100 animate-pulse-wave rounded-full">142</button></p>
          </div>
          <div class="bg-blue-100 p-3 rounded-lg">
            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </div>
        </div>
        {{-- <div class="mt-4 text-sm text-green-500 flex items-center">
          <span class="mr-2">▲ 12%</span> vs previous hour
        </div> --}}
      </div>

      <!-- Active Reservations -->
      <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-500 text-sm">Active Reservations</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{$countFromTodayOnwards}}</p>
          </div>
          <div class="bg-purple-100 p-3 rounded-lg">
            <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
          </div>
        </div>
        <div class="mt-4 text-sm text-gray-500">
          {{$countTodayOnly}} reservation for today
        </div>
      </div>

      <!-- Room Utilization -->
      <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-teal-500">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-500 text-sm">Room Utilization</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($utilization, 0) }}%</p>
          </div>
          <div class="bg-teal-100 p-3 rounded-lg">
            <svg class="w-8 h-8 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
          </div>
        </div>
        <div class="mt-4">
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-teal-500 h-2 rounded-full  w-[{{ number_format($utilization, 0) }}%]"></div>
          </div>
        </div>
      </div>

      <!-- Peak Hours -->
      <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-orange-500">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-gray-500 text-sm">Peak Hours</p>
            <p class="text-3xl font-bold text-gray-800 mt-2">2-4 PM</p>
          </div>
          <div class="bg-orange-100 p-3 rounded-lg">
            <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
        </div>
        <div class="mt-4 text-sm text-gray-500">
          58% of daily traffic
        </div>
      </div>
    </div>

    <!-- Lower Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

      <!-- Live Occupancy Chart -->
      <div class="bg-white p-6 rounded-xl shadow-sm">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold">Live Occupancy Trend</h3>
          <div class="text-sm text-gray-500">Last 6 hours</div>
        </div>
        <div class="h-full">
          <!-- Add your chart here (Chart.js or similar) -->
          <canvas class="bg-white rounded-lg min-w-full h-full flex items-center justify-center text-gray-400"
            id="chat_container">
            Chart Area
          </canvas>
        </div>
      </div>

      <!-- Recent Reservations -->
      <div class="bg-white p-6 rounded-xl shadow-sm">
        <h3 class="text-lg font-semibold mb-4">Recent Reservations</h3>

        <div class="space-y-4" id="reservation_container">

        </div>
      </div>
    </div>
  </div>


  <script>

    document.addEventListener('DOMContentLoaded', () => {
      update_recent_reservation()
      live_occupancy()
      setInterval(update_recent_reservation, 60000);
      setInterval(live_occupancy, 60000);
    })

    function update_recent_reservation() {

      document.getElementById('reservation_container').innerHTML = '';

      axios.get('/staff/recent_reservation').then((response) => {

        response.data.forEach(element => {

          document.getElementById('reservation_container').innerHTML += `

              <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg">
                <div class="flex flex-col items-center justify-center">
                  <p class="font-medium self-start">${element.get_room.name}</p>
                  <p class="text-sm text-gray-500">${element.get_student.name}  •  ${new Date(element.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}   </p>
                </div>
               <div class="flex flex-row items-center justify-center gap-3">
                <p class=" px-2 py-1 text-sm bg-green-100 text-green-800 rounded-full">${element.ticket_no}</p>
                <p>${getTimeSlotsHtml(element.time)}</p>
                <span class="">${getStatusHtml(element.status)}</span>
               </div>
              </div>

            `;

        });



      }).catch((error) => {
        console.log(error);
      })

    }


    function getTimeSlotsHtml(time) {
      if (!time) return '<span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-900 rounded-md ">Full</span>';

      try {
        const times = JSON.parse(time);
        const decodedTimes = typeof times === 'string' ? JSON.parse(times) : times;
        const timeArray = Array.isArray(decodedTimes) ? decodedTimes : ['Full'];

        return timeArray.map(t => `
                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-900 rounded-md ">
                        ${t}
                    </span>
                `).join('');
      } catch (e) {
        return '<span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-900 rounded-md ">Full</span>';
      }
    }


    function getStatusHtml(status) {
      const statusConfig = {
        'pending': 'bg-yellow-100 text-yellow-900 border-yellow-300',
        'check_out': 'bg-purple-100 text-purple-900 border-purple-300',
        'complete': 'bg-green-100 text-green-900 border-green-300',
        'cancelled': 'bg-red-100 text-red-900 border-red-300',
        'rejected': 'bg-gray-100 text-gray-900 border-gray-300'
      };

      const classes = statusConfig[status] || 'bg-gray-100';

      return `
                <span class="px-3 py-1 text-xs font-medium rounded-full border ${classes}">
                    ${status.charAt(0).toUpperCase() + status.slice(1)}
                </span>
            `;

    }


    function destroyAllCharts() {

      Object.keys(Chart.instances).forEach((chartId) => {
        Chart.instances[chartId].destroy();
      });
    }



    function live_occupancy() {

      axios.get('/live_occupancy').then((res) => {

        destroyAllCharts()
        const ctx = document.getElementById('chat_container').getContext('2d')

        new Chart(ctx, {
          type: 'line',
          data: {
            labels: res.data.hours,
            datasets: [{
              
              data: res.data.averages,
              borderColor: 'rgba(75, 192, 192, 1)',
              backgroundColor: 'rgba(75, 192, 192, 0.2)',
              fill: true,
              borderWidth: 1

            }
            ]
          },
          options: {
            responsive: true,
            scales: {
              x: {
                title: {
                  display: true,
                  text: 'Hour'
                }
              },
              y: {
                title: {
                  display: true,
                  text: 'Occupancy Average'
                },
                beginAtZero: true
              }
            },
            plugins: {
              legend: {
                display: false,
                onClick: null
              }
            }
          }
        })


      }).catch(e => console.log(e))

    }
  </script>

</x-staff-app-layout>