document.addEventListener('DOMContentLoaded', function() {
    function fetchVisitorData(startDate, endDate) {
        const url = new URL('/visitor-data', window.location.origin);
        if (startDate) url.searchParams.append('start_date', startDate);
        if (endDate) url.searchParams.append('end_date', endDate);

        fetch(url)
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.nationality);
                const qtyTickets = data.map(item => item.total_qty_ticket);

                const ctx = document.getElementById('visitorChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Qty Ticket',
                            data: qtyTickets,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index',
                        },
                        scales: {
                            y: {
                                grid: {
                                    drawBorder: false,
                                    display: true,
                                    drawOnChartArea: true,
                                    drawTicks: false,
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    display: true,
                                    padding: 10,
                                    color: '#344767',
                                    font: {
                                        size: 11,
                                        family: "Open Sans",
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                }
                            },
                            x: {
                                grid: {
                                    drawBorder: false,
                                    display: false,
                                    drawOnChartArea: false,
                                    drawTicks: false,
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    display: true,
                                    color: '#344767',
                                    padding: 20,
                                    font: {
                                        size: 11,
                                        family: "Open Sans",
                                        style: 'normal',
                                        lineHeight: 2
                                    },
                                }
                            },
                        },
                    },
                });
            })
            .catch(error => console.error('Error fetching visitor data:', error));
    }

    // Get dates from URL if available
    const urlParams = new URLSearchParams(window.location.search);
    const startDate = urlParams.get('start_date');
    const endDate = urlParams.get('end_date');

    // Fetch data when page loads
    fetchVisitorData(startDate, endDate);

    // Add event listener to the form to fetch data on submit
    document.getElementById('filterForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        fetchVisitorData(startDate, endDate);
    });
});

function clearDates() {
    document.getElementById('start_date').value = '';
    document.getElementById('end_date').value = '';
    // Trigger form submit to reload chart with no dates
    document.getElementById('filterForm').dispatchEvent(new Event('submit'));
}
