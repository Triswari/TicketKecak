document.addEventListener('DOMContentLoaded', function() {
    fetch('/visitor-data')
        .then(response => response.json())
        .then(data => {
            console.log('Data from server:', data);

            const labels = data.map(item => item.nationality);
            const qtyTickets = data.map(item => parseInt(item.total_qty_ticket, 10)); // Pastikan nilai ini adalah angka
            const totalTickets = qtyTickets.reduce((acc, curr) => acc + curr, 0);

            console.log('Labels:', labels);
            console.log('Qty Tickets:', qtyTickets);
            console.log('Total Tickets:', totalTickets);

            const ctx = document.getElementById('visitorChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Qty Ticket',
                        data: qtyTickets,
                        backgroundColor: labels.map(() => {
                            const r = Math.floor(Math.random() * 100); // nilai merah antara 0 dan 99
                            const g = Math.floor(Math.random() * 100); // nilai hijau antara 0 dan 99
                            const b = Math.floor(Math.random() * 255); // nilai biru antara 0 dan 254
                            return `rgba(${r}, ${g}, ${b}, 0.6)`;
                        }),
                        borderColor: labels.map(() => `#344767`),
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'right',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    console.log('Value:', value);
                                    console.log('Total Tickets:', totalTickets);
                                    const percentage = totalTickets > 50 ? '' : totalTickets ? ` (${((value / totalTickets) * 100).toFixed(2)}%)` : ' (0.00%)';
                                    console.log('Percentage:', percentage);
                                    return `${label}: ${value}${percentage}`;
                                }
                            }
                        },
                        datalabels: {
                            formatter: (value, ctx) => {
                                console.log('Value:', value);
                                console.log('Total Tickets:', totalTickets);
                                if (totalTickets > 50) {
                                    return ''; // Tidak tampilkan persentase jika lebih dari 50
                                }
                                const percentage = totalTickets ? ((value / totalTickets) * 100).toFixed(2) + '%' : '0.00%';
                                console.log('Percentage:', percentage);
                                return percentage;
                            },
                            color: '#fff',
                            font: {
                                weight: 'bold'
                            }
                        }                        
                    }
                },
                plugins: [ChartDataLabels]
            });
        })
        .catch(error => console.error('Error fetching visitor data:', error));
});
