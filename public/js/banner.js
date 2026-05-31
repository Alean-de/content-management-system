document.addEventListener('DOMContentLoaded', () => {

    const imageInput = document.getElementById('image');
    const preview = document.getElementById('preview');

    if (imageInput && preview) {

        imageInput.addEventListener('change', function () {

            const file = this.files[0];

            if (file) {
                preview.src = URL.createObjectURL(file);
            }

        });

    }

});