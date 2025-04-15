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
    </style>

    <div class="h-full w-full flex items-start justify-center contains">
      <div class="w-full h-full  max-w-[1900px]"> 

          <div class="p-4 mt-10 w-full flex flex-row flex-wrap gap-10">
            <div class="rounded-lg bg-white shadow-md min-w-[100px] overflow-hidden ">
              <div class='border-l-[3px] border-l-teal-400 flex flex-col justify-center items-start p-5'>
                  <p class="text-sm text-gray-600 font-regular">Total Room Type</p>
                  <h1 class="text-gray-900 text-lg text-bold">{{$roomCount}}</h1>
              </div>
            </div>
            <div class="rounded-lg bg-white shadow-md min-w-[100px] overflow-hidden ">
              <div class='border-l-[3px] border-l-teal-400 flex flex-col justify-center items-start p-5'>
                  <p class="text-sm text-gray-600 font-regular">Total Student</p>
                  <h1 class="text-gray-900 text-lg text-bold">{{$userCount}}</h1>
              </div>
            </div>
            <div class="rounded-lg bg-white shadow-md min-w-[100px] overflow-hidden ">
              <div class='border-l-[3px] border-l-teal-400 flex flex-col justify-center items-start p-5'>
                  <p class="text-sm text-gray-600 font-regular">Total Reservation</p>
                  <h1 class="text-gray-900 text-lg text-bold">{{$totalReservation}}</h1>
              </div>
            </div>
          </div>

        

          <div class="p-4 rounded-lg mx-4 shadow-sm bg-white h-fit my-4 "> 
            <div class="flex w-full justify-start gap-5  items-center">   
              <div class="form-group group ">
                <div class='p-2.5 py-0.5 flex flex-row w-fit items-center rounded-lg justify-center border border-1 border-gray-300'>
                    <p class="font-bold text-sm  w-1/2 text-gray-800">Date Period</p>
                    <select  oninput="date_range(event)" id='date_range' class="bg-white border border-none ml-2 focus:ring-0  text-gray-800 text-sm rounded-lg  flex-1  dark:bg-gray-700 dark:text-white ">
                        <option value="not" class="text-gray-800 selected" selected disabled >Select Range</option>
                        <option value="date" class="text-gray-800 " >By Date</option>
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
                <button type="button" class="text-white bg-gray-700 hover:bg-gray-900 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-1.5   dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" onclick='set_date(event)'><i class="fa-solid fa-filter mr-2"></i>Apply</button>
              </div>
            </div>
          </div>
      

          <div class="w-full flex flex-row">
            <div class="mx-4 rounded-lg border border-gray-300 shadow-sm bg-white my-4 flex flex-wrap flex-col  w-full h-fit">
              <div class="self-end rounded-t-lg p-2 px-4 text-gray-600 content-end w-full bg-gray-50  border-b border-gray-300">Graph of library occupancy</div>
              <div class="w-full relative"> 
                <div id='hour_error' class="hidden p-3 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-red-100 border border-red-400 rounded-lg font-regular text-red-700 text-lg  ">
                 
                </div>
                <canvas id="hourly_by_day" class=" h-[400px] mx-auto" aria-label="Occupancy count in hour by day" role="img"></canvas>
              
              </div>   
            </div>
          </div>

          <div class="w-full flex flex-row">
            <div class="mx-4 rounded-lg border border-gray-300 shadow-sm bg-white my-4 flex flex-wrap flex-col  h-fit w-1/3">
              <div class="self-end rounded-t-lg p-2 px-4 text-gray-600 content-end w-full bg-gray-50  border-b border-gray-300">Utilization</div>
              <div class="w-full relative "> 
                <select id="p_type"  class="bg-gray-100 p-2 m-2 border border-none  focus:ring-0  text-gray-800 text-sm rounded-lg block w-fit  dark:bg-gray-700 dark:text-white ml-auto">
                  <option class="text-gray-800" disabled>Slot Type</option>
                  <option value="hour" class="text-gray-800" selected>Hour</option> 
                  <option value="day" class="text-gray-800">Day</option> 
                  <option value="month" class="text-gray-800">Month</option>
                </select>

                <div id='utilization_error' class="hidden p-3 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-red-100 border border-red-400 rounded-lg font-regular text-red-700 text-lg  ">
                 
                </div>
                <canvas id="utilization" class=" h-[300px] mx-auto" role="img"></canvas>
              
              </div>   
            </div>
          </div>


      </div>
      <script>
       let chart;
      
      </script>
                @if ($hour_error ?? false )

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

    </script>


    <script>

      let utilize_chart = null;

      

      function graph(x,counts, label, chart_type){

        destroyAllCharts()

        const ctx = document.getElementById('hourly_by_day').getContext('2d')

       

        new Chart(ctx, {
          type: chart_type,
          data: {
              labels: x,
              datasets: [{
                  label: label,
                  data: counts,
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
                          text: 'Hour of the Day'
                      }
                  },
                  y: {
                      title: {
                          display: true,
                          text: 'Count of People'
                      },
                      beginAtZero: true
                  }
              },
              plugins: {
                  legend: {
                      display: true,
                      onClick: null 
                  }
              }
          }
        })

      }


      document.addEventListener('DOMContentLoaded', ()=>{    
         get_data('hour')
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


          const labels = ['Available', 'Inavailable']
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
              type: 'pie',
              data: {
                  labels: labels,
                  datasets: [{
                      label: 'Utilization Percent',
                      data: [utilizationData, 1-utilizationData],
                      backgroundColor: backgroundColors,
                     
                  }]
              },
              options: {
                  responsive: true,
                  plugins: {
                      legend: {
                          position: 'right',
                      },
                      tooltip: {
                          callbacks: {
                              label: function(context) {
                                  return context.label+ ': ' + context.parsed*100 + '%';
                              }
                          }
                      }
                  }
              }
          });
      }

    </script>


  
</x-staff-app-layout>

