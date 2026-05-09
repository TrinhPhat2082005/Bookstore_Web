# Danh sách công việc (Task List) - Bookstore Web Project

## 1. Bảo mật & Phân quyền (Security & Authorization)
- [x] **CSRF Protection:** Integrated CSRF token protection for all forms (Login, Register, Profile, Admin, Cart, News, Contact).
- [x] **XSS Sanitization:** Implemented global sanitization for user-generated content and CKEditor inputs.
- [x] **Admin Authorization:** AdminController now verifies admin roles.

## 2. Admin UI/UX Upgrade
- [x] **Dropzone.js Integration:** Professional drag-and-drop file uploads for products.
- [x] **Content Management:** CKEditor integration with XSS protection.

## 3. Client Experience (UX/UI)
- [x] **Reveal Animations:** AOS (Animate On Scroll) integrated for dynamic reveals.
- [x] **Carousels:** Swiper.js used for Hero Slider and Related Products.
- [x] **AJAX Cart:** Real-time add-to-cart with CSRF protection and toast notifications.
- [x] **Image Sync:** Consistent image paths across all views (`uploads/`).

## 4. Pending Tasks
- [ ] **Database Migration:** Ensure final SQL updates are applied for news content.
- [ ] **Email Notifications:** (Optional) Implement order confirmation emails.
