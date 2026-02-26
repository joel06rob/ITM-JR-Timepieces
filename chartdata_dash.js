document.addEventListener("DOMContentLoaded", function(){
    //Get the json data from admin_dash_data.
    fetch('admin_dash_data.php')
        .then(response => response.json())
        .then(data =>{
            console.log(data);

            //Set chart labels/values
            const CHART_LABELS = data.totalOrdersByDate.map(item => item.OrderDate_Simplified);
            const CHART_VALUES = data.totalOrdersByDate.map(item => item.TotalOrdersPerDate);

            document.getElementById("totalOrders").innerText = data.totalOrders;
            document.getElementById("totalUnprocessedOrders").innerText = data.totalUnprocessedOrders;
            const ctx = document.getElementById("totalOrdersByDate").getContext("2d");

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: CHART_LABELS,
                    datasets: [{
                        label: 'Orders Per Day',
                        data: CHART_VALUES,
                        tension: 0.3,
                        
                    }]
                }
            });

        });
})

