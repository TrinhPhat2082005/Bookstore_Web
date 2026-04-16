CREATE DATABASE IF NOT EXISTS bookstore_db;
USE bookstore_db;

-- SQL for PHÁT's tasks

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
INSERT INTO settings (setting_key, setting_value) VALUES
('site_name', 'BookStore Premium'),
('site_logo', 'logo.png'),
('site_intro', 'Chào mừng bạn đến với hiệu sách trực tuyến hàng đầu.'),
('site_address', '123 Đường ABC, Quận 1, TP.HCM'),
('site_phone', '0123 456 789'),
('site_email', 'contact@bookstore.vn'),
('about_content', 'Chúng tôi là cửa hàng sách lâu đời với sứ mệnh mang tri thức đến mọi người...');

-- SQL for KHANG's tasks

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
INSERT INTO articles (title, content, summary, author, seo_keywords, seo_description) VALUES
('Top 10 Sách Nên Đọc Năm 2024', 'Nội dung chi tiết về danh sách 10 cuốn sách hay nhất hội tụ đủ các yếu tố từ cốt truyện đến bài học nhân sinh...', 'Danh sách những cuốn sách không thể bỏ qua trong năm nay.', 'Khang Admin', 'sách hay 2024, top sách, review sách', 'Khám phá top 10 cuốn sách đáng đọc nhất năm 2024 tại BookStore Premium.'),
('Lợi ích của việc đọc sách mỗi ngày', 'Đọc sách không chỉ giúp chúng ta mở mang kiến thức mà còn giúp giảm căng thẳng, cải thiện trí nhớ...', 'Tại sao bạn nên dành ít nhất 30 phút mỗi ngày để đọc sách?', 'Khang Admin', 'lợi ích đọc sách, thói quen đọc sách', 'Tìm hiểu những lợi ích bất ngờ của việc duy trì thói quen đọc sách mỗi ngày.');

-- Sample FAQ
INSERT INTO faqs (question, answer, category) VALUES
('Làm thế nào để đặt hàng?', 'Bạn chỉ cần chọn sản phẩm, thêm vào giỏ hàng và điền thông tin thanh toán.', 'Mua hàng'),
('Cửa hàng có ship tỉnh không?', 'Chúng tôi giao hàng toàn quốc với thời gian từ 2-5 ngày làm việc.', 'Giao hàng');
