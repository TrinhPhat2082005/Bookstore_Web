<?php require_once '../app/views/client/layout/header.php'; ?>

<main>
    <section>
        <div class="container">
            <div style="max-width: 800px; margin: 0 auto; text-align: center;">
                <h1 style="font-size: 48px; margin-bottom: 40px;">Câu chuyện của chúng tôi</h1>
                <div style="text-align: left; background: var(--white); padding: 50px; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.05);">
                    <p style="font-size: 18px; color: var(--gray); margin-bottom: 30px;">
                        <?php echo nl2br($data['settings']['about_content']); ?>
                    </p>
                    <p style="font-size: 18px; color: var(--gray); margin-bottom: 30px;">
                        Được thành lập với niềm đam mê đọc sách, chúng tôi không chỉ bán những trang giấy, chúng tôi mang đến những hành trình, cảm hứng và tri thức cho cộng đồng.
                    </p>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-top: 50px;">
                        <div style="border-left: 4px solid var(--primary); padding-left: 20px;">
                            <h4 style="font-size: 24px; color: var(--primary);">5000+</h4>
                            <p style="color: var(--gray);">Đầu sách đa dạng</p>
                        </div>
                        <div style="border-left: 4px solid var(--primary); padding-left: 20px;">
                            <h4 style="font-size: 24px; color: var(--primary);">10,000+</h4>
                            <p style="color: var(--gray);">Khách hàng tin tưởng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once '../app/views/client/layout/footer.php'; ?>
