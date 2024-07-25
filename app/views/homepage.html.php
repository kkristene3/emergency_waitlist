<h1><?php echo g("h1") ?></h1>
<form method="POST">
    <p>Please select who you are logging in as:</p>
    <input type="radio" name="role" value="Staff">
    <label for="html">Staff</label>
    <input type="radio" name="role" value="Patient">
    <label for="html">Patient</label>
    <br><br>
    <label for="username">Username: </label>
    <input name="username" placeholder="Username" required>
    <br>
    <label for="3-letter-code">3-letter code: </label>
    <input name="3-letter-code" placeholder="3-letter code" required>
    <br>
    <button name="sign-in-form">Go</button>
</form>
