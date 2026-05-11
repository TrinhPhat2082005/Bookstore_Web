# Tài liệu hướng dẫn Model - Bookstore Web

Tài liệu này chi tiết về cấu trúc, ý nghĩa và logic xử lý của các Model trong thư mục `app/models`. Các Model chịu trách nhiệm tương tác trực tiếp với cơ sở dữ liệu thông qua lớp `Database`.

---

## 1. User.php
**Vai trò**: Quản lý thông tin người dùng, xác thực và phân quyền.

| Hàm | Tác dụng | Logic xử lý |
| :--- | :--- | :--- |
| `login()` | Xác thực đăng nhập | Tìm user theo username và role. Sử dụng `password_verify` để kiểm tra mật khẩu đã mã hóa. |
| `register()` | Đăng ký tài khoản | Mã hóa mật khẩu bằng `password_hash` và lưu thông tin user mới với role mặc định là 'client'. |
| `findUserByUsername()` / `findUserByEmail()` | Tìm kiếm user | Kiểm tra sự tồn tại của username hoặc email trong DB (dùng để validate khi đăng ký/đổi thông tin). |
| `getUserById()` | Lấy thông tin chi tiết | Truy vấn toàn bộ thông tin của một user dựa trên ID. |
| `updateProfile()` | Cập nhật hồ sơ | Thay đổi email, họ tên, số điện thoại và địa chỉ của người dùng. |
| `changePassword()` | Đổi mật khẩu | Mã hóa mật khẩu mới và cập nhật vào database. |
| `getAll()` | Danh sách user (Admin) | Lấy danh sách người dùng có phân trang và sắp xếp theo thời gian tạo mới nhất. |
| `toggleStatus()` | Khóa/Mở khóa tài khoản | Đảo ngược trạng thái từ 'active' sang 'banned' và ngược lại. |
| `resetPassword()` | Đặt lại mật khẩu | Admin đặt lại mật khẩu mặc định (user123) cho người dùng. |
| `deleteUser()` | Xóa tài khoản | Xóa hoàn toàn bản ghi người dùng khỏi database. |
| `countAll()` | Đếm tổng số user | Trả về số lượng người dùng (dùng cho phân trang và thống kê Dashboard). |
| `updateRememberToken()` | Lưu token đăng nhập | Lưu chuỗi token ngẫu nhiên phục vụ tính năng "Ghi nhớ đăng nhập". |
| `getUserByRememberToken()` | Tìm user qua Cookie | Lấy thông tin user dựa trên token lưu trong Cookie của trình duyệt. |
| `getLatest()` | User mới nhất | Lấy danh sách 5 người dùng mới đăng ký gần đây để hiển thị thông báo Dashboard. |

---

## 2. Product.php
**Vai trò**: Quản lý dữ liệu về sách, tìm kiếm và bộ lọc sản phẩm.

| Hàm | Tác dụng | Logic xử lý |
| :--- | :--- | :--- |
| `getAll()` | Lấy tất cả sách | Lấy danh sách sách có trạng thái 'active'. |
| `getFilteredProducts()` | Bộ lọc nâng cao | Xây dựng câu lệnh SQL động dựa trên: từ khóa, danh mục, khoảng giá (xử lý thông minh đơn vị VNĐ), trạng thái kho hàng và sắp xếp. |
| `getLatest()` | Sách mới nhất | Lấy danh sách các cuốn sách vừa được thêm vào hệ thống. |
| `getById()` | Chi tiết sách | Lấy đầy đủ thông tin một cuốn sách theo ID. |
| `searchByKeyword()` | Tìm kiếm nhanh | Tìm sách theo tên, tác giả hoặc mô tả bằng toán tử `LIKE`. |
| `getByCategory()` | Lọc theo danh mục | Lấy danh sách sách thuộc một thể loại cụ thể. |
| `getCategories()` | Lấy các thể loại | Lấy danh sách các danh mục duy nhất (`DISTINCT`) đang có trong DB. |
| `getAllAdmin()` | Quản lý sách (Admin) | Lấy danh sách toàn bộ sách (kể cả sách bị ẩn) có phân trang. |
| `add()` / `update()` | Thêm/Sửa sách | Xử lý lưu các trường dữ liệu: tên, tác giả, mô tả, giá, kho, ảnh, danh mục. |
| `delete()` | Xóa sách | Xóa bản ghi sách khỏi hệ thống. |

---

## 3. Order.php
**Vai trò**: Xử lý đơn hàng và chi tiết đơn hàng (giỏ hàng).

| Hàm | Tác dụng | Logic xử lý |
| :--- | :--- | :--- |
| `create()` | Tạo đơn hàng mới | Quy trình: 1. Chèn thông tin khách hàng vào bảng `orders` -> 2. Lấy ID vừa tạo (`LAST_INSERT_ID`) -> 3. Lặp qua giỏ hàng để chèn từng sản phẩm vào bảng `order_items`. |
| `getByEmail()` | Lịch sử mua hàng | Tìm các đơn hàng dựa trên email khách hàng. |
| `getDetail()` | Thông tin đơn hàng | Lấy thông tin chung của đơn hàng (tên, địa chỉ, tổng tiền...). |
| `getItems()` | Sản phẩm trong đơn | Lấy danh sách các cuốn sách thuộc về một đơn hàng cụ thể (JOIN với bảng `products` để lấy tên và ảnh). |
| `getAll()` | Quản lý đơn hàng (Admin) | Danh sách đơn hàng có phân trang. |
| `updateStatus()` | Cập nhật trạng thái | Thay đổi trạng thái đơn hàng (pending, processing, delivered, cancelled). |
| `getTotalRevenue()` | Tính tổng doanh thu | Tính tổng tiền của các đơn hàng không bị hủy. |
| `getRevenueLast7Days()` | Thống kê doanh thu | Thống kê số tiền và số đơn hàng theo từng ngày trong 7 ngày gần nhất để vẽ biểu đồ. |

---

## 4. Article.php
**Vai trò**: Quản lý bài viết và tin tức.

| Hàm | Tác dụng | Logic xử lý |
| :--- | :--- | :--- |
| `getPublished()` | Lấy tin đã đăng | Lấy danh sách bài viết có trạng thái 'published'. |
| `getById()` | Chi tiết bài viết | Truy vấn một bài viết theo ID. |
| `add()` / `update()` | Thêm/Sửa bài viết | Quản lý tiêu đề, nội dung, tóm tắt, tác giả, ảnh và các trường SEO. |
| `delete()` | Xóa bài viết | Xóa bản ghi tin tức. |
| `incrementViews()` | Tăng lượt xem | Cập nhật số lượt xem mỗi khi có người đọc bài viết. |

---

## 5. Comment.php
**Vai trò**: Quản lý bình luận của người dùng trên bài viết.

| Hàm | Tác dụng | Logic xử lý |
| :--- | :--- | :--- |
| `add()` | Gửi bình luận | Lưu bình luận với trạng thái mặc định là 'pending' (chờ duyệt). |
| `getByArticle()` | Hiển thị bình luận | Lấy các bình luận đã được duyệt ('approved') của một bài viết. |
| `approve()` | Duyệt bình luận | Admin cho phép hiển thị bình luận lên web. |
| `delete()` | Xóa bình luận | Loại bỏ bình luận khỏi hệ thống. |

---

## 6. Contact.php
**Vai trò**: Lưu trữ và quản lý tin nhắn liên hệ từ khách hàng.

| Hàm | Tác dụng | Logic xử lý |
| :--- | :--- | :--- |
| `add()` | Lưu tin nhắn | Lưu tên, email, tiêu đề và nội dung từ form liên hệ. |
| `getAll()` | Danh sách liên hệ | Admin xem các tin nhắn khách hàng gửi đến. |
| `markAsRead()` | Đánh dấu đã đọc | Chuyển trạng thái tin nhắn để dễ quản lý. |

---

## 7. Faq.php
**Vai trò**: Quản lý danh sách các câu hỏi thường gặp.

| Hàm | Tác dụng | Logic xử lý |
| :--- | :--- | :--- |
| `getAll()` | Danh sách FAQ | Lấy toàn bộ câu hỏi và câu trả lời. |
| `add()` / `update()` / `delete()` | Quản lý FAQ | Các thao tác CRUD cơ bản cho dữ liệu câu hỏi - đáp. |

---

## 8. Setting.php
**Vai trò**: Quản lý các cấu hình hệ thống (Key-Value).

| Hàm | Tác dụng | Logic xử lý |
| :--- | :--- | :--- |
| `getAll()` | Lấy toàn bộ cài đặt | Trả về một mảng kết hợp (Associative Array) với key là tên cài đặt để dễ sử dụng trong code. |
| `update()` | Cập nhật cài đặt | Cập nhật giá trị dựa trên `setting_key`. |
| `getByKey()` | Lấy lẻ giá trị | Lấy một giá trị cấu hình duy nhất theo key chỉ định. |
