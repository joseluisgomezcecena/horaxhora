<?php
function countAlerts()
{
    global $connection;
    $today = date("Y-m-d");

     if($_SESSION['qua_isadmin'] == 1 OR $_SESSION['qua_issuperadmin'] == 1)
        $alert_count = "SELECT incoming_id, COUNT(*) AS numero  FROM   incoming_log WHERE out_quarantine = 0 AND date_end < '$today' AND received = 1;";
      elseif($_SESSION['qua_isadmin'] == 0 OR $_SESSION['qua_issuperadmin'] == 0)
        $alert_count = "SELECT incoming_id, COUNT(*) AS numero  FROM   incoming_log WHERE out_quarantine = 0 AND date_end < '$today' AND received = 1 AND responsible_dept_id = {$_SESSION['qua_department_id']};";

      $run_alert_count = mysqli_query($connection, $alert_count );
    if($run_alert_count)
    {
        $row_alert_count = mysqli_fetch_array($run_alert_count);
        echo $row_alert_count['numero'];
        
    }
    else
    {
        echo "0";
    }
}



function getAlerts()
{
    global $connection;
    $today = date("Y-m-d");

    if($_SESSION['qua_isadmin'] == 1 OR $_SESSION['qua_issuperadmin'] == 1)
      $alert_text = "SELECT incoming_id, responsible_dept_id, name, date_end, received, COUNT(*) AS numero  FROM   incoming_log  LEFT JOIN departamentos ON incoming_log.responsible_dept_id = departamentos.id WHERE date_end < '$today' AND out_quarantine = 0 AND received = 1 GROUP BY incoming_log.responsible_dept_id;";
    
    if($_SESSION['qua_isadmin'] == 0 OR $_SESSION['qua_issuperadmin'] == 0)
     echo $alert_text = "SELECT incoming_id, responsible_dept_id, name, date_end, received, COUNT(*) AS numero  FROM   incoming_log  LEFT JOIN departamentos ON incoming_log.responsible_dept_id = departamentos.id WHERE date_end < '$today' AND out_quarantine = 0 AND received = 1 AND responsible_dept_id = {$_SESSION['qua_department_id']};";

    
    
      $run_alert_text = mysqli_query($connection, $alert_text );
    if($run_alert_text)
    {
        $num_alerts = mysqli_num_rows($run_alert_text);

        if($num_alerts == 0)
        {
            echo
            "

            <a class=\"dropdown-item d-flex align-items-center\" href=\"#\">
                <div class=\"mr-3\">
                  <div class=\"icon-circle bg-danger\">
                    <i class=\"fas fa-exclamation-circle text-white\"></i>
                  </div>
                </div>
                <div>
                  <div class=\"small text-gray-500\">$today</div>
                  <span class=\"font-weight-bold\">No alerts to show.</span>
                </div>
            </a>


            ";

        }
        else
        {

            $row_alert_text = mysqli_fetch_array($run_alert_text);
            echo
            "

            <a class=\"dropdown-item d-flex align-items-center\" href=\"#\">
                <div class=\"mr-3\">
                  <div class=\"icon-circle bg-danger\">
                    <i class=\"fas fa-exclamation-circle text-white\"></i>
                  </div>
                </div>
                <div>
                  <div class=\"small text-gray-500\">{$row_alert_text['date_end']}</div>
                  <span class=\"font-weight-bold\">Late item for pickup: {$row_alert_text['name']} Id: {$row_alert_text['incoming_id']}</span>
                </div>
            </a>


        ";

        }


    }
    else
    {
        echo
        "

        <a class=\"dropdown-item d-flex align-items-center\" href=\"#\">
            <div class=\"mr-3\">
              <div class=\"icon-circle bg-danger\">
                <i class=\"fas fa-exclamation-circle text-white\"></i>
              </div>
            </div>
            <div>
              <div class=\"small text-gray-500\">$today</div>
              <span class=\"font-weight-bold\">No data available.</span>
            </div>
          </a>


        ";
    }
}




?>
