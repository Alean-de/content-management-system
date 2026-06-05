document.addEventListener('DOMContentLoaded', () => {

    const deleteButtons =
        document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {

        button.addEventListener('click', (e) => {

            const confirmDelete =
                confirm('Yakin ingin menghapus data?');

            if (!confirmDelete) {
                e.preventDefault();
            }

        });

    });

});