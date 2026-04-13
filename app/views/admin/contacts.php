<?php require_once '../app/views/admin/layout/sidebar.php'; ?>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Tiêu đề</th>
                <th>Tin nhắn</th>
                <th>Trạng thái</th>
                <th>Ngày gửi</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['contacts'] as $contact): ?>
                <tr>
                    <td style="font-weight: 500;"><?php echo $contact->name; ?></td>
                    <td><?php echo $contact->email; ?></td>
                    <td><?php echo $contact->subject; ?></td>
                    <td style="max-width: 250px; font-size: 14px; color: #6b7280;"><?php echo $contact->message; ?></td>
                    <td>
                        <span class="badge badge-<?php echo $contact->status; ?>">
                            <?php echo $contact->status == 'unread' ? 'Chưa đọc' : 'Đã đọc'; ?>
                        </span>
                    </td>
                    <td style="font-size: 13px; color: #9ca3af;"><?php echo date('d/m/Y H:i', strtotime($contact->created_at)); ?></td>
                    <td>
                        <div style="display: flex; gap: 10px;">
                            <?php if($contact->status == 'unread'): ?>
                                <a href="?action=read&id=<?php echo $contact->id; ?>" class="btn-sm" style="background: #e0f2fe; color: #0369a1;" title="Đánh dấu đã đọc">
                                    <i class="fas fa-check"></i>
                                </a>
                            <?php endif; ?>
                            <a href="?action=delete&id=<?php echo $contact->id; ?>" class="btn-sm" style="background: #fee2e2; color: #991b1b;" onclick="return confirm('Bạn có chắc chắn muốn xóa?')" title="Xóa">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if(empty($data['contacts'])): ?>
                <tr>
                    <td colspan="7" style="text-align: center; padding: 50px; color: #9ca3af;">Không có liên hệ nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Phân trang [Rule 26] -->
    <?php if($data['total_pages'] > 1): ?>
        <div class="pagination">
            <?php for($i = 1; $i <= $data['total_pages']; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="<?php echo $data['current_page'] == $i ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
