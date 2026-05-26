<?php
    $page_title = 'Change password';
    $page_css   = 'changePasswordRequest';
    $page_js = 'changePasswordRequest';
    require __DIR__ . '/../templates/header.php';
?>

 <section class="change__password-container">
        <div class="title">
            <h1>Request to change your password</h1>
            <h2>Have in mind that if the admin accepts your request, you will have to login with a different password</h2>
        </div>

        <form class="request_new_password-form">
            
            <div class="auth__field">
                <label for="identifier">Username or email</label>
                <input id="identifier" type="text" placeholder="Username or email.." name="identifier" required>
            </div>

            <div class="auth__field">
                <label for="message"> Message to the admin:</label>
                <input id="message" type="textarea" placeholder="Write a message..." name="message">
            </div>

            <button type="submit" class="btn btn--primary change_pass__submit" id="change_pass__submit">Submit!</button>
            <span id="message_"></span>
        </form>
    </section>

<?php
    require __DIR__ . '/../templates/footer.php';
?>