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
('Top 10 Sách Nên Đọc Năm 2024', 'Nội dung chi tiết về danh sách 10 cuốn sách hay nhất hội tụ đủ các yếu tố từ cốt truyện đến bài học nhân sinh...', 'Danh sách những cuốn sách không thể bỏ qua trong năm nay.', 'Khang Admin', 'sách hay 2024, top sách, review sách', 'Khám phá top 10 cuốn sách đáng đọc nhất năm 2024 tại BookStore Premium.', '1777903201_7fb5bbde1db4e7e180c41963b1c78b30.jpg'),
('Lợi ích của việc đọc sách mỗi ngày', 'Đọc sách không chỉ giúp chúng ta mở mang kiến thức mà còn giúp giảm căng thẳng, cải thiện trí nhớ...', 'Tại sao bạn nên dành ít nhất 30 phút mỗi ngày để đọc sách?', 'Khang Admin', 'lợi ích đọc sách, thói quen đọc sách', 'Tìm hiểu những lợi ích bất ngờ của việc duy trì thói quen đọc sách mỗi ngày.', '1777903462_z7772420522673_90661c8200ee13cf110dda294d934fea.jpg');

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
('Cách Nghĩ Để Thành Công', 'Napoleon Hill', 'Bí quyết thành công từ những người giàu có và thành đạt nhất thế giới.', 110000, 25, 'Kỹ năng sống', 'think.jpg');
