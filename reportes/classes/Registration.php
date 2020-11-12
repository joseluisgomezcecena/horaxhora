<?php

/**
 * Class registration
 * handles the user registration
 */
class Registration
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$registration = new Registration();"
     */
    public function __construct()
    {
        if (isset($_POST["register"])) {
            $this->registerNewUser();
        }
    }

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     */
    private function registerNewUser()
    {
        if (empty($_POST['user_name'])) 
        {
            $this->errors[] = "Empty Username";
        } 
        elseif (empty($_POST['user_password_new']) || empty($_POST['user_password_repeat'])) 
        {
            $this->errors[] = "Empty Password";
        } 
        elseif ($_POST['user_password_new'] !== $_POST['user_password_repeat']) 
        {
            $this->errors[] = "Password and password repeat are not the same";
        } 
        elseif (strlen($_POST['user_password_new']) < 6) 
        {
            $this->errors[] = "Password has a minimum length of 6 characters";
        } 
        elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) 
        {
            $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
        } 
        elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) 
        {
            $this->errors[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        } 
        elseif (empty($_POST['user_email'])) 
        {
            $this->errors[] = "Email cannot be empty";
        } 
        elseif (strlen($_POST['user_email']) > 64) 
        {
            $this->errors[] = "Email cannot be longer than 64 characters";
        } 
        elseif (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) 
        {
            $this->errors[] = "Your email address is not in a valid email format";
        } 
        elseif (!empty($_POST['user_name'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && !empty($_POST['user_email'])
            && strlen($_POST['user_email']) <= 64
            && filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) 
        {
            // create a database connection
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) 
            {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) 
            {

                // escaping, additionally removing everything that could be (html/javascript-) code
                $user_name = $this->db_connection->real_escape_string(strip_tags($_POST['user_name'], ENT_QUOTES));
                $user_email = $this->db_connection->real_escape_string(strip_tags($_POST['user_email'], ENT_QUOTES));

                $user_password = $_POST['user_password_new'];

                // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                // PHP 5.3/5.4, by the password hashing compatibility library
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

                // check if user or email address already exists
                $sql = "SELECT * FROM users WHERE user_name = '" . $user_name . "' OR user_email = '" . $user_email . "';";
                $query_check_user_name = $this->db_connection->query($sql);

                if ($query_check_user_name->num_rows == 1)
                {
                    $this->errors[] = "User name or email already in use.";
                } 
                else 
                {
                    if(empty($_FILES['profile_pic'] ['name'])) 
                    {
                        $uploadOk = 1;
                        $target_file = "uploads/profiles/newuser.png";
                    }
                    else
                    {

                        $target_dir = "uploads/profiles/";
                        $target_file = $target_dir .rand().basename($_FILES["profile_pic"]["name"]);
                        $uploadOk = 1;
                        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    
                        
                        
                        // repetido
                        if (file_exists($target_file)) 
                        {
                            $this->errors[] = "File exists";
                            $uploadOk = 0;
                        }
                        // peso
                        if ($_FILES["profile_pic"]["size"] > 99000000) 
                        {
                            $this->errors[] = "Your file is too big, 2MB max";
                            $uploadOk = 0;
                        }
    
                        // formatos
                        if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "JPEG" 
                        && $imageFileType != "jpeg" && $imageFileType != "PNG" && $imageFileType != "png" 
                        && $imageFileType != "gif" && $imageFileType != "GIF") 
                        {
                            $this->errors[] = "Only jpg, png and gif formats are supported.";
                        }
    
                        // Check if $uploadOk is set to 0 by an error
                        if ($uploadOk == 0) 
                        {
                            //echo "El archivo fue cargado.";
                            // todo salio bien subir el archivo
                            //header("Location: index.php?page=upload_form&title=$tile&success=false&error=upload");
                        } 
                        else 
                        {
                            $uploadOk = 1;
                            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) 
                            {
                                //echo "El archivo:  ". basename( $_FILES["profile_pic"]["name"]). " fue cargado.";
                            } 
                            else 
                            {
                                //echo "Hubo un error al subir el archivo.";
                            }
                        }

                    }
                    
                  

                    if($uploadOk == 1)
                    {


                        $user_nombre    = $_POST['nombre'];
                        $user_apellido  = $_POST['apellido'];
                        $empleado       = $_POST['empleado'];
                        $departamento   = $_POST['departamento'];
                        $profile_pic    = $target_file;
                       
    
                        $sql = "INSERT INTO users (user_name, user_password_hash, user_email, user_nombre, user_apellido, user_numero, department_id, profile_pic)
                                VALUES('" . $user_name . "', '" . $user_password_hash . "', '" . $user_email . "',  '" . $user_nombre . "', '" . $user_apellido . "', '" . $empleado . "' , '" . $departamento . "', '" . $profile_pic . "');";
                        $query_new_user_insert = $this->db_connection->query($sql);
    
                        // if user has been added successfully
                        if ($query_new_user_insert) 
                        {
                            $this->messages[] = "Account created successfully.";
                        } 
                        else 
                        {
                            $this->errors[] = "Registration failed:.".$sql;
                        }


                    }
                    else
                    {
                        $this->errors[] = "Upload Failed.";        
                    }
                   
                }
            } 
            else 
            {
                $this->errors[] = "Database connection lost.";
            }
        } 
        else 
        {
            $this->errors[] = "An unexpected error ocurred.";
        }
    }
}
