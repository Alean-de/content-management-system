document.addEventListener('DOMContentLoaded', () => {

    const thumbnail =
        document.getElementById('thumbnail');

    const preview =
        document.getElementById('thumbnail-preview');

    if (thumbnail && preview) {

        thumbnail.addEventListener('change', () => {

            const file =
                thumbnail.files[0];

            if (file) {
                preview.src =
                    URL.createObjectURL(file);
            }

        });

    }

    const content =
        document.getElementById('content');

    const counter =
        document.getElementById('counter');

    if (content && counter) {

        counter.textContent =
            content.value.length;

        content.addEventListener('input', () => {

            counter.textContent =
                content.value.length;

        });

    }

});