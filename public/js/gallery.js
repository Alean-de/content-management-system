document.addEventListener('DOMContentLoaded', () => {

    const image =
        document.getElementById('gallery-image');

    const preview =
        document.getElementById('gallery-preview');

    if (image && preview) {

        image.addEventListener('change', () => {

            const file =
                image.files[0];

            if (file) {
                preview.src =
                    URL.createObjectURL(file);
            }

        });

    }

});