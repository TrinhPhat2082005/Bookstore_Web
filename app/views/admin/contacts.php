<?php require_once '../app/views/admin/layout/header.php'; ?>
<?php require_once '../app/views/admin/layout/sidebar.php'; ?>

<div class="row">
    <div class="col-12">
        <div class="table-container p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Quản lý Liên hệ</h4>
                <div class="badge bg-purple-subtle text-primary p-2 px-3"><?php echo count($data['contacts']); ?> Tin
                    nhắn mới</div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Khách hàng</th>
                            <th>Thông tin liên hệ</th>
                            <th>Chủ đề</th>
                            <th>Trạng thái</th>
                            <th>Thời gian</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['contacts'] as $contact): ?>
                            <tr>
                                <td>
                                    <div class="fw-bold"><?php echo $contact->name; ?></div>
                                </td>
                                <td>
                                    <div class="small text-muted mb-1"><i class="fa-solid fa-envelope me-1"></i>
                                        <?php echo $contact->email; ?></div>
                                    <div class="small text-muted"><i class="fa-solid fa-phone me-1"></i>
                                        <?php echo $contact->phone ?? 'N/A'; ?></div>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;"
                                        title="<?php echo $contact->message; ?>">
                                        <strong><?php echo $contact->subject; ?>:</strong> <?php echo $contact->message; ?>
                                    </div>
                                </td>
                                <td>
                                    <span
                                        class="badge <?php echo $contact->status == 'unread' ? 'bg-danger' : 'bg-success'; ?>-subtle text-<?php echo $contact->status == 'unread' ? 'danger' : 'success'; ?> p-2 px-3">
                                        <?php echo $contact->status == 'unread' ? 'Chưa đọc' : 'Đã xem'; ?>
                                    </span>
                                </td>
                                <td class="small text-muted">
                                    <?php echo date('d/m/Y H:i', strtotime($contact->created_at)); ?>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-primary view-contact" 
                                                title="Xem chi tiết"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#contactModal"
                                                data-name="<?php echo htmlspecialchars($contact->name); ?>"
                                                data-email="<?php echo htmlspecialchars($contact->email); ?>"
                                                data-phone="<?php echo htmlspecialchars($contact->phone ?? 'N/A'); ?>"
                                                data-subject="<?php echo htmlspecialchars($contact->subject); ?>"
                                                data-message="<?php echo htmlspecialchars($contact->message); ?>"
                                                data-date="<?php echo date('d/m/Y H:i', strtotime($contact->created_at)); ?>"
                                                data-id="<?php echo $contact->id; ?>"
                                                data-status="<?php echo $contact->status; ?>">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <?php if ($contact->status == 'unread'): ?>
                                            <a href="?action=read&id=<?php echo $contact->id; ?>"
                                                class="btn btn-sm btn-outline-secondary" title="Đánh dấu đã đọc">
                                                <i class="fa-solid fa-check"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="?action=delete&id=<?php echo $contact->id; ?>"
                                            class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa tin nhắn này?')" title="Xóa">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($data['contacts'])): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">Không có tin nhắn liên hệ nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php 
                $paginationData = [
                    'currentPage' => $data['current_page'],
                    'totalPages'  => $data['total_pages'],
                    'baseUrl'     => BASE_URL . 'admin/manageContacts'
                ];
                extract($paginationData);
                require __DIR__ . '/../layout/pagination.php';
            ?>
        </div>
    </div>
</div>
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="contactModalLabel">Chi tiết tin nhắn</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Khách hàng</label>
                    <p id="modal-name" class="fw-bold mb-0"></p>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="text-muted small fw-bold text-uppercase">Email</label>
                        <p id="modal-email" class="mb-0"></p>
                    </div>
                    <div class="col-6">
                        <label class="text-muted small fw-bold text-uppercase">Số điện thoại</label>
                        <p id="modal-phone" class="mb-0"></p>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Chủ đề</label>
                    <p id="modal-subject" class="fw-bold mb-0 text-primary"></p>
                </div>
                <hr>
                <div class="mb-3">
                    <label class="text-muted small fw-bold text-uppercase">Nội dung tin nhắn</label>
                    <div class="p-3 bg-light rounded-3 mt-2" id="modal-message" style="white-space: pre-wrap; word-wrap: break-word; word-break: break-all;"></div>
                </div>
                <div class="text-end text-muted small" id="modal-date"></div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Đóng</button>
                <a href="" id="modal-read-btn" class="btn btn-primary px-4">Đánh dấu đã đọc</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactModal = document.getElementById('contactModal');
    const viewButtons = document.querySelectorAll('.view-contact');

    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const name = this.getAttribute('data-name');
            const email = this.getAttribute('data-email');
            const phone = this.getAttribute('data-phone');
            const subject = this.getAttribute('data-subject');
            const message = this.getAttribute('data-message');
            const date = this.getAttribute('data-date');
            const id = this.getAttribute('data-id');
            const status = this.getAttribute('data-status');

            document.getElementById('modal-name').textContent = name;
            document.getElementById('modal-email').textContent = email;
            document.getElementById('modal-phone').textContent = phone;
            document.getElementById('modal-subject').textContent = subject;
            document.getElementById('modal-message').textContent = message;
            document.getElementById('modal-date').textContent = 'Gửi lúc: ' + date;

            const readBtn = document.getElementById('modal-read-btn');
            if (status === 'unread') {
                readBtn.style.display = 'inline-block';
                readBtn.href = '?action=read&id=' + id;
            } else {
                readBtn.style.display = 'none';
            }
        });
    });
});
</script>

<?php require_once '../app/views/admin/layout/footer.php'; ?>