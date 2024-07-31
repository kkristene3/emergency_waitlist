<!-- Box behind main content -->
<div id="main-content-box">

    <!-- Welcome message -->
    <h1><?php echo g("h1") ?></h1>
    <h2> -- SIGN IN TO CONTINUE --</h2>

    <!-- Sign in form -->
    <form method="POST">
        <div id="role-selection">
            <p>Please select who you are logging in as:</p>
            <input type="radio" name="role" value="Staff">
            <label for="html">Staff</label>
            <input type="radio" name="role" value="Patient">
            <label for="html">Patient</label>
        </div>
        <div>
            <p>Please enter your login credentials:</p>
            <label for="username">Username: </label>
            <input name="username" placeholder="Username" required>
            <br>
            <label for="3-letter-code">3-letter code: </label>
            <input name="3-letter-code" placeholder="3-letter code" required>
        </div>

        <!-- Submit button -->
        <button name="sign-in-form">SIGN IN</button>
    </form>
</div>
