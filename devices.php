<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">

    <?php 
        session_start();

        if(!isset($_SESSION['id'])){
            header("Location: login.html");
        }
    ?>
</head>
<body onload="loadDoc()">
    <nav>
        <ul>
            <li><a href="devices.php">Home</a></li>
            <li class='selected'><a href="devices.php" >Devices Dashboard</a></li>
            <li><a href="employees.html">Employees List</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <div class='table-container'>
        <div style='display:flex; justify-content: space-between; align-items: center; padding-right: 10%;'>
            <h1>List of Devices</h1>
            <a href="add-devices.php" style="font-size:18px; font-weight: bold;">Add New Device</a>
        </div>
        <table id='table'>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>PICTURE</th>
                <th>AVAILABLE</th>
                <th>ISSUED BY</th>
                <th>ISSUED TO</th>
                <th>RECIEVED BY</th>
                <th>ISSUE TO</th>
                <th>ACTIONS</th>
            </tr>
        </table>
    </div>

    <script>
        let xhttp = new XMLHttpRequest();
        
        let loadEmployees = () => {
            xhttp.open("GET", 'get-employees-data.php', false);
            xhttp.send();
            
            let employees = xhttp.responseText;
            
            return JSON.parse(employees);
        };

        let loadUsers = () => {
            xhttp.open('GET', 'get-users-data.php', false);
            xhttp.send();

            let users = xhttp.responseText;

            return JSON.parse(users);
        }

        let employees = loadEmployees();
        let users = loadUsers();


    </script>

    <script>
        let table = document.getElementById("table");

        let issue_device = (e_id, d_id, u_id) => {
            console.log(e_id, d_id, u_id);

            xhttp.open('get', `issue.php?e_id=${e_id}&d_id=${d_id}&u_id=${u_id}`, false);
            xhttp.send();

            location.reload();
        }

        let loadDoc = () => {

        xhttp.open("get", "get-devices-data.php", false);
        xhttp.send();

        let deviceJson = xhttp.responseText;
        let devices = JSON.parse(deviceJson);

        
        devices.forEach((device) => {
            let row = document.createElement("tr");
            
            let id = device.id;
            row.id = id; 
            let name = device.name;
            let picture = device.picture_file_name;
            let availability = device.issued_to ? "NO" : "YES";
            let issued_by = device.issued_by ? device.issued_by : "";

            if (issued_by) {
                users.forEach(user => {
                    if (user.id === issued_by) {
                        issued_by = user.full_name;
                    }
                })
            }

            let issued_to = device.issued_to ? device.issued_to : "";

            if (issued_to) {
                employees.forEach(employee => {
                    if (employee.id === issued_to) {
                        issued_to = employee.name;
                    }
                })
            }

            let received = device.received_by ? device.received_by : "";

            if (received) {
                users.forEach(user => {
                    if (user.id === received){
                        received = user.full_name;
                    }
                })
            }
            let issue = device.issued_to ? "" : 'check';

            let td_id = document.createElement("td");
            td_id.innerHTML = id;

            let td_name = document.createElement("td");
            td_name.innerHTML = name;

            let td_picture = document.createElement("td");
            let img_picture = document.createElement("img");
            img_picture.src = `images/${picture}`;
            img_picture.height = 45;
            td_picture.appendChild(img_picture);

            let td_availability = document.createElement("td");
            td_availability.innerHTML = availability;

            let td_issuedBy = document.createElement("td");
            td_issuedBy.innerHTML = issued_by;

            let td_issuedTo = document.createElement("td");
            td_issuedTo.innerHTML = issued_to;

            let td_received = document.createElement("td");
            td_received.innerHTML = received;

            let td_issue = document.createElement("td");

            if(issue){
                let select_issue = document.createElement('select');
                let option_issue_def = document.createElement('option');
                option_issue_def.value=null;
                option_issue_def.innerHTML = "Select Employee";
                select_issue.appendChild(option_issue_def);
                
                
                employees.forEach(employee => {
                    let option_issue = document.createElement('option');
                    option_issue.value = employee.id;
                    option_issue.innerHTML= employee.name;
                    
                    select_issue.appendChild(option_issue);
                });
                
                select_issue.addEventListener("change", (event, id=device.id, uid=<?=$_SESSION['id']?>) => {
                    e_id = event.target.options[event.target.selectedIndex].value;
                    issue_device(e_id, id, uid);
                })
                td_issue.appendChild(select_issue);
            }else{
            
                td_issue.innerHTML = "";

            }
            

            let td_actions = document.createElement("td");
            let div_actions = document.createElement('div');

            let anchor_update = document.createElement("a");
            anchor_update.href = `update.php?id=${id}`;
            anchor_update.innerHTML = "Update"
            
            let anchor_delete = document.createElement("a");
            anchor_delete.href = `javascript: delete_device(${id}, '${picture}'); `;
            anchor_delete.innerHTML = "Delete";

            let spacer1 = document.createElement('span');
            spacer1.innerHTML = ' | ';


            

            div_actions.appendChild(anchor_update);
            div_actions.appendChild(spacer1);
            div_actions.appendChild(anchor_delete);
            if (!issue){
                let anchor_recieve = document.createElement("a");
                anchor_recieve.href = `recieve.php?uid=${<?=$_SESSION['id']?>}&did=${id}`;
                anchor_recieve.innerHTML = "Recieve";

                let spacer2 = document.createElement('span');
                spacer2.innerHTML = ' | ';

                div_actions.appendChild(spacer2);
                div_actions.appendChild(anchor_recieve);
            }


            td_actions.appendChild(div_actions);


            row.appendChild(td_id);
            row.appendChild(td_name);
            row.appendChild(td_picture);
            row.appendChild(td_availability);
            row.appendChild(td_issuedBy);
            row.appendChild(td_issuedTo);
            row.appendChild(td_received);
            row.appendChild(td_issue);
            row.appendChild(td_actions);

            table.appendChild(row);
            });
        }

        let delete_device = (dev_id, picture_name) => {
            console.log(dev_id, picture_name);
            xhttp.open("GET", `delete.php?id=${dev_id}&picture-name=${picture_name}`, false);
            xhttp.send();

            document.getElementById(dev_id).remove();
        }
    </script>
</body>
</html>





