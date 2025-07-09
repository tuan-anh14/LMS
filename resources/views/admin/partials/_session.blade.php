@if (session('success'))
    <script>
        var n = new Noty({
            text: "{{ session('success') }}",
            type: 'success',
            killer: true,
            timeout: 2000
        });
        n.show();
    </script>
@endif

@if(session('error'))
    <script>
        var n = new Noty({
            text: "{{ session('error') }}",
            type: 'error',
            killer: true,
            timeout: 2000
        });
        n.show();
    </script>
@endif
