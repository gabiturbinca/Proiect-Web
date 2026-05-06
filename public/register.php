<?php
    $page_title = 'Giw — Acasă';
    $page_css   = 'auth';
    $page_js = 'register';
    require __DIR__ . '/../templates/header.php';
?>

    <section class="auth">
        <div class="auth__brand" aria-hidden="true">
            <img src="/images/logo_hero_section.png" alt="" class="auth__brand-logo">
            <p class="auth__brand-tagline">Asistent digital pentru alegerea cadoului perfect.</p>
        </div>

        <div class="auth__content">
            <div class="auth__header">
                <h1>Înregistrează-te:</h1>
                <h2>Fă-ți cont la noi pentru a putea comanda cadouri pentru cei dragi.</h2>
            </div>

            <form method="POST" action="/home.php" class="auth__form" id="register_form">
                <div class="auth__field">
                    <label for="username">Username</label>
                    <input id="username" type="text" placeholder="Username..." name="username" required>
                </div>

                <div class="auth__field">
                    <label for="email">Email</label>
                    <input id="email" type="email" placeholder="Email..." name="email" required>
                </div>

                <div class="auth__field">
                    <label for="psw">Parolă</label>
                    <input id="psw" type="password" placeholder="Parola..." name="psw" minlength="8" required>
                </div>


                <div class="auth__field">
                    <label for="psw_confirm">Confirmă parolă</label>
                    <input id="psw_confirm" type="password" placeholder="Confirma parola..." name="psw_confirm" minlength="8" required>
                </div>

                <button type="submit" class="btn btn--primary auth__submit">Înregistrează-te!</button>

                <p class="auth__alt">
                    Ai cont deja? <a href="/login.php">Loghează-te</a>
                </p>
            </form>
        </div>
    </section>


<?php 
    require __DIR__ . '/../templates/footer.php';
?>