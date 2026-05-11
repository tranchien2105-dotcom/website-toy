<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tạp hoá MinhChien</title>
    <link rel="icon" type="image/png" href="{{ asset('layout/images/favicon.png') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    <div class="min-h-screen bg-gray-100">

        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white shadow">
                <div class="container py-4">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="container py-4">
            {{ $slot }}
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const input = document.getElementById('searchInput');
        const suggestBox = document.getElementById('suggestBox');

        let currentIndex = -1;

        input.addEventListener('keyup', function (e) {

            if (['ArrowDown', 'ArrowUp', 'Enter'].includes(e.key)) return;

            let keyword = this.value;

            if (keyword.length < 1) {
                suggestBox.innerHTML = '';
                return;
            }

            fetch(`/admin/products/search?keyword=${keyword}`)
                .then(res => res.json())
                .then(data => {

                    let html = '';

                    data.forEach(item => {
                        html += `
                    <a href="/admin/products/${item.id}/edit"
                       class="list-group-item list-group-item-action suggest-item">
                        ${item.name}
                    </a>
                `;
                    });

                    suggestBox.innerHTML = html;
                    currentIndex = -1;
                });
        });

        input.addEventListener('keydown', function (e) {

            let items = document.querySelectorAll('.suggest-item');

            if (!items.length) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();

                currentIndex++;

                if (currentIndex >= items.length) currentIndex = 0;

                activeItem(items);
            }

            if (e.key === 'ArrowUp') {
                e.preventDefault();

                currentIndex--;

                if (currentIndex < 0) currentIndex = items.length - 1;

                activeItem(items);
            }

            if (e.key === 'Enter') {
                e.preventDefault();

                if (currentIndex > -1) {
                    window.location.href = items[currentIndex].href;
                }
            }
        });

        function activeItem(items) {
            items.forEach(item => item.classList.remove('active'));

            if (currentIndex >= 0) {
                items[currentIndex].classList.add('active');
            }
        }

        document.addEventListener('click', function (e) {
            if (!input.contains(e.target) && !suggestBox.contains(e.target)) {
                suggestBox.innerHTML = '';
            }
        });
    </script>

</body>

</html>