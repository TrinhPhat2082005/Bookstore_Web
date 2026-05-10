CREATE DATABASE IF NOT EXISTS bookstore_db;
USE bookstore_db;

-- Table for users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'client') DEFAULT 'client',
    remember_token VARCHAR(255) NULL,
    status ENUM('active', 'banned') DEFAULT 'active',
    full_name VARCHAR(255),
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Default admin user (password: admin123)
INSERT IGNORE INTO users (username, email, password, role) VALUES 
('admin', 'admin@bookstore.vn', '$2y$10$J7/pFo7LDOao.aYIaMrodOaQoo9.8OpzQw9.Nd/KBMKBAZsYARn.K', 'admin');

-- Ensure missing columns are added if table already exists
ALTER TABLE users ADD COLUMN IF NOT EXISTS remember_token VARCHAR(255) NULL AFTER role;
ALTER TABLE users ADD COLUMN IF NOT EXISTS status ENUM('active', 'banned') DEFAULT 'active' AFTER remember_token;
ALTER TABLE users ADD COLUMN IF NOT EXISTS full_name VARCHAR(255) AFTER status;
ALTER TABLE users ADD COLUMN IF NOT EXISTS phone VARCHAR(20) AFTER full_name;
ALTER TABLE users ADD COLUMN IF NOT EXISTS address TEXT AFTER phone;

-- ============================================================
-- SQL for PHÁT's tasks
-- ============================================================

-- Table for customer contacts
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255),
    message TEXT NOT NULL,
    status ENUM('unread', 'read', 'replied') DEFAULT 'unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for website settings (Logo, Address, Phone, Intro)
CREATE TABLE IF NOT EXISTS settings (
    setting_key VARCHAR(50) PRIMARY KEY,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Initial settings
INSERT IGNORE INTO settings (setting_key, setting_value) VALUES
('site_name', 'BookStore Premium'),
('site_logo', 'logo.png'),
('site_intro', 'Chào mừng bạn đến với hiệu sách trực tuyến hàng đầu.'),
('site_address', '123 Đường ABC, Quận 1, TP.HCM'),
('site_phone', '0123 456 789'),
('site_email', 'contact@bookstore.vn'),
('about_content', 'Chúng tôi là cửa hàng sách lâu đời với sứ mệnh mang tri thức đến mọi người...');

-- ============================================================
-- SQL for KHANG's tasks
-- ============================================================

-- Table for articles/news
CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    summary TEXT,
    author VARCHAR(100),
    image VARCHAR(255),
    seo_keywords VARCHAR(255),
    seo_description VARCHAR(255),
    status ENUM('draft', 'published') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for article comments
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    name VARCHAR(255),
    content TEXT NOT NULL,
    status ENUM('pending', 'approved', 'hidden') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE
);

-- Table for FAQ
CREATE TABLE IF NOT EXISTS faqs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    answer TEXT NOT NULL,
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample articles
INSERT IGNORE INTO articles (title, content, summary, author, seo_keywords, seo_description, image) VALUES
('Top 10 Sách Nên Đọc Năm 2024', 'Nội dung chi tiết về danh sách 10 cuốn sách hay nhất hội tụ đủ các yếu tố từ cốt truyện đến bài học nhân sinh...', 'Danh sách những cuốn sách không thể bỏ qua trong năm nay.', 'Khang Admin', 'sách hay 2024, top sách, review sách', 'Khám phá top 10 cuốn sách đáng đọc nhất năm 2024 tại BookStore Premium.', '1778335770_sachgiay.jpg'),
('Lợi ích của việc đọc sách mỗi ngày', 'Đọc sách không chỉ giúp chúng ta mở mang kiến thức mà còn giúp giảm căng thẳng, cải thiện trí nhớ...', 'Tại sao bạn nên dành ít nhất 30 phút mỗi ngày để đọc sách?', 'Khang Admin', 'lợi ích đọc sách, thói quen đọc sách', 'Tìm hiểu những lợi ích bất ngờ của việc duy trì thói quen đọc sách mỗi ngày.', '1777903462_z7772420522673_90661c8200ee13cf110dda294d934fea.jpg'),
('Tương lai của ngành xuất bản: Trí tuệ nhân tạo đang thay đổi cuộc chơi như thế nào?', 'Bước sang năm 2025, trí tuệ nhân tạo (AI) không còn là khái niệm xa lạ trong giới cầm bút. Từ việc hỗ trợ lên ý tưởng, kiểm tra lỗi ngữ pháp đến việc phân tích thị hiếu người đọc, AI đang trở thành người bạn đồng hành đắc lực của các tác giả...', 'Khám phá sự kết hợp giữa sức sáng tạo của con người và sức mạnh của AI trong việc tạo ra những tác phẩm văn học thế hệ mới.', 'Phat Admin', 'AI xuất bản, tương lai ngành sách, công nghệ văn học', 'Tìm hiểu cách AI đang định hình lại ngành xuất bản thế giới trong năm 2025.', '1778336138_AI.jpg'),
('Sách giấy hồi sinh mạnh mẽ trong kỷ nguyên số', 'Dù ebook và audiobooks phát triển vượt bậc, doanh số sách in vẫn đạt kỷ lục vào năm 2024. Độc giả chia sẻ rằng cảm giác được chạm vào từng trang giấy, mùi hương của sách mới và việc không bị làm phiền bởi thông báo điện thoại là những lý do khiến họ chọn sách giấy...', 'Tại sao độc giả hiện đại lại đang có xu hướng quay trở lại với những trang sách thơm mùi mực in?', 'Phat Admin', 'sách giấy, xu hướng đọc sách, văn hóa đọc', 'Lý do tại sao sách giấy vẫn giữ vững vị thế và hồi sinh mạnh mẽ giữa thời đại công nghệ.', '1778336199_doc-sach-giay-hay-sach-dien-tu(1).jpg'),
('Xu hướng "Cozy Fantasy" - Khi độc giả tìm kiếm sự bình yên qua những trang sách', 'Khác với những cuộc chiến khốc liệt hay những âm mưu đen tối trong các bộ sử thi đồ sộ, Cozy Fantasy mang đến những câu chuyện về tình bạn, những quán trà nhỏ trong thế giới phép thuật hay những chuyến phiêu lưu nhẹ nhàng với kết thúc có hậu...', 'Tìm hiểu về dòng sách giả tưởng nhẹ nhàng đang chiếm trọn trái tim của hàng triệu độc giả trên toàn thế giới.', 'Phat Admin', 'Cozy Fantasy, sách giả tưởng nhẹ nhàng, xu hướng sách 2025', 'Khám phá sức hút của dòng sách Cozy Fantasy - liều thuốc tinh thần cho độc giả hiện đại.', '1778336417_Cozy_Fantasy_Romance_Book_List_F.webp'),
('Top 5 cuốn sách đáng mong chờ nhất năm 2025', 'Năm 2025 hứa hẹn sẽ là một năm bùng nổ của thị trường sách với sự trở lại của nhiều tên tuổi lớn. Đứng đầu danh sách là tác phẩm mới của Katie Kitamura mang tên "Audition", một tiểu thuyết đầy ám ảnh về danh tính và sự thật...', 'Danh sách những "siêu phẩm" văn học sắp ra mắt mà bạn không thể bỏ qua trong năm nay.', 'Phat Admin', 'sách hay 2025, top sách 2025, sách mới ra mắt', 'Điểm mặt 5 cuốn sách đình đám nhất dự kiến sẽ làm mưa làm gió trên các bảng xếp hạng năm 2025.', '1778336451_2025.webp'),
('Sách nói (Audiobook) - Giải pháp đọc sách cho người bận rộn', 'Với sự phát triển của các nền tảng phát trực tuyến và công nghệ giọng nói nhân tạo, sách nói đã trở thành một phần không thể thiếu trong cuộc sống hiện đại. Bạn có thể "đọc" sách khi đang lái xe, tập gym hay làm việc nhà...', 'Cách mà công nghệ âm thanh đang giúp chúng ta tiếp cận tri thức mọi lúc mọi nơi.', 'Phat Admin', 'audiobook, sách nói, công nghệ đọc sách', 'Khám phá lợi ích và sự phát triển vượt bậc của sách nói trong đời sống hiện đại.', '1778336492_sach-noi-mien-phi-1.webp');

-- Sample FAQ
INSERT IGNORE INTO faqs (question, answer, category) VALUES
('Làm thế nào để đặt hàng?', 'Bạn chỉ cần chọn sản phẩm, thêm vào giỏ hàng và điền thông tin thanh toán.', 'Mua hàng'),
('Cửa hàng có ship tỉnh không?', 'Chúng tôi giao hàng toàn quốc với thời gian từ 2-5 ngày làm việc.', 'Giao hàng');

-- ============================================================
-- SQL for TÂM's tasks
-- ============================================================

-- Table for products (books)
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    author VARCHAR(255),
    description TEXT,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0,
    stock INT NOT NULL DEFAULT 0,
    image VARCHAR(255),
    category VARCHAR(100),
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for orders
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    customer_email VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(20),
    customer_address TEXT,
    total_amount DECIMAL(10, 2) NOT NULL DEFAULT 0,
    note TEXT,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for order items
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Sample products data
INSERT IGNORE INTO products (name, author, description, price, stock, category, image) VALUES
('Đắc Nhân Tâm', 'Dale Carnegie', 'Cuốn sách kinh điển về nghệ thuật giao tiếp và ảnh hưởng đến người khác. Được xem là một trong cuốn sách hay nhất mọi thời đại.', 89000, 50, 'Kỹ năng sống', 'dac_nhan_tam.jpg'),
('Nhà Giả Kim', 'Paulo Coelho', 'Tiểu thuyết triết học nổi tiếng thế giới về hành trình tìm kiếm kho báu và khám phá bản thân.', 79000, 35, 'Văn học', 'nha_gia_kim.jpg'),
('Sapiens: Lược Sử Loài Người', 'Yuval Noah Harari', 'Khám phá lịch sử loài người từ thời tiền sử đến thời hiện đại với những góc nhìn mới mẻ và thú vị.', 145000, 28, 'Lịch sử', 'sapiens.webp'),
('Atomic Habits', 'James Clear', 'Phương pháp xây dựng thói quen tốt và loại bỏ thói quen xấu. Sách bán chạy nhất thế giới về phát triển bản thân.', 130000, 42, 'Kỹ năng sống', 'atomic_habits.jpeg'),
('Tư Duy Nhanh Và Chậm', 'Daniel Kahneman', 'Khám phá cách thức hoạt động của tâm trí con người qua hai hệ thống tư duy khác nhau.', 160000, 20, 'Tâm lý học', 'thinking_fast_and_slow.webp'),
('Dám Nghĩ Lớn', 'David J. Schwartz', 'Hướng dẫn cách tư duy thành công và đạt được những mục tiêu lớn trong cuộc sống.', 95000, 33, 'Kỹ năng sống', 'thinking.webp'),
('Hoàng Tử Bé', 'Antoine de Saint-Exupéry', 'Câu chuyện triết học dành cho mọi lứa tuổi về sự thuần khiết, tình bạn và ý nghĩa cuộc sống.', 65000, 60, 'Văn học', 'hoang_tu_be.png'),
('Cách Nghĩ Để Thành Công', 'Napoleon Hill', 'Bí quyết thành công từ những người giàu có và thành đạt nhất thế giới.', 110000, 25, 'Kỹ năng sống', 'think.jpg'),
('Mắt Biếc', 'Nguyễn Nhật Ánh', 'Câu chuyện tình yêu đầy nuối tiếc giữa Ngạn và Hà Lan tại làng Đo Đo.', 110000, 45, 'Văn học Việt Nam', 'mat_biec.jpeg'),
('Suối Nguồn', 'Ayn Rand', 'Tác phẩm kinh điển về sự đối đầu giữa cá nhân sáng tạo và số đông truyền thống.', 220000, 12, 'Văn học nước ngoài', 'suoi_nguon.webp'),
('Tôi Thấy Hoa Vàng Trên Cỏ Xanh', 'Nguyễn Nhật Ánh', 'Những mẩu chuyện nhỏ về tuổi thơ nghèo khó nhưng đầy ắp kỷ niệm ở làng quê.', 95000, 30, 'Văn học Việt Nam', 'toi_thay_hoa_vang.webp'),
('Sống Thực Tế Giữa Đời Thực Dụng', 'Mễ Mông', 'Cuốn sách dành cho những người trẻ đang loay hoay tìm hướng đi trong xã hội hiện đại.', 105000, 55, 'Kỹ năng sống', 'song_thuc_te.webp'),
('Đàn Ông Đến Từ Sao Hỏa, Đàn Bà Đến Từ Sao Kim', 'John Gray', 'Giải mã sự không khác biệt về tâm lý giữa nam và nữ để xây dựng mối quan hệ tốt đẹp.', 135000, 20, 'Tâm lý học', 'dan_ong_sao_hoa.webp'),
('Bắt Trẻ Đồng Xanh', 'J.D. Salinger', 'Hành trình nội tâm đầy nổi loạn của cậu thiếu niên Holden Caulfield.', 85000, 0, 'Văn học nước ngoài', 'bat_tre_dong_xanh.webp'),
('Kiếp Nào Ta Cũng Tìm Thấy Nhau', 'Brian L. Weiss', 'Khám phá về mối lương duyên tiền định và sự kết nối giữa các linh hồn qua thời gian.', 115000, 0, 'Tâm linh', 'kiep_nao_ta_cung.webp'),
('Đi Tìm Lẽ Sống', 'Viktor Frankl', 'Hành trình sinh tồn trong trại tập trung và bài học về ý nghĩa cuộc đời.', 90000, 0, 'Tâm lý học', 'di_tim_le_song.webp'),
('Không Gia Đình', 'Hector Malot', 'Cuộc phiêu lưu đầy nghị lực của cậu bé Remi trên khắp nước Pháp.', 140000, 0, 'Văn học nước ngoài', 'khong_gia_dinh.webp'),
('Chiến Thắng Con Quỷ Trong Bạn', 'Napoleon Hill', 'Cách vượt qua nỗi sợ hãi, sự trì trệ để đạt được mục tiêu cá nhân.', 120000, 0, 'Kỹ năng sống', 'chien_thang_con_quy.webp');
