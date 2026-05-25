<?php
    $page_title = 'Giw — Acasă';
    $page_css   = 'auth';
    $page_js = 'login';
    require __DIR__ . '/../templates/header.php';
?>

     <section class="auth">
        <div class="auth__brand" aria-hidden="true">
            <img src="/images/logo_hero_section.png" alt="" class="auth__brand-logo">
            <p class="auth__brand-tagline">Your digital assistent for finding the best gift.</p>
        </div>

        <div class="auth__content">
            <div class="auth__header">
                <h1>Login:</h1>
                <h2>Welcome! Find gifts for your loved ones with the help of our digital assistent.</h2>
            </div>

            <form class="auth__form" id="login_form">
                <div class="auth__field">
                    <label for="identifier">Username or email</label>
                    <input id="identifier" type="text" placeholder="Username or email..." name="identifier" required>
                </div>

                <div class="auth__field">
                    <label for="password">Password</label>
                    <input id="password" type="password" placeholder="Parola..." name="password" minlength="8" required>
                </div>
                 <span id="message__invalid_credentials"></span>
                <button type="submit" class="btn btn--primary auth__submit">Login!</button>

                <p class="auth__alt">
                    Don't have an account yet? <a href="/register.php">Register</a>
                </p>
            </form>
        </div>
    </section>

<?php 
    require __DIR__ . '/../templates/footer.php';
?>