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
            
            //(3)Products Chart
            const PRODUCTS_LABELS = data.unitsSold.map(item => item.Name);
            const PRODUCTS_VALUES = data.unitsSold.map(item => item.TotalUnitsSold);

            document.getElementById("totalOrders").innerText = data.totalOrders;
            document.getElementById("totalUnprocessedOrders").innerText = data.totalUnprocessedOrders;
            document.getElementById("totalRevenue").innerText = "£" + data.totalRevenue;
            document.getElementById("mostPopular").innerText = data.mostPopular.Name;
            const ctx = document.getElementById("totalOrdersByDate").getContext("2d");
            const ctx2 = document.getElementById("totalRevenueByDate").getContext("2d");
            const ctx3 = document.getElementById("productOrders").getContext("2d");

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
            new Chart(ctx3, {
                type: 'pie',
                data: {
                    labels: PRODUCTS_LABELS,
                    datasets: [{
                        label: 'Units Sold',
                        data: PRODUCTS_VALUES,
                        backgroundColor: [
                        '#9003fc',
                        '#b759ff',
                        '#460578',
                        '#ae00c2',
                        '#ba46c7',
                        '#6c46c7',
                        '#2c0d75'
                         ],
                        borderColor: '#161616',
                    }]
                }
            });

        });
})

