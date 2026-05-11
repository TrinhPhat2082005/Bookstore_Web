# Tài liệu hướng dẫn Controller - Bookstore Web

Tài liệu này chi tiết về cấu trúc và logic xử lý của các Controller trong thư mục `app/controllers`.

---

## 1. AdminController.php
**Vai trò**: Quản lý toàn bộ chức năng dành cho quản trị viên (Admin Dashboard, sản phẩm, đơn hàng, người dùng, tin tức...).

| Hàm | Tác dụng | Logic xử lý |
| :--- | :--- | :--- |
| `__construct()` | Khởi tạo Controller | Kiểm tra quyền Admin (session). Nếu không phải Admin, chuyển hướng về trang login. Khởi tạo các Model cần thiết và kiểm tra CSRF cho mọi yêu cầu POST. |
| `index()` | Trang Dashboard | Thống kê số lượng user, đơn hàng, doanh thu. Lấy các thông báo mới nhất (đơn hàng mới, user mới) và dữ liệu biểu đồ doanh thu 7 ngày qua. |
| `manageUsers()` | Quản lý người dùng | Hiển thị danh sách user (phân trang). Xử lý các hành động: khóa/mở khóa tài khoản, reset mật khẩu, xóa user. |
| `manageInfo()` | Cài đặt website | Quản lý các thông tin cấu hình website (tên shop, email, số điện thoại, địa chỉ, mạng xã hội...). |
| `manageContacts()` | Quản lý liên hệ | Hiển thị các tin nhắn từ khách hàng gửi qua form liên hệ. Cho phép đánh giá trạng thái đã xử lý hoặc xóa. |
| `manageProducts()` | Danh sách sản phẩm | Hiển thị toàn bộ sách trong hệ thống. Hỗ trợ tìm kiếm và lọc. |
| `addProduct()` | Thêm sản phẩm mới | Hiển thị form và xử lý lưu dữ liệu sản phẩm mới (tên sách, giá, tác giả, mô tả, hình ảnh). |
| `editProduct($id)` | Sửa sản phẩm | Lấy thông tin sản phẩm theo ID và cập nhật các thay đổi từ quản trị viên. |
| `manageOrders()` | Quản lý đơn hàng | Danh sách các đơn đặt hàng. Hỗ trợ cập nhật trạng thái đơn hàng (đang xử lý, đã giao, đã hủy). |
| `viewOrder($id)` | Chi tiết đơn hàng | Xem thông tin chi tiết một đơn hàng cụ thể bao gồm danh sách các cuốn sách đã mua. |
| `manageNews()` | Quản lý bài viết | Danh sách các bài viết/tin tức trên website. |
| `addNews()` / `editNews()` | Thêm/Sửa bài viết | Xử lý nội dung bài viết, tiêu đề và hình ảnh đại diện cho tin tức. |
| `manageComments()` | Quản lý bình luận | Kiểm duyệt các bình luận của người dùng trên bài viết. Cho phép ẩn hoặc xóa bình luận không phù hợp. |
| `manageFaq()` | Quản lý FAQ | Danh sách các câu hỏi thường gặp. |
| `addFaq()` / `editFaq()` | Thêm/Sửa FAQ | Quản lý các cặp câu hỏi - câu trả lời để hiển thị ở trang hỗ trợ khách hàng. |

---

## 2. AuthController.php
**Vai trò**: Xử lý xác thực người dùng (Đăng nhập, Đăng ký, Đăng xuất, Hồ sơ cá nhân).

| Hàm | Tác dụng | Logic xử lý |
| :--- | :--- | :--- |
| `login()` | Đăng nhập | Kiểm tra thông tin người dùng gửi lên. Nếu đúng, lưu thông tin vào `$_SESSION`. Hỗ trợ chức năng "Remember Me" bằng Cookie. |
| `register()` | Đăng ký | Kiểm tra trùng lặp username/email. Mã hóa mật khẩu và tạo tài khoản mới trong Database. |
| `profile()` | Thông tin cá nhân | Hiển thị thông tin user đang đăng nhập và lịch sử mua hàng. Xử lý cập nhật thông tin cá nhân và đổi mật khẩu. |
| `orderDetail($id)` | Chi tiết đơn hàng cá nhân | (AJAX) Trả về dữ liệu JSON chi tiết các sản phẩm trong một đơn hàng của user. |
| `logout()` | Đăng xuất | Hủy bỏ `$_SESSION`, xóa Cookie "Remember Me" trong database và trình duyệt, sau đó chuyển hướng về trang chủ. |

---

## 3. CartController.php
**Vai trò**: Quản lý giỏ hàng và quy trình đặt hàng (Checkout).

| Hàm | Tác dụng | Logic xử lý |
| :--- | :--- | :--- |
| `__construct()` | Khởi tạo giỏ hàng | Đảm bảo mảng `$_SESSION['cart']` luôn tồn tại. |
| `index()` | Xem giỏ hàng | Tính toán tổng tiền và hiển thị danh sách sản phẩm đang có trong giỏ. |
| `add($id)` | Thêm vào giỏ | Lấy thông tin sản phẩm từ Model. Nếu đã có trong giỏ thì tăng số lượng, nếu chưa thì thêm mới. Hỗ trợ cả request thường và AJAX. |
| `update()` | Cập nhật số lượng | Xử lý cập nhật số lượng hàng loạt từ form giỏ hàng. |
| `remove($id)` | Xóa sản phẩm | Loại bỏ một sản phẩm cụ thể ra khỏi giỏ hàng. |
| `clear()` | Làm trống giỏ | Xóa toàn bộ sản phẩm trong `$_SESSION['cart']`. |
| `checkout()` | Thanh toán | Hiển thị form thông tin giao hàng (tự điền nếu đã login). Khi submit: Kiểm tra dữ liệu -> Tạo đơn hàng trong DB -> Lưu chi tiết đơn hàng -> Làm trống giỏ -> Chuyển đến trang thành công. |
| `success($order_id)` | Hoàn tất | Hiển thị thông báo đặt hàng thành công và thông tin đơn hàng vừa tạo. |

---

## 4. HomeController.php
**Vai trò**: Điều khiển các trang giao diện chính của khách hàng (Trang chủ, Giới thiệu, Liên hệ).

| Hàm | Tác dụng | Logic xử lý |
| :--- | :--- | :--- |
| `index()` | Trang chủ | Lấy danh sách sách mới nhất, sách nổi bật và bài viết mới để hiển thị cho người dùng. |
| `about()` | Giới thiệu | Hiển thị trang giới thiệu về hiệu sách. |
| `contact()` | Liên hệ | Hiển thị form liên hệ. Nếu là yêu cầu POST, lưu tin nhắn của khách hàng vào database. |
| `faq()` | Hỏi đáp | Lấy toàn bộ danh sách câu hỏi thường gặp từ Model và hiển thị. |

---

## 5. NewsController.php
**Vai trò**: Quản lý hiển thị tin tức và bình luận.

| Hàm | Tác dụng | Logic xử lý |
| :--- | :--- | :--- |
| `index()` | Danh sách tin tức | Hiển thị toàn bộ các bài viết (có phân trang). |
| `detail($id)` | Chi tiết bài viết | Hiển thị nội dung một bài viết cụ thể và danh sách các bình luận liên quan. |
| `comment($id)` | Gửi bình luận | Xử lý lưu bình luận của người dùng cho bài viết (yêu cầu đăng nhập). |

---

## 6. ProductController.php
**Vai trò**: Quản lý hiển thị sản phẩm (Sách).

| Hàm | Tác dụng | Logic xử lý |
| :--- | :--- | :--- |
| `index()` | Danh sách sản phẩm | Hiển thị toàn bộ sách. Hỗ trợ lọc theo danh mục hoặc tìm kiếm theo tên sách/tác giả. |
| `detail($id)` | Chi tiết sách | Hiển thị thông tin đầy đủ về một cuốn sách và gợi ý các cuốn sách cùng thể loại. |
| `search_api()` | API tìm kiếm | (AJAX) Trả về kết quả tìm kiếm nhanh dưới dạng JSON để hiển thị gợi ý trên thanh tìm kiếm. |
