# Shelly 404 – TryHackMe Room

## Flags
- SQLi → Admin → `THM{SQLI_WIN_9f1}`
- XSS (reflected) → `THM{XSS_GLINT_28b}`
- Insecure upload → execute uploaded file → `THM{UPLOAD_PWN_4c2}`
- IDOR on profiles → admin profile → `THM{IDOR_KEYS_77e}`

## OWASP Top 10 Mapping
- A01: Broken Access Control → `admin.php` trusts cookies / `?as=admin` switch; `index.php?debug=1`
- A03: Injection (SQLi) → `login.php`
- A07: Identification & Auth Failures → weak cookie “session”, role spoofing
- A03/A05: XSS (reflected) → `search.php`
- A08: Software & Data Integrity (loosely) / A05 Security Misconfig → `uploads/.htaccess` enabling PHP in uploads

## Walkthrough (high-level)
1. **Recon**: Discover links and `index.php?debug=1` hint.
2. **SQLi**: `username=admin' --` with any password OR `' OR '1'='1` to bypass → cookie set as admin → admin page shows flag.
3. **XSS**: `search.php?q=<script>/*x*/</script>` → script runs → page prints XSS flag.
4. **Upload**: Upload `poster.php.jpg` containing `<?php echo 'FLAG: THM{UPLOAD_PWN_4c2}'; ?>` → open `/uploads/poster.php.jpg` and observe execution.
5. **IDOR**: `profile.php?id=1` reveals admin profile + flag.

> Replace this with your step-by-step screenshots, reflections, and diagrams for full marks.
