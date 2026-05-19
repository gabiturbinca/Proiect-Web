<?php
    $page_title = 'Giw — Acasă';
    $page_css   = 'auth';
    $page_js = 'login';
    require __DIR__ . '/../templates/header.php';
?>

     <section class="auth">
        <div class="auth__brand" aria-hidden="true">
            <img src="/images/logo_hero_section.png" alt="" class="auth__brand-logo">
            <p class="auth__brand-tagline">Asistent digital pentru alegerea cadoului perfect.</p>
        </div>

        <div class="auth__content">
            <div class="auth__header">
                <h1>Loghează-te:</h1>
                <h2>Bine ai revenit! Caută cadouri pentru cei dragi cu ajutorul asistentului nostru digital.</h2>
            </div>

            <form class="auth__form" id="login_form">
                <div class="auth__field">
                    <label for="identifier">Username sau email</label>
                    <input id="identifier" type="text" placeholder="Username or email..." name="identifier" required>
                </div>

                <div class="auth__field">
                    <label for="password">Parolă</label>
                    <input id="password" type="password" placeholder="Parola..." name="password" minlength="8" required>
                </div>
                 <span id="message__invalid_credentials"></span>
                <button type="submit" class="btn btn--primary auth__submit">Loghează-te!</button>

                <p class="auth__alt">
                    Nu ai cont încă? <a href="/register.php">Înregistrează-te</a>
                </p>
            </form>
        </div>
    </section>

<?php 
    require __DIR__ . '/../templates/footer.php';
?>