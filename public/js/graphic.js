

const ctx = document.getElementById('hourly_by_day').getContext('2d')


 new Chart(ctx, {
    type: 'bar',
    data: {
        labels: hours,
        datasets: [{
            label: 'Hourly Count of People',
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


