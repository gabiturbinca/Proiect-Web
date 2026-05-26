<?php
    $page_title = 'Change password';
    $page_css   = 'changePassword';
    $page_js = 'changePassword';
    require __DIR__ . '/../templates/header.php';
?>

    <section class="change__password-container">
        <div class="title">
            <h1>Change your password</h1>
        </div>

        <form class="change_password-form">
            
            <div class="auth__field">
                <label for="current_password">Old password</label>
                <input id="current_password" type="password" placeholder="Old password..." name="current_password" minlength="8" required>
            </div>

            <div class="auth__field">
                <label for="new_password"> New password</label>
                <input id="new_password" type="password" placeholder="New password..." name="new_password" minlength="8" required>
            </div>


            <div class="auth__field">
                <label for="new_password_confirmation">Confirm password</label>
                <input id="new_password_confirmation" type="password" placeholder="Confirm password..." name="new_password_confirmation" minlength="8" required>
            </div>

            <button type="submit" class="btn btn--primary change_pass__submit" id="change_pass__submit">Change password!</button>
            <span id="message"></span>
        </form>
    </section>

<?php
    require __DIR__ . '/../templates/footer.php';
?>