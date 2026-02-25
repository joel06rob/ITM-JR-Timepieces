//Get the json data from admin_dash_data.

fetch('admin_dash_data.php')
    .then(response => response.json())
    .then(data =>{

        console.log(data);
        document.getElementById("totalOrders").innerText = data.totalOrders;
        document.getElementById("totalUnprocessedOrders").innerText = data.totalUnprocessedOrders;
    });