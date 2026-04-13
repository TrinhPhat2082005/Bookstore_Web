# Bookstore Web Application

Chào mừng bạn đến với dự án **Bookstore Web**, một ứng dụng web quản lý và bán sách trực tuyến được xây dựng dựa trên mô hình MVC (Model-View-Controller) sử dụng ngôn ngữ PHP.

## 📌 Tổng quan dự án
Dự án này được phát triển nhằm cung cấp một giải pháp thương mại điện tử đơn giản cho việc mua bán sách, hỗ trợ quản lý kho hàng, khách hàng và đơn hàng một cách hiệu quả.

## 🚀 Tính năng chính
- **Người dùng:**
    - Đăng ký, đăng nhập và quản lý tài khoản.
    - Tìm kiếm và xem thông tin chi tiết sách.
    - Thêm sách vào giỏ hàng và đặt hàng.
    - Theo dõi lịch sử đơn hàng.
- **Quản trị viên (Admin):**
    - Quản lý danh mục sách và thông tin sách.
    - Quản lý đơn hàng và trạng thái vận chuyển.
    - Quản lý người dùng.

## 📂 Cấu trúc thư mục
Dự án tuân thủ cấu trúc MVC chuẩn:
- `app/`: Chứa logic cốt lõi của ứng dụng.
    - `controllers/`: Xử lý yêu cầu và điều phối dữ liệu.
    - `models/`: Tương tác với cơ sở dữ liệu.
    - `views/`: Giao diện hiển thị cho người dùng.
    - `core/`: Các lớp cốt lõi của framework (Router, Controller, Database).
- `config/`: Các tệp cấu hình (Database connect, Base URL).
- `db/`: Chứa các bản sao lưu cơ sở dữ liệu (`.sql`).
- `public/`: Thư mục công khai duy nhất được truy cập từ web.
    - `css/`, `js/`, `images/`: Các tệp tài nguyên tĩnh.
    - `index.php`: Điểm vào (Entry point) của ứng dụng.

## 🛠️ Công nghệ sử dụng
- **Ngôn ngữ:** PHP 8+
- **Cơ sở dữ liệu:** MySQL
- **Giao diện:** HTML5, CSS3 (Vanilla CSS), JavaScript
- **Kiến trúc:** Model-View-Controller (MVC)

## 💻 Hướng dẫn cài đặt
1. **Clone dự án:**
   ```bash
   git clone https://github.com/TrinhPhat2082005/Bookstore_Web.git
   ```
2. **Cấu hình Cơ sở dữ liệu:**
   - Tạo cơ sở dữ liệu có tên `bookstore_db` trong MySQL.
   - Import tệp `db/phat_db.sql` vào cơ sở dữ liệu vừa tạo.
3. **Cập nhật cấu hình:**
   - Mở tệp `config/config.php` và cập nhật thông tin kết nối DB (User, Password, Host).
4. **Chạy ứng dụng:**
   - Sử dụng máy chủ XAMPP/WAMP hoặc PHP Built-in Server.
   - Truy cập qua trình duyệt: `http://localhost/bookstore_web/public/`

## 👥 Nhóm phát triển
- **Lê Trình Phát**
- **Tâm**
- **Khang**

---
*Dự án Bài tập lớn - Môn Lập trình Web - HK252*
