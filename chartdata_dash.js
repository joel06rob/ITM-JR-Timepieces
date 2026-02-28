document.addEventListener("DOMContentLoaded", function(){
    //Get the json data from admin_dash_data.
    fetch('admin_dash_data.php')
        .then(response => response.json())
        .then(data =>{
            console.log(data);

            //Set chart labels/values
            //(1)Orders Chart
            const ORDERS_LABELS = data.totalOrdersByDate.map(item => item.OrderDate_Simplified);
            const ORDERS_VALUES = data.totalOrdersByDate.map(item => item.TotalOrdersPerDate);

            //(2)Revenue Chart
            const REVENUE_LABELS = data.totalRevenueByDate.map(item => item.RevenueDate);
            const REVENUE_VALUES = data.totalRevenueByDate.map(item => item.TotalRevenue);

            document.getElementById("totalOrders").innerText = data.totalOrders;
            document.getElementById("totalUnprocessedOrders").innerText = data.totalUnprocessedOrders;
            document.getElementById("totalRevenue").innerText = "£" + data.totalRevenue;
            const ctx = document.getElementById("totalOrdersByDate").getContext("2d");
            const ctx2 = document.getElementById("totalRevenueByDate").getContext("2d");

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ORDERS_LABELS,
                    datasets: [{
                        label: 'Orders Per Day',
                        data: ORDERS_VALUES,
                        tension: 0.3,
                        
                    }]
                }
            });
            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: REVENUE_LABELS,
                    datasets: [{
                        label: 'Revenue Per Day',
                        data: REVENUE_VALUES,
                        tension: 0.3,
                        backgroundColor: '#42f575',
                        borderColor: '#42f575',
                    }]
                }
            });

        });
})

