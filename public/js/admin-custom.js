document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.getElementById('sidebarToggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.getElementById('wrapper').classList.toggle('toggled');
        });
    }
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
    if (typeof ClassicEditor !== 'undefined') {
        const textareas = document.querySelectorAll('textarea[name="description"], textarea[name="content"], textarea[name="answer"], textarea[name="about_content"]');
        textareas.forEach(textarea => {
            ClassicEditor.create(textarea).catch(error => {
                console.error(error);
            });
        });
    }
});
