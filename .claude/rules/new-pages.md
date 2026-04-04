# Adding New Pages

Checklist when creating a new HTML page:

1. Create the `.html` file with the standard `<head>` block:
   - charset, viewport meta tags
   - PWA tags: `<link rel="manifest">`, `<meta name="theme-color">`, apple-touch-icon, favicons, apple meta tags
   - Google Fonts link
   - Bootstrap Icons CSS
   - `/src/styles/main.scss` stylesheet

2. Include shared components:
   - `<div id="navbar-root"></div>` + `<script type="module" src="/src/js/navbar.js"></script>`
   - `<div id="footer-root"></div>` + `<script type="module" src="/src/js/footer.js"></script>`

3. Add SW registration before `</body>`:
   ```html
   <script>
     if ('serviceWorker' in navigator) {
       navigator.serviceWorker.register('/sw.js');
     }
   </script>
   ```

4. Register the page in `vite.config.js` under `build.rollupOptions.input`

5. Add navigation link in `src/js/navbar.js` if needed
