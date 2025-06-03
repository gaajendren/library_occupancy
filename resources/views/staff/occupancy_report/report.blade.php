<x-staff-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-matrix"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <style>
        .datepicker-footer{
            background-color: white;
            border: none;
        }
        .today-btn{
            padding: 1rem !important;
            border-radius: 0.5rem !important; 
            background-color: rgb(99 102 241 / var(--tw-text-opacity, 1)) !important;
            
            color: white !important;
            font-size: medium;
            font-weight: bold; 
        }
        .today-btn:hover {
            background-color: rgb(29 78 216 / var(--tw-text-opacity, 1)) !important;
        }

        .clear-btn{
            padding: 1rem !important;
            border-radius: 0.5rem !important; 
            font-size: medium;
            font-weight: bold; 
        }

        .clear-btn:hover {
            background-color: rgb(243 244 246 / var(--tw-text-opacity, 1)) !important;
        }
    
        :root {
            --primary: #4f46e5;
            --secondary: #818cf8;
            --accent: #ec4899;
            --dark: #1e293b;
            --light: #f1f5f9;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }
        
        body {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            font-family: 'Inter', sans-serif;
        }
        
        .dashboard-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .card{
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }
        
        .stat-card {
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
        }
        
        .stat-card.room::before {
            background: linear-gradient(to bottom, #10b981, #059669);
        }
        
        .stat-card.student::before {
            background: linear-gradient(to bottom, #ef4444, #b91c1c);
        }
        
        .stat-card.reservation::before {
            background: linear-gradient(to bottom, #f59e0b, #d97706);
        }
        
        .filter-section {
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            backdrop-filter: blur(10px);
            border: 1px solid #e2e8f0;
        }
        
        .btn-primary {
            cursor: pointer;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.2);
        }
        
        .btn-secondary {
            cursor: pointer;
            background: white;
            color: var(--dark);
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: #f1f5f9;
            transform: translateY(-2px);
        }
        
        .chart-container {
            position: relative;
            height: 400px;
        }
        
        .chart-title {
            color: var(--dark);
            font-weight: 700;
            font-size: 1.1rem;
            padding: 16px 24px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .title{
           color: var(--dark);
            font-weight: 700;
            font-size: 1.1rem;
        }
        
        .datepicker-footer {
            background-color: white;
            border: none;
        }
        
        .today-btn {
            cursor: pointer;
            padding: 1rem !important;
            border-radius: 0.5rem !important; 
            background-color: var(--primary) !important;
            color: white !important;
            font-size: medium;
            font-weight: bold; 
        }
        
        .today-btn:hover {
            background-color: #3730a3 !important;
        }
        
        .clear-btn {
            padding: 1rem !important;
            border-radius: 0.5rem !important; 
            font-size: medium;
            font-weight: bold; 
        }
        
        .clear-btn:hover {
            background-color: #f1f5f9 !important;
        }
        
        .grid-layout {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 24px;
        }
        
        .peak-hour-card {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
            border-radius: 16px;
            overflow: hidden;
        }
        
        .peak-hour-card .chart-title {
            background: rgba(255, 255, 255, 0.08);
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .metric-badge {
            background: rgba(79, 70, 229, 0.1);
            color: var(--primary);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
    </style>

    <div class="h-full w-full flex items-start justify-center contains px-10">
      <div class="w-full h-full  max-w-[1800px] p-4 md:p-6"> 

        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Library Dashboard</h1>
                <p class="text-slate-600 mt-2">Analytics and occupancy statistics</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stat-card room dashboard-card p-6 flex flex-col">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Total Room Type</p>
                        <h3 class="text-3xl font-bold text-slate-800 mt-2">{{$roomCount}}</h3>
                    </div>
                    <div class="p-3 bg-indigo-100 rounded-lg">
                        <i class="fas fa-door-open text-indigo-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card student dashboard-card p-6 flex flex-col">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Total Students</p>
                        <h3 class="text-3xl font-bold text-slate-800 mt-2">{{$userCount}}</h3>
                    </div>
                    <div class="p-3 bg-red-100 rounded-lg">
                        <i class="fas fa-users text-red-600 text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="stat-card reservation dashboard-card p-6 flex flex-col">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-500 text-sm font-medium">Total Reservations</p>
                        <h3 class="text-3xl font-bold text-slate-800 mt-2">{{$totalReservation}}</h3>
                    </div>
                    <div class="p-3 bg-amber-100 rounded-lg">
                        <i class="fas fa-calendar-check text-amber-600 text-xl"></i>
                    </div>
                </div>
                
            </div>
        </div>



        <div class="filter-section card p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-4 md:items-center">
                <div class="flex w-full justify-start gap-5  items-center">
                  <div class="form-group group ">
                    <div class='p-2.5 py-0.5 flex flex-row w-fit items-center rounded-lg justify-center border border-1 border-gray-300'>
                      <p class="font-bold text-sm  w-1/2 text-gray-800">Date Period</p>
                        <select oninput="date_range(event)" id='date_range' class="bg-white border border-none ml-2 focus:ring-0  text-gray-800 text-sm rounded-lg  flex-1  dark:bg-gray-700 dark:text-white ">
                            <option value="not" class="text-gray-800 selected" selected disabled>Select Range</option>
                            <option value="date" class="text-gray-800 ">By Date</option>
                            <option value="month" class="text-gray-800 ">By Month</option>
                            <option value="year" class="text-gray-800">By Year </option>
                        </select>
                    </div>
                  </div>
                  
                  <div id='dateContainer'>
                    <div id='date' class="hidden relative max-w-sm">
                      <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                      </div>
                      <input datepicker datepicker-buttons datepicker-autoselect-today datepicker-autohide id="default-datepicker" autocomplete="off" type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                    </div>

                    <div id='month' class="hidden relative max-w-sm">
                      <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                      </div>
                      <input id="monthpicker" autocomplete="off" type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select month">
                    </div>

                    <div id='year' class="hidden relative max-w-sm">
                      <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                          <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                      </div>
                      <input id="yearpicker" autocomplete="off" type="text" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select year">
                    </div>
                  </div>

                      
                  <div class="form-group group ">
                    <div class='p-2.5 py-0.5 flex flex-row w-fit items-center rounded-lg justify-center border border-1 border-gray-300'>
                        <p class="font-bold text-sm  w-1/2 text-gray-800">Chart Type</p>
                        <select id='chart_type' class="bg-white border border-none ml-2 focus:ring-0  text-gray-800 text-sm rounded-lg  flex-1  dark:bg-gray-700 dark:text-white ">
                            <option value="bar" class="text-gray-800 selected" selected disabled >Select Chart</option>
                            <option value="bar" class="text-gray-800 " >Bar Chart</option>
                            <option value="line" class="text-gray-800 ">Line Chart</option> 
                        </select>
                    </div>
                  </div>
              
                  <div class="form-group group flex ">
                    <button type="button" class="text-white bg-gray-700 hover:bg-gray-900 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-1.5   dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-hidden dark:focus:ring-blue-800 cursor-pointer" onclick='set_date(event)'><i class="fa-solid fa-filter mr-2"></i>Apply</button>
                  </div>

                  <div class="flex ml-auto justify-self-end">
                    <button type="button" class="btn-primary px-6 py-2.5 flex items-center" onclick='downloadPDF()'><i class="fas fa-download mr-2"></i>Pdf</button>
                  </div>  
                 
                </div>
            </div>
        </div>
      

          

          <div class="grid grid-cols-1 md:grid-cols-3  gap-6 mb-8">
            <!-- Occupancy Chart -->
            <div class="card col-span-2">
                <div class="chart-title flex items-center justify-between">
                    <div>
                        <span>Occupancy Throughout the Day</span>
                        <span class="metric-badge ml-2">Today</span>
                    </div>
                    <div class="text-sm text-slate-500">
                        <i class="far fa-clock mr-1"></i> Updated just now
                    </div>
                </div>
                <div class="p-4">
                    <div class="chart-container">
                      <div id='hour_error'class="hidden p-3 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-red-100 border border-red-400 rounded-lg font-regular text-red-700 text-lg  "></div>
                      <canvas id="hourly_by_day"></canvas>
                    </div>
                </div>
            </div>

            <!-- Peak Hour Overall Chart -->
           <div class="peak-hour-card card">
              <div class="chart-title">
                  <span>Peak Hour Overall</span>
              </div>
              <div class="p-4">
                  <div class="h-72">
                      <canvas id="peakHourOverallChart"></canvas>
                  </div>
                  <div class="mt-4 text-center text-indigo-200">
                      <p id="peak_hour" class="text-xl font-bold">3:00 PM - 5:00 PM</p>
                      <p class="mt-1">Peak hours with highest occupancy</p>
                  </div>
              </div>
          </div> 
          </div>
      
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Utilization Chart -->
            <div class="card">
                <div class="chart-title flex items-center justify-between">
                     <span class="title">Utilization</span>
                    <div class="text-sm text-slate-500">
                        <select id="p_type" class="bg-gray-100 p-2 border border-gray-300 focus:ring-0 text-gray-800 text-xs rounded min-w-20">
                            <option value="hour"  selected>Hour</option> 
                            <option value="day">Day</option> 
                            <option value="month">Month</option>
                        </select>
                    </div>
                </div>
                <div class="p-4">
                    <div class="h-72 relative">
                        <div id='utilization_error' class="hidden p-3 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-red-100 border border-red-400 rounded-lg font-regular text-red-700 text-lg  "></div>
                        <canvas id="utilization" role="img"></canvas>
                    </div>
                </div>
            </div>


            <div class="card col-span-2">
                <div class="chart-title">
                    Peak Reservation Count
                </div>
                <div class="p-4">
                    <div class="h-[300px] ">
                        <canvas id="peak_graph" role="img"></canvas>
                    </div>
                </div>
            </div>

            
                      
          
        </div>
      
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
      <script src="
      https://cdn.jsdelivr.net/npm/html2canvas-pro@1.5.8/dist/html2canvas-pro.min.js
      "></script>

      <script>
       let chart;

      </script>
                @if ($hour_error ?? false)

            <script> 

            document.getElementById('hour_error').innerHTML = '{{$hour_error}}'; 
            document.getElementById('hour_error').classList.remove('hidden')
            </script>

        @else
        <script>


        const hours = @json($hours);
        const counts = @json($counts);




        document.getElementById('hour_error').classList.add('hidden')
        </script>
        <script src="{{url('js/graphic.js')}}"></script>

    @endif



    </div>



    <script>

    function destroyAllCharts() {
       
        Object.keys(Chart.instances).forEach((chartId) => {
            Chart.instances[chartId].destroy();
        });
    }


            
         indigo = {
                        light: '#818cf8',
                        main: '#4f46e5',
                        dark: '#3730a3'
                    };
                    
             amber = {
                light: '#fcd34d',
                main: '#f59e0b',
                dark: '#d97706'
            };

             emerald = {
                light: '#6ee7b7',
                main: '#10b981',
                dark: '#059669'
            };

             rose = {
                light: '#fda4af',
                main: '#f43f5e',
                dark: '#e11d48'
            };


      const date = document.getElementById('date')
     
      const month = document.getElementById('month')
      const year = document.getElementById('year')

      function set_date(){
        

         const dateContainer = document.getElementById('dateContainer')
         let range = document.getElementById('date_range').value
         let queryParams = ''
       
        if (range === 'not') {     
         
        } else if (range === 'date') {
          let date_value = document.getElementById('default-datepicker').value;
          queryParams = `?range=date&value=${date_value}`;

          get_chart_data(queryParams , 'Hourly Count of People')

        } else if (range === 'month') {
          let month_value = document.getElementById('monthpicker').value;
          queryParams = `?range=month&value=${encodeURIComponent(month_value)}`;

          get_chart_data(queryParams , 'Montly Count of People')

        } else if (range === 'year') {
          let year_value = document.getElementById('yearpicker').value;
          queryParams = `?range=year&value=${encodeURIComponent(year_value)}`;
          console.log(queryParams);
          get_chart_data(queryParams , 'Yearly Count of People')

        } 

      }


      async function get_chart_data(queryParams , label){

        const chart_type = document.getElementById('chart_type').value;

        try {
          const response = await axios.get(`/staff/api/chart${queryParams}`);
          const [x, counts] = response.data;

         
         

          if(x.length == 0 || counts.length == 0){
            document.getElementById('hour_error').innerHTML = 'No Data Available'; 
            document.getElementById('hour_error').classList.remove('hidden')
            destroyAllCharts()
            get_data('hour')
            return
          }

          console.log("Hours:", x);
          console.log("Counts:", counts);
          document.getElementById('hour_error').classList.add('hidden')

          graph(x,counts, label, chart_type)
        
        } catch (error) {
          console.error(error);
        }

      }
 
        function date_range(e){
          

          const dateContainer = document.getElementById('dateContainer')
          let range =  e.target.value 

          if(range == 'date'){
           
        
            month.classList.add('hidden');
            year.classList.add('hidden');
            date.classList.remove('hidden');

          }else if(range == 'month'){

                date.classList.add('hidden');
               
                year.classList.add('hidden');
                month.classList.remove('hidden');

           }else if(range == 'year'){

                date.classList.add('hidden');
                
                month.classList.add('hidden');
                year.classList.remove('hidden');
            }
        }
   
        const monthPicker = document.querySelector('#monthpicker');
        const yearPicker = document.querySelector('#yearpicker');
        const datePicker = document.querySelector('#default-datepicker');
       
        const monthpicker =  new Datepicker(monthPicker, {
            autohide: true,
            format: 'MM',
            pickLevel: 1,
            startView: 1,
        });

        const yearpicker =  new Datepicker(yearPicker, {
            autohide: true,
            format: 'yyyy',
            pickLevel: 2,
            startView: 2,
        });

      
        // monthPicker.addEventListener('changeDate', (event) => {
            
        // datepicker.setDate('05/31/2024');
        // console.log( console.log(datepicker.getDate()));
       
        // });

   
      let utilize_chart = null;
      let peak_chart = null;

      
      
      function graph(x,counts, label,chart_type ){

        destroyAllCharts()
        get_data('hour')

        const ctx = document.getElementById('hourly_by_day').getContext('2d')

        new Chart(ctx, {
          type: chart_type,
          data: {
              labels: x,
              datasets: [{
                  label: 'Occupancy',
                  data: counts,
                  borderColor: indigo.main,
                  backgroundColor: 'rgba(79, 70, 229, 0.1)',
                  borderWidth: 3,
                  tension: 0.3,
                  fill: true,
                  pointBackgroundColor: 'white',
                  pointBorderWidth: 2,
                  pointRadius: 5
                
              }
          ]
          },
           options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                  legend: {
                      display: false
                  },
                  tooltip: {
                      backgroundColor: 'white',
                      titleColor: indigo.dark,
                      bodyColor: '#334155',
                      borderColor: '#e2e8f0',
                      borderWidth: 1,
                      padding: 12,
                      boxPadding: 6,
                      usePointStyle: true,
                      callbacks: {
                          label: function(context) {
                              return `Occupancy: ${context.parsed.y} people`;
                          }
                      }
                  }
              },
              scales: {
                  x: {
                     title: {
                        display: true,
                        text: 'Hour of the Day'
                    },
                      grid: {
                          display: false
                      },
                      ticks: {
                          color: '#64748b'
                      }
                  },
                  y: {
                      beginAtZero: true,
                        title: {
                        display: true,
                        text: 'Average Occupancy of People'
                    },
                      grid: {
                          color: 'rgba(226, 232, 240, 0.5)'
                      },
                      ticks: {
                          color: '#64748b',
                          callback: function(value) {
                              return value + ' people';
                          }
                      }
                  }
              }
          }
        });

      }


      document.addEventListener('DOMContentLoaded', ()=>{    
         get_data('hour')
         peakHourOverallChart();
      })

      document.getElementById('p_type').addEventListener('input', ()=>{
         let type_choice = document.getElementById('p_type').value;
         get_data(type_choice)
      });


      async function get_data(type){          
        const res = await axios.get(`/staff/utilize/${type}`);

        if(res){
          console.log(res)
          utilize_graph(res.data, type)
        }
      }


      function utilize_graph(data, type) {

          if (utilize_chart !== null) {
            utilize_chart.destroy();
            utilize_chart = null;
          }
          const ctx = document.getElementById('utilization').getContext('2d');

          const labels = ['Utilized', 'Unutilized'];
          let utilizationData
          
          if(type == 'month'){
             utilizationData = data[0].monthly_utilization;

            const totalUtilization = utilizationData.reduce((sum, item) => sum + item.utilization_percent, 0);

            const averageUtilization = utilizationData.length > 0 ? totalUtilization / utilizationData.length : 0;

            utilizationData = averageUtilization / 100;

            console.log(utilizationData)
            
          }else{
             utilizationData = data.map(item => item.utilization_percent/ 100);
          }

          const backgroundColors = [
              '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
              '#9966FF', '#FF9F40', '#C9CBCF', '#FF6384'
          ];

          utilize_chart = new Chart(ctx, {
              type: 'doughnut',
              data: {
                  labels: ['Utilized', 'Unutilized'],
                  datasets: [{
                      data: [utilizationData, 1-utilizationData],
                      backgroundColor: [emerald.main, '#e2e8f0'],
                      borderWidth: 0,
                      spacing: 2
                  }]
              },
              options: {
                   responsive: true,
                   maintainAspectRatio: false,
                   cutout: '70%',
                   plugins: {
                      legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        },
                      tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.label}: ${context.parsed}%`;
                                }
                            }
                      }
                  }
              }
          });


            

          draw_peak_chart(data, type)
      }


      function draw_peak_chart(data, type){
        const peak_ctx = document.getElementById('peak_graph').getContext('2d');

        if ( peak_chart !== null) {
              peak_chart.destroy();
              peak_chart = null;
          }

        let labels = []
        let dataset =[]

        const backgroundColors = [
              '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
              '#9966FF', '#FF9F40', '#C9CBCF', '#FF6384'
          ];

        if(type == 'day'){
           const peak_days = data[0]['top_peak_days'];

           labels = peak_days.map((peak_day)=>{
               return peak_day['date'];
           });

          dataset = peak_days.map((peak_day)=>{
               return peak_day['reservations'];
           }); 

        }else if(type == 'month'){
          const peak_days = data[0]['top_peak_months'];

          labels = peak_days.map((peak_day)=>{
               return peak_day['month'];
           });

          dataset = peak_days.map((peak_day)=>{
               return peak_day['reservations'];
           }); 

        }else if(type == 'hour'){
          const peak_days = data[0]['peak_time_counts'];

           labels = Object.keys(peak_days).map(hour => formatHour(hour));
           dataset = Object.values(peak_days);

        }
         peak_chart = new Chart(peak_ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                           
                            data: dataset,
                            backgroundColor: rose.light,
                            borderColor: rose.dark,
                            borderWidth: 2
                        },
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                           display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(226, 232, 240, 0.5)'
                            },
                            ticks: {
                                callback: function(value) {
                                     if (value % 1 === 0) {
                                        return value + ' reservation';
                                    }
                                }
                            }
                        }
                    }
                }
            });

        
            
          
    
      }


      function formatHour(hour24) {
        const hour = parseInt(hour24);
        const suffix = hour >= 12 ? 'PM' : 'AM';
        const hour12 = hour % 12 === 0 ? 12 : hour % 12;
        return `${hour12}:00 ${suffix}`;
    }


    async function downloadPDF() {
    const { jsPDF } = window.jspdf;

    const elements = [
        document.getElementById("hourly_by_day"),
        document.getElementById("utilization"),
        document.getElementById("peak_graph")
    ];

    const pdf = new jsPDF({
        orientation: 'portrait',
        unit: 'mm',
        format: 'a4'
    });

    const pageWidth = pdf.internal.pageSize.getWidth();
    const pageHeight = pdf.internal.pageSize.getHeight();

    for (let i = 0; i < elements.length; i++) {
        const canvas = await html2canvas(elements[i], {
            scale: 2,
            useCORS: true
        });

        const imgData = canvas.toDataURL("image/png");
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pageWidth - 20; 
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

        if (i > 0) pdf.addPage();

        pdf.addImage(imgData, "PNG", 10, 10, pdfWidth, pdfHeight);
    }

    pdf.save("report.pdf");
}


    function convertTo12Hour(time24, bl) {
        const [hour, minute] = time24.split(':');
        let h = parseInt(hour);
        if(bl == 'add'){
           h = h + 1
        }
        const suffix = h >= 12 ? 'PM' : 'AM';
        const hour12 = h % 12 === 0 ? 12 : h % 12;
        return `${hour12} ${suffix}`;
    }


    function peakHourOverallChart(){
        axios.get('/peak_occupancy').then((res)=>{

            const formattedTimes = [];

            res.data.hours.forEach(hour => {
                formattedTimes.push(convertTo12Hour(hour, 'no_add'));
                
            });

            document.getElementById('peak_hour').textContent = convertTo12Hour(res.data.peak_hours.toString(), 'no_add') + ' - ' + convertTo12Hour(res.data.peak_hours.toString(), 'add')

            const peakHourOverallCtx = document.getElementById('peakHourOverallChart').getContext('2d');
            new Chart(peakHourOverallCtx, {
                type: 'radar',
                data: {
                    labels: formattedTimes,
                    datasets: [{
                        label: 'Average Occupancy',
                        data: res.data.averages,
                        backgroundColor: 'rgba(99, 102, 241, 0.2)',
                        borderColor: '#6366f1',
                        borderWidth: 2,
                        pointBackgroundColor: 'white',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            angleLines: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            pointLabels: {
                                color: '#c7d2fe',
                                font: {
                                    size: 11
                                }
                            },
                            ticks: {
                                display: false,
                                stepSize: 20
                            },
                          
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            console.log(res.data)

        }).catch((e)=> console.log(e))
    }

   
    

</script>


  
</x-staff-app-layout>

