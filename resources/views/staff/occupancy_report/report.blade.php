<x-staff-app-layout>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-matrix"></script>

    <div class="h-full w-full flex flex-row gap-16 p-[20px]">
        <div class="w-[50%]"> 
            <canvas id="hourly_by_day" aria-label="Occupancy count in hour by day" role="img"></canvas>
            <p id='hour_error'></p>
        </div>

        <div class="w-[50%]"> 
            <canvas id="heatmapChart" aria-label="Occupancy count in hour by day HeatMap" role="img"></canvas>
        </div>
       
       
    </div>
    



    <script>

            @if ($hour_error)

            document.getElementById('hour_error').innerHTML = '{{$hour_error}}';
            
            @else

            const hours = @json($hours);
            const counts = @json($counts);

            <script src="{{url('js/graphic.js')}}"></script>

            @endif


    </script>
  
</x-staff-app-layout>

