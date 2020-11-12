<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Your Test Results!</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-center">

                <?php

                $correctas = 0;
                $test_id = $_GET['test'];
                $query7 = "SELECT * FROM test WHERE test_id = $test_id";
                $result7 = mysqli_query($connection, $query7);
                $numero_preguntas = mysqli_num_rows($result7);
                while($row7 = mysqli_fetch_array($result7))
                {
                    if($row7['correct_answers']==1)
                    {
                         $correctas++;
                    }
                }

                $calificacion = round(($correctas/$numero_preguntas)*100,1);

                if($calificacion>=80)
                {
                    $passed = 1;
                }
                else
                {
                    $passed = 0;
                }
                if($passed == 1)
                {
                    echo
                    "
                        <h4 class='text-info'><b>You Passed!</b></h4>
                        <p>You got $correctas out of $numero_preguntas questions correct.</p>
                        <p>Youur score is <b class='text-success'>$calificacion</b></p>
                        <img class=\"img-fluid\" src=\"assets/img/happy.png\">
                        <a href=\"index.php?page=certificate&video_id=1\" class=\"btn btn-info btn-icon-split\">
                                            <span class=\"icon text-white-50\">
                                              <i class=\"fas fa-certificate\"></i>
                                            </span>
                            <span class=\"text\">Get Certificate!</span>
                        </a>
                    ";
                }
                else
                {
                    echo
                    "
                        <h4 class='text-danger'><b>You didn't Pass, Click Ok and Try Again!</b></h4>
                        <p>You got $correctas out of $numero_preguntas questions correct.</p>
                        <p>Youur score is <b class='text-danger'>$calificacion</b></p>
                        <img class=\"img-fluid\" src=\"assets/img/tryagain.png\">
                        
                    ";
                }
                ?>



            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>