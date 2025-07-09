@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000,
            position: 'top-end',
            customClass: { confirmButton: 'btn btn-success' },
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000,
            position: 'top-end',
            customClass: { confirmButton: 'btn btn-danger' },
        });
    </script>
@endif
