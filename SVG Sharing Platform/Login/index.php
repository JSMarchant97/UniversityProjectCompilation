<?php
include '../includes/db.php';
include '../includes/navbar.php';
?>
<script>
    function showsignup()
    {
        var x = document.getElementById("emailsection");
        var y = document.getElementById("signupsection");
        x.style.display = "none";
        y.style.display = "block";
    }

    function goback()
    {
        window.location.href = "http://voltafy.co.uk/jakevolt/Login/";
    }

    function showpassword()
    {
        var x = document.getElementById("emailsection");
        var z = document.getElementById("passwordsection");
        x.style.display = "none";
        z.style.display = "block";
    }
    var emaillog = document.getElementById("emaillog");
    var nextbtn = document.getElementById("nextbtn")


    if (emaillog.value.length > 0)
    {
        nextbtn.disabled = true;
    }
    else
    {
        nextbtn.disabled = false;
    }
</script>
<section class="maincontainer">
    <form action="" method="post">
        <div id="emailsection">
            <p><?php echo $signupsuccess; ?></p>
            <h1 class="loginhead">Log in</h1>
            <h2 class="emailhead">Email</h2>
            <input id="emaillog" type="email" name="email" class="emailtxt" placeholder="Enter your email address here" required>
            <p><?php echo $noemail; ?></p>
            <button class="nextbtn" id="nextbtn" name="action" value="next">Next</button>
            <p class="errormsg"><?php echo $errormsg; ?></p>
            <input id="togglesignup" onclick="showsignup()" type="button" class="signupbtn" value="Sign Up">
        </div>
    </form>
    <form action="" method="post">
        <div class="signupsection" id="signupsection">
            <h2 class="emailhead">Email</h2>
            <input type="email" class="emailtxt" name="signemail" placeholder="Enter your email address here" required>
            <h2 class="emailhead">Username</h2>
            <input type="text" class="emailtxt" name="user" placeholder="Enter a username" required>
            <h2 class="emailhead">Password</h2>
            <input type="password" class="emailtxt" name="pass" placeholder="Enter a password" required>
            <button class="signupbtn" name="action" value="signup">Sign up</button>
            <p class="errormsg"><?php echo $errormsg; ?></p>
            <input type="button" onclick="goback()" class="gobackbtn" value="Go back to log in">
        </div>
    </form>
    <form action="" method="post">
        <div class="passwordsection" id="passwordsection">
            <h2 class="emailhead">Welcome, <?php echo $accuser; ?></h2>
            <h2 class="emailhead">Enter your password</h2>
            <input type="password" class="emailtxt" name="password" placeholder="Enter a password" required>
            <button class="loginbtn" id="loginbutton" name="action" value="login">Sign in</button>
            <p class="errormsg"><?php echo $errormsg; ?></p>
            <input type="button" onclick="goback()" class="gobackbtn" value="Go back">
        </div>
    </form>
</section>

<?php 
    if ($emailcheck = 1)
    {
        echo $showpassword; 
    }

    if ($signcheck = 1)
    {
        echo $signup; 
    }
?>
<?php include '../includes/footer.php'; ?>