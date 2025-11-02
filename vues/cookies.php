<?php

$accepted = $_COOKIE['cookies_accepted'] ?? null;
if ($accepted !== null) {
    return;
}
?>
<style>
    #cookie-banner{position:fixed;left:0;right:0;bottom:0;background:#222;color:#fff;padding:14px 16px;display:flex;gap:12px;align-items:center;justify-content:space-between;z-index:9999;font-family:Arial,Helvetica,sans-serif}
    #cookie-banner .message{max-width:70ch;font-size:0.95rem}
    #cookie-banner .actions{display:flex;gap:8px}
    #cookie-banner input[type=submit]{background:#2ecc71;color:#fff;border:0;padding:8px 12px;border-radius:4px;cursor:pointer}
    #cookie-banner .decline{background:#e74c3c}
    @media(max-width:600px){#cookie-banner{flex-direction:column;align-items:flex-start}}
</style>

<div id="cookie-banner" role="dialog" aria-live="polite">
    <div class="message">
        <strong>Nous utilisons des cookies</strong>
        <div style="margin-top:6px;opacity:0.95">
            Ce site utilise des cookies pour améliorer votre expérience. En acceptant, vous autorisez l'utilisation de cookies de fonction et d'analyse.
            Voir notre <a href="/politique-cookies.html" style="color:#fff;text-decoration:underline">politique de cookies</a> pour plus d'informations.
        </div>
    </div>
    <div class="actions">
        <form method="post" action="index.php?page=cookies" style="display:inline;margin:0">
            <input type="hidden" name="accept" value="1">
            <input type="submit" value="Accepter">
        </form>
        <form method="post" action="index.php?page=cookies" style="display:inline;margin:0">
            <input type="hidden" name="decline" value="1">
            <input type="submit" value="Refuser" class="decline">
        </form>
    </div>
</div>
