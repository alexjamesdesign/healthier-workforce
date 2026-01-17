document.addEventListener('DOMContentLoaded', function() {
    var roleSelect = document.getElementById('roleSelect');
    
    // Only initialize if the element exists (user is logged in)
    if (!roleSelect) return;
    
    var forms = document.querySelectorAll('.role-form');
    roleSelect.addEventListener('change', function() {
        var selected = this.value;
        forms.forEach(function(form) {
            if (form.getAttribute('data-role') === selected) {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        });
    });
});