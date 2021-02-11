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
                <?php
                    $date =  isset($_POST['date']) ? date("m/d/Y", strtotime($_POST['date'])) : date("Y/m/d");
                ?>
                <h6 class="m-0 font-weight-bold text-default">Report Standard Hours / Tress Hours <?php echo "<small>$date</small>" ?></h6>
            </div>
            <div class="card-body">
                <form  id="submit_report" action="index.php?page=reporte_horas" method="post" class="mb-3">
                    <label for="date">Fecha de reporte: </label>
                    <input id="date" type="date" name="date" class="mr-3" require>
                    <input id="submit_report" class="btn btn-primary" type="submit" name="submit_report" value="Get Report"/>
                </form>
                <?php
                    if(isset($_POST['submit_report']))
                    {
                        $date = date("Y/m/d", strtotime($_POST['date']));
                        $date_format = date("m/d/Y", strtotime($_POST['date']));
                        $flag = 1;
    
                        $query_std_xa  = "SELECT * FROM `horas_std_xa` WHERE posted = '$date'"; 
                        $query_tress   = "SELECT * FROM `eficiencia_xa_tress` WHERE fecha = '$date'"; 
                        
                        $result_std_xa = $connection->query($query_std_xa);
                        $result_tress  = $connection->query($query_tress);
    
                        if($result_std_xa && $result_tress)
                        {
                            if($result_tress->num_rows == 0)
                            {
                                ?>
                                    <div class="alert alert-danger text-center">
                                      <strong>Warning!</strong> You haven't import the Tempus file yet.
                                    </div>
                                <?php

                                if($result_std_xa->num_rows == 0) 
                                {
                                    ?>
                                        <div class="alert alert-danger text-center">
                                        <strong>Warning!</strong> You haven't import the XA file yet.
                                        </div>
                                    <?php
                                }
                            }
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
                                $date = isset($_POST['date']) ? date("Y/m/d", strtotime($_POST['date'])) : date('Y/m/d');
                                
                                $query_eff = "SELECT * FROM `eficiencia_xa_tress` WHERE fecha = '$date'";
                                $result_eff = $connection->query($query_eff);
                                if($result_eff)
                                {
                                    if($result_eff->num_rows > 0)
                                    {
                                        while($row_eff = $result_eff->fetch_assoc())
                                        {
                                            echo "<tr>";
                                            echo "<td>Plant {$row_eff['planta']}</td>";
                                            echo "<td>{$row_eff['xa_hrs']}</td>";
                                            echo "<td>{$row_eff['tress_hrs']}</td>";
                                            echo "<td>{$row_eff['eficiencia']}%</td>";
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