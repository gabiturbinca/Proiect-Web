    </main>

    <footer class="site-footer">
        <div class="site-footer__grid">

            <div class="site-footer__about">
                <h2 class="site-footer__title">Gift Manager</h2>
                <p>Your digital assistant for finding the perfect gift.</p>
            </div>

            <nav class="site-footer__nav" aria-label="About the project">
                <h3>About</h3>
                <ul>
                    <li><a href="/">About the project</a></li>
                    <li><a href="/">Documentation</a></li>
                </ul>
            </nav>

            <nav class="site-footer__nav" aria-label="Resources project">
                <h3>Resources</h3>
                <ul>
                    <li><a href="https://github.com/gabiturbinca/Proiect-Web" rel="external">GitHub</a></li>
                  
                </ul>
            </nav>

        </div>

        <div class="site-footer__bottom">
            <p>&copy; <?= date('Y') ?> Gift Manager — Project Tehnologii Web 2026.</p>
        </div>
    </footer>

    <script src="/js/api.js"></script>
    <script src="/js/main.js"></script>
     <?php if($page_js): ?>
        <script src="/js/pages/<?= htmlspecialchars($page_js)?>.js"></script>
    <?php endif; ?>
</body>
</html>
