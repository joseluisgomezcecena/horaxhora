<?php

    require_once("../config/db.php");
    session_start();

    if(isset($_GET['function']) )
    {
         if($_GET['function'] == "selectReportTress")
        {
            ## Read value
            $draw = $_POST['draw'];
            $row = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
            $searchValue = $_POST['search']['value']; // Search value

            ## Search 
            $searchQuery = " ";
            if($searchValue != ''){
                    $searchQuery = " AND (employee_number like '%".$searchValue."%' OR position like '%".$searchValue."%' OR supervisor like '%".$searchValue."%' OR hours like '%".$searchValue."%') ";
            }

            ## Total number of records without filtering
            $sel = mysqli_query($connection,"select count(*) as allcount from horas_tress");
            $records = mysqli_fetch_assoc($sel);
            $totalRecords = $records['allcount'];

            ## Total number of record with filtering
            $sel = mysqli_query($connection,"select count(*) as allcount from horas_tress WHERE 1=1 ".$searchQuery);
            $records = mysqli_fetch_assoc($sel);
            $totalRecordwithFilter = $records['allcount'];

            ## Fetch records
            $empQuery = "select * from horas_tress WHERE 1=1 ".$searchQuery." order by id ".$columnSortOrder." limit ".$row.",".$rowperpage;
            $empRecords = mysqli_query($connection, $empQuery);
            $data = array();
            $count = 0;
            
            while ($row = mysqli_fetch_assoc($empRecords)) {
                $count++;
                ##other querys
                
                #data-toggle='modal' data-target='#exampleModal'

                ##other querys

                $data[] = array( 
                    "count"=>"$count",
                    "employee_number"=>$row['employee_number'],
                    "employee_name"=>htmlentities($row['employee_name'], ENT_SUBSTITUTE),
                    "hours"=>$row['hours'],
                    "supervisor"=>htmlentities($row['supervisor'], ENT_SUBSTITUTE),
                    "posted"=>date('m/d/Y', strtotime($row['posted']))
                );
            }

            ## Response
            $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
            );
            echo json_encode($response);
        }
        else if($_GET['function'] == "selectReportXa")
        {
            ## Read value
            $draw = $_POST['draw'];
            $row = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
            $searchValue = $_POST['search']['value']; // Search value

            ## Search 
            $searchQuery = " ";
            if($searchValue != ''){
                    $searchQuery = " AND (item like '%".$searchValue."%' OR order_number like '%".$searchValue."%' OR description like '%".$searchValue."%' OR class like '%".$searchValue."%') ";
            }

            ## Total number of records without filtering
            $sel = mysqli_query($connection,"select count(*) as allcount from horas_std_xa");
            $records = mysqli_fetch_assoc($sel);
            $totalRecords = $records['allcount'];

            ## Total number of record with filtering
            $sel = mysqli_query($connection,"select count(*) as allcount from horas_std_xa WHERE 1=1 ".$searchQuery);
            $records = mysqli_fetch_assoc($sel);
            $totalRecordwithFilter = $records['allcount'];

            ## Fetch records
            $empQuery = "select * from horas_std_xa WHERE 1=1 ".$searchQuery." order by id ".$columnSortOrder." limit ".$row.",".$rowperpage;
            $empRecords = mysqli_query($connection, $empQuery);
            $data = array();
            $count = 0;

            while ($row = mysqli_fetch_assoc($empRecords)) {
                $count++;
                ##other querys
                
                #data-toggle='modal' data-target='#exampleModal'

                ##other querys

                $data[] = array( 
                    "count"=>"$count",
                    "item"=>$row['item'],
                    "description"=>$row['description'],
                    "planner"=>$row['planner'],
                    "whs"=>$row['whs'],
                    "posted"=>date("m/d/Y", strtotime($row['posted'])),
                    "txn"=>$row['txn'],
                    "order_number"=>$row['order_number'],
                    "quantity"=>$row['quantity'],
                    "class"=>$row['class'],
                    "rates"=>$row['rates'],
                    "yield"=>$row['yield'],
                    "setup"=>$row['setup'],
                    "std_hours"=>$row['std_hours']
                );
            }

            ## Response
            $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
            );
            echo json_encode($response);
        }
        


    }




    //SELECT * FROM `general` LEFT JOIN complete ON `general`.`id_order_number`= complete.order_number_id LEFT JOIN item_number ON `general`.`item_num` = `item_number`.`item_number` ORDER BY `item_number`.`item_number` DESC