<!DOCTYPE html>
<html>
    <head>
        <title>Login page</title>
        <!-- <link rel="stylesheet" type="text/css" href="style1.css"> -->
    </head>
    <body>
        <div class="con" id="main">
            <div class="signup">
                <?php
                if(isset($_POST["signup"])){
                    $name=$_POST["txt"];
                    $email=$_POST["email"];
                    $pass=$_POST["pwd"];
                    $addr=$_POST["addr"];
                    $mobno=$_POST["mobno"];

                    $passencrypt=password_hash($pass, PASSWORD_DEFAULT);
                    $errors=array();
                    if(empty($name) OR empty($email) OR empty($pass) OR empty($addr) OR empty($mobno)){
                        array_push($errors,"All fields are required");
                    }
                    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                        array_push($errors,"Email is not valid");
                    }
                    if(strlen($pass)<8){
                        array_push($errors,"Password must be atleast 8 characters long");
                    }
                    if(strlen($mobno)!==10){
                        array_push($errors,"Mobile number must be of 10 digits");
                    }
                    require_once "database.php";
                    $sql="SELECT * FROM users WHERE email='$email'";
                    $res=mysqli_query($conn,$sql);
                    $rowcount=mysqli_num_rows($res);
                    if($rowcount>0){
                        array_push($errors,"Email already exists");
                    }
                    if(count($errors)>0){
                        foreach ($errors as $error){
                            echo "<div>$error</div>";
                        }
                    }
                    else{
                        
                        $sql="INSERT INTO users (name,email,password,address,phone) VALUES (?,?,?,?,?)";
                        $stmt = mysqli_stmt_init($conn);
                        $prepstmt = mysqli_stmt_prepare($stmt,$sql);
                        if($prepstmt){
                            mysqli_stmt_bind_param($stmt,'sssss',$name,$email,$passencrypt,$addr,$mobno);
                            mysqli_stmt_execute($stmt);
                            echo "<div> Registration successful </div>";
                        } 
                        else{
                            die("Something went wrong");
                        }
                    }

                }
                ?>
                <form action="loginform.php" method="post">
                    <h1>Create Account</h1>
                    <input type="text" name="txt" placeholder="Name" required="">
                    <input type="email" name="email" placeholder="Email id" required="">
                    <input type="password" name="pwd" placeholder="Password" required="">
                    <input type="text" name="addr" placeholder="Address" required="">
                    <input type="text" name="mobno" placeholder="Mobile No" required="">
                    <button name="signup">Sign Up</button>
                </form>
            </div>
            <!-- <div class="login">
                <form action="#">
                    <h1>Login</h1>
                    <input type="email" name="email" placeholder="Email id" required="">
                    <input type="password" name="pwd" placeholder="Password" required="">
                    <button >Login</button>
                </form>
            </div>
            <div class="ovcont">
                <div class="overlay">
                    <div class="overlay-left">
                        <h1>Welcome to our website!!</h1>
                        <p>To keep connected with us please login to your account</p>
                        <button id="login">Login</button>
                    </div>
                    <div class="overlay-right">
                        <h1>Hey there!</h1>
                        <p>Enter your details and start journey with us</p>
                        <button id="signin">Sign up</button>
                    </div>
                </div>
            </div>
        </div> -->
        <!-- <script type="text/javascript">
            const signupbtn = document.getElementById('signin')
            const loginbtn = document.getElementById('login')
            const main = document.getElementById('main')

            signupbtn.addEventListener('click',() =>{
                main.classList.add("right-panel-active");
            });
            loginbtn.addEventListener('click',() =>{
                main.classList.remove("right-panel-active");
            });
        </script> -->
    </body>
</html>

