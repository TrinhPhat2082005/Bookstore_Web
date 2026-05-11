# Bookstore Web - Security Layer Guide

The `Security` class is the "guardian" of your application. It ensures that data entering and leaving the system is safe from the most common web attacks.

---

## 1. CSRF Protection (Cross-Site Request Forgery)
**Methods**: `csrfField()`, `verifyCSRFToken()`

### What does it do?
It prevents a hacker from tricking a logged-in admin into submitting a hidden form on your site. For example, if an admin visits a malicious site, that site could try to send a hidden request to `admin/deleteUser`.

### How it works:
1.  **Generation**: When an admin opens a form, `csrfField()` generates a unique, secret "token" (a long string of random letters and numbers) and puts it in a hidden input field.
2.  **Verification**: When the form is submitted, the controller checks if the token sent by the form matches the one stored in the admin's session.
3.  **The Result**: Only forms actually opened on your website can be submitted successfully.

---

## 2. XSS Protection (Cross-Site Scripting)
**Methods**: `xssClean()`, `renderText()`

### What does it do?
It prevents hackers from injecting malicious JavaScript into your pages. Without this, a hacker could post a comment like `<script>steal_cookies()</script>`, and anyone who reads that comment would have their data stolen.

### How it works:
- **`xssClean()`**: Converts special characters into HTML entities (e.g., `<` becomes `&lt;`). The browser will display the `<` character but will **not** execute it as a tag.
- **`renderText()`**: This is our "Premium" text renderer. It escapes the text for safety and then applies `nl2br()` to preserve line breaks from textareas.

---

## 3. HTML Sanitization (For Rich Text)
**Method**: `sanitizeHTML()`

### What does it do?
Sometimes you *want* to allow HTML (like Bold, Italic, or Lists from CKEditor), but you still want to block dangerous tags like `<script>` or `<iframe>`.

### How it works:
1.  **Allowed List**: It keeps a list of "safe" tags (like `<b>`, `<i>`, `<p>`).
2.  **The Strip**: It removes every tag that isn't on the safe list.
3.  **Attribute Scrubbing**: It scans for "event handlers" like `onclick` or `onerror` which can be used to hide malicious code inside safe tags, and deletes them.

---

## Summary: When to use what?

| Content Type | Security Method | Purpose |
| :--- | :--- | :--- |
| **Simple Strings** (Names, Titles) | `xssClean()` | Simple escaping before echoing. |
| **User Paragraphs** (Bio, Feedback) | `renderText()` | Escaping + preserving line breaks. |
| **Admin Content** (Blog Posts) | `sanitizeHTML()` | Allowing formatting but blocking scripts. |
| **All POST Forms** | `csrfField()` | Preventing unauthorized submissions. |
