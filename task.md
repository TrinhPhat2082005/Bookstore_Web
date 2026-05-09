# Danh sách công việc (Task List) - Bookstore Web Project

Dưới đây là tóm tắt các phần chưa thực hiện hoặc còn tồn tại lỗi/thiếu sót cần được xử lý trong hệ thống.

## 1. Bảo mật & Phân quyền (Security & Authorization)
- [ ] **Bảo vệ trang Admin:** Hiện tại `AdminController.php` chưa có đoạn mã kiểm tra quyền Admin ở hàm `__construct`. Bất kỳ ai cũng có thể truy cập `/admin` nếu biết URL.
- [ ] **Kiểm tra Session:** Đảm bảo người dùng phải đăng nhập mới có thể thực hiện các thao tác như đặt hàng hoặc vào hồ sơ cá nhân.

## 2. Quản lý Người dùng (User Management)
- [ ] **Giao diện Admin:** Phương thức `AdminController::users()` còn trống, chưa có giao diện liệt kê danh sách người dùng.
- [ ] **Các tính năng Model User:** Các hàm sau trong `User.php` mới chỉ có khung (stub), chưa có logic thực tế:
    - `updateProfile($id, $data)`
    - `changePassword($id, $new_password)`
    - `banUser($id)`
    - `resetPassword($id)`

## 3. Chức năng Thành viên (Client Features)
- [ ] **Trang Hồ sơ cá nhân:** `AuthController::profile()` chưa được hiện thực. Người dùng chưa thể xem hoặc sửa thông tin cá nhân.
- [ ] **Đổi mật khẩu:** Chưa có giao diện và logic để người dùng tự đổi mật khẩu.

## 4. Kiểm tra & Tối ưu (Validation & Optimization)
- [ ] **Đồng bộ Validation:** Đảm bảo mọi form nhập liệu (đặc biệt là đổi mật khẩu sau này) đều áp dụng quy tắc mật khẩu mới (5-20 ký tự, có chữ và số, không bắt buộc chữ hoa).
- [ ] **Xử lý ảnh:** Một số sản phẩm hoặc bài viết nếu không có ảnh cần hiển thị ảnh mặc định (no-image.jpg) để tránh lỗi giao diện.

## 5. Dữ liệu (Database)
- [ ] **Đồng bộ Database:** File `db/phat_db.sql` đã được cập nhật ảnh mẫu, nhưng cần đảm bảo người dùng đã Import bản mới nhất để thấy kết quả.

---
*Ghi chú: Các phần được đánh dấu "CHUNG" trong mã nguồn là những phần đang chờ được hoàn thiện.*
