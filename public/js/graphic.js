

  let indigo = {
                light: '#818cf8',
                main: '#4f46e5',
                dark: '#3730a3'
            };
            
    let amber = {
        light: '#fcd34d',
        main: '#f59e0b',
        dark: '#d97706'
    };

    let emerald = {
        light: '#6ee7b7',
        main: '#10b981',
        dark: '#059669'
    };

    let rose = {
        light: '#fda4af',
        main: '#f43f5e',
        dark: '#e11d48'
    };

const ctx = document.getElementById('hourly_by_day').getContext('2d')


if(chart){
    chart.destroy(); 
  }

  chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: hours,
        datasets: [{
            label: 'Hourly Count of People',
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
                title: {
                        display: true,
                        text: 'Average Occupancy of People'
                    },
                beginAtZero: true,
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


