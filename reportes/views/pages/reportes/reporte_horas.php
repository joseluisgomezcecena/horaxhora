<style>
    #table_complete input{
        border: none;
    }
    #table_complete input:focus{
        border: none;
    }
    #table_complete textarea{
        border: none;
    }
    #table_complete textarea:focus{
        border: none;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div  class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-default">Report Standard Hours / Tress Hours</h6>
            </div>
            <div class="card-body">
                <?php
                    $date = date('Y/m/d',strtotime("-1 days")); // Return yesterday date
                    $query_std_xa  = "SELECT * FROM `horas_std_xa` WHERE posted = '$date'"; 
                    $query_tress   = "SELECT * FROM `horas_tress` WHERE posted = '$date'"; 
                    
                    $result_std_xa = $connection->query($query_std_xa);
                    $result_tress  = $connection->query($query_tress);

                    if($result_std_xa && $result_tress)
                    {
                        if($result_std_xa->num_rows == 0)
                        {
                            ?>
                                <div class="alert alert-danger">
                                  <strong>Warning!</strong> You haven't import the XA file yet.
                                </div>
                            <?php
                        }
                        
                        if($result_tress->num_rows == 0){
                            ?>
                                <div class="alert alert-danger">
                                  <strong>Warning!</strong> You haven't import the Tempus report yet.
                                </div>
                            <?php    
                        }

                    }

                ?>
                <div class="table-responsive" >
                    <table style="font-size: 12px;" class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Plant</th>
                                <th>Hours XA</th>
                                <th>Hours tress</th>
                                <th>Efficiency</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $query_xa = "SELECT `planner_codes`.`planta`, ROUND(SUM(`horas_std_xa`.`std_hours`),2) as 'horas' 
                                             FROM `horas_std_xa` 
                                             INNER JOIN planner_codes ON `horas_std_xa`.planner = `planner_codes`.`planner` 
                                             WHERE `horas_std_xa`.`planner` in (SELECT planner from planner_codes) AND posted = '$date' 
                                             GROUP BY `planner_codes`.`planta`
                                             ORDER BY `planner_codes`.`planta` ASC";

                                $query_tress = "SELECT `supervisores`.`planta_supervisor` AS 'planta', ROUND(SUM(`horas_tress`.`hours`),2) AS 'horas' 
                                                FROM `horas_tress` 
                                                INNER JOIN supervisores ON `horas_tress`.supervisor = `supervisores`.`nombre_supervisor` 
                                                WHERE `horas_tress`.`supervisor` in (SELECT nombre_supervisor from supervisores) AND posted = '$date'
                                                GROUP BY `supervisores`.`planta_supervisor`
                                                ORDER BY `supervisores`.`planta_supervisor` ASC";
                                
                                $result_xa = $connection->query($query_xa);
                                $result_tress = $connection->query($query_tress);
                                if($result_xa && $result_tress)
                                {
                                    if($result_xa->num_rows > 0 && $result_tress->num_rows > 0)
                                    {
                                        $plantas     = [];
                                        $hours_xa    = [];
                                        $hours_tress = [];
                                        while($row_xa = $result_xa->fetch_assoc())
                                        {
                                            $plantas[]  = $row_xa['planta'];
                                            $hours_xa[] = $row_xa['horas'];
                                        }
                                        while( $row_tress = $result_tress->fetch_assoc())
                                        {
                                            $hours_tress[] = $row_tress['horas'];
                                        }
                                        for($x = 0; $x < count($plantas); $x++)
                                        {
                                            $eff = 100 * round($hours_xa[$x]/$hours_tress[$x], 4);
                                            echo "<tr>";
                                            echo "<td>Plant {$plantas[$x]}</td>";
                                            echo "<td>{$hours_xa[$x]}</td>";
                                            echo "<td>{$hours_tress[$x]}</td>";
                                            echo "<td>{$eff}%</td>";
                                            echo "</tr>";
                                        }
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>