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
                                <!-- $contact -> name: OOP -->
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

            <!-- Custom Pagination -->
            <?php if ($data['total_pages'] > 1): ?>
                <nav class="mt-4">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php echo $data['current_page'] == 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $data['current_page'] - 1; ?>"><i
                                    class="fa-solid fa-chevron-left"></i></a>
                        </li>
                        <?php for ($i = 1; $i <= $data['total_pages']; $i++): ?>
                            <li class="page-item <?php echo $data['current_page'] == $i ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <li
                            class="page-item <?php echo $data['current_page'] == $data['total_pages'] ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $data['current_page'] + 1; ?>"><i
                                    class="fa-solid fa-chevron-right"></i></a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once '../app/views/admin/layout/footer.php'; ?>