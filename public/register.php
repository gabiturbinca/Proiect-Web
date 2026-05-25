<?php
    $page_title = 'Giw — Acasă';
    $page_css   = 'auth';
    $page_js = 'register';
    require __DIR__ . '/../templates/header.php';
?>

    <section class="auth">
        <div class="auth__brand" aria-hidden="true">
            <img src="/images/logo_hero_section.png" alt="" class="auth__brand-logo">
            <p class="auth__brand-tagline">Your digital assistent for finding the perfect gift.</p>
        </div>

        <div class="auth__content">
            <div class="auth__header">
                <h1>Register:</h1>
                <h2>Make an account to order gifts for your loved ones.</h2>
            </div>

            <form method="POST" action="/home.php" class="auth__form" id="register_form">
                <div class="auth__field">
                    <label for="username">Username</label>
                    <input id="username" type="text" placeholder="Username..." name="username" required>
                    <span id="message__username"></span>
                </div>

                <div class="auth__field">
                    <label for="email">Email</label>
                    <input id="email" type="email" placeholder="Email..." name="email" required>
                    <span id="message__email" ></span>
                </div>

                <div class="auth__field">
                    <label for="password">Password</label>
                    <input id="password" type="password" placeholder="Parola..." name="password" minlength="8" required>
                </div>


                <div class="auth__field">
                    <label for="password_confirmation">Confirm password</label>
                    <input id="password_confirmation" type="password" placeholder="Confirma parola..." name="password_confirmation" minlength="8" required>
                </div>

                <button type="submit" class="btn btn--primary auth__submit">Register!</button>
                <span id="message__register"></span>
                <p class="auth__alt">
                    Already have an account? <a href="/login.php">Login</a>
                </p>
            </form>
        </div>
    </section>


<?php 
    require __DIR__ . '/../templates/footer.php';
?>