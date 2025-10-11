<!DOCTYPE html>
<html lang="en" class="bg-ignos dark:bg-ignos-dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IGNOS STUDIO - SELF PHOTO STUDIO</title>
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/final2.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/final.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('app.css') }}">
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        const bodyMain = document.querySelector("#bodyMain");
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');

        } else {
            document.documentElement.classList.remove('dark')

        }
    </script>
</head>

<body>
    <div class="min-h-[100dvh] bg-[url('../../public/img/bg-ignos.svg')] dark:bg-[url('../../public/img/bg-ignos-dark.svg')] bg-cover"
        id="bodyMain">

        @yield('content')
        @include('partials.footer')
    </div>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script> -->
    <script>
        var themeToggleDarkIcon = document.getElementById("theme-toggle-dark-icon");
        var themeToggleLightIcon = document.getElementById("theme-toggle-light-icon");

        // Change the icons inside the button based on previous settings
        if (
            localStorage.getItem("color-theme") === "dark" ||
            (!("color-theme" in localStorage) &&
                window.matchMedia("(prefers-color-scheme: dark)").matches)
        ) {
            themeToggleLightIcon.classList.remove("hidden");
        } else {
            themeToggleDarkIcon.classList.remove("hidden");
        }

        var themeToggleBtn = document.getElementById("theme-toggle");

        themeToggleBtn.addEventListener("click", function() {
            // toggle icons inside button
            themeToggleDarkIcon.classList.toggle("hidden");
            themeToggleLightIcon.classList.toggle("hidden");

            // if set via local storage previously
            if (localStorage.getItem("color-theme")) {
                if (localStorage.getItem("color-theme") === "light") {
                    document.documentElement.classList.add("dark");
                    localStorage.setItem("color-theme", "dark");
                } else {
                    document.documentElement.classList.remove("dark");
                    localStorage.setItem("color-theme", "light");
                }

                // if NOT set via local storage previously
            } else {
                if (document.documentElement.classList.contains("dark")) {
                    document.documentElement.classList.remove("dark");
                    localStorage.setItem("color-theme", "light");
                } else {
                    document.documentElement.classList.add("dark");
                    localStorage.setItem("color-theme", "dark");
                }
            }
        });

        function cetakStruk() {
            // updateStruk();
            // Hapus style lama jika ada
            const oldStyle = document.getElementById("print-style");
            if (oldStyle) oldStyle.remove();

            const printStyle = document.createElement('style');
            printStyle.id = "print-style";
            printStyle.innerHTML = `
            @media print {
                * {
                    box-sizing: border-box;
                }
                body, html {
                    margin: 0;
                    padding: 0;
                    height: 100vh;
                    overflow: hidden !important;
                }

                @page {
                    size: A4 portrait;
                    margin: 10mm;
                }

                .no-print {
                    display: none !important;
                }

                #struk {
                    transform-origin: top left;
                    transform: scale(0.95); /* adjust if still overflows */
                    width: 100%;
                    page-break-inside: avoid;
                    break-inside: avoid;
                }
            }
            `;
            document.head.appendChild(printStyle);


            const GAS_URL =
                "https://script.google.com/macros/s/AKfycbzcf2HEEo2D2a3zgml-mlmrl0kq7ONBTIQUcN_LaWk9xIER7ssMW3OaFFPdabePab2s/exec";
            // Ambil data dari form
            const admin = document.getElementById("admin").value;
            const metode = document.getElementById("metode_pembayaran").value;
            const paket = document.getElementById("selectPaket").selectedOptions[0].dataset.nama;
            const bingkai4r = document.getElementById("Bingkai 4R").value;
            const cetak4r = document.getElementById("Cetak 4R").value;
            const keychain = document.getElementById("Keychain").value;
            const cetak10RBingkai = document.getElementById("Cetak 10R + Bingkai").value;
            const pasFoto = document.getElementById("Pas Foto").value;
            const penambahanWaktu = document.getElementById("penambahan_waktu").value;
            const jumlahOrang = document.getElementById("jumlah_orang").value;
            const tambahanTirai = document.getElementById("tambahan_tirai").checked ? "tambah" : "tidak tambah";
            const tambahanSpotlight = document.getElementById("tambahan_spotlight").checked ? "tambah" : "tidak tambah";
            const tidakMembuatStory = document.getElementById("tidak_membuat_story").checked ? "iya" : "tidak";
            const total = document.getElementById("struk-total").innerText.trim();
            const invoice = document.getElementById("invoice-number").innerText.trim();
            const jumlahBando = (document.getElementById("jumlah_bando")) ? document.getElementById("jumlah_bando").value :
                '-';
            const typePhoto = document.getElementById("type-photo").value;

            // Optional: tampilkan loading feedback
            const btn = document.querySelector('button[type="submit"]');
            const originalText = btn.innerText;
            btn.disabled = true;
            btn.innerText = "Menyimpan & Mencetak...";

            // Siapkan FormData
            const formData = new FormData();
            formData.append("nama", document.getElementById("nama").value);
            formData.append("admin", admin);
            formData.append("typePhoto", typePhoto);
            formData.append("metode", metode);
            formData.append("total", total);
            formData.append("invoice", invoice);
            formData.append("jumlahBando", jumlahBando);
            formData.append("paket", paket); // Menambahkan paket
            formData.append("bingkai4r", bingkai4r); // Menambahkan bingkai4r
            formData.append("cetak4r", cetak4r); // Menambahkan cetak4r
            formData.append("keychain", keychain); // Menambahkan keychain
            formData.append("cetak10RBingkai", cetak10RBingkai); // Menambahkan cetak10RBingkai
            formData.append("pasFoto", pasFoto); // Menambahkan pasFoto
            formData.append("penambahanWaktu", penambahanWaktu); // Menambahkan penambahanWaktu
            formData.append("jumlahOrang", jumlahOrang); // Menambahkan jumlahOrang
            formData.append("tambahanTirai", tambahanTirai); // Menambahkan tambahanTirai
            formData.append("tambahanSpotlight", tambahanSpotlight); // Menambahkan tambahanSpotlight
            formData.append("tidakMembuatStory", tidakMembuatStory); // Menambahkan tidakMembuatStory

            const nama = document.getElementById("nama").value || "Tanpa Nama";
            const originalTitle = document.title;
            const newTitle = `IGNOS STUDIO - ${nama}`;

            document.title = newTitle;

            // Kirim ke Google Apps Script
            fetch(GAS_URL, {
                method: "POST",
                body: new URLSearchParams(formData),
                mode: "no-cors" // development workaround
            })
            // .finally(() => {
            //     // Tambahkan jeda agar browser sempat update title
            //     setTimeout(() => {
            //         window.print();
            //         btn.disabled = false;
            //         btn.innerText = originalText;

            //         // Kembalikan title setelah print
            //         setTimeout(() => {
            //             document.title = originalTitle;
            //         }, 100);
            //     }, 1500); // Jeda diperpanjang sedikit
            // });
            // Tambahkan jeda agar browser sempat update title
            setTimeout(() => {
                window.print();
                btn.disabled = false;
                btn.innerText = originalText;

                // Kembalikan title setelah print
                setTimeout(() => {
                    document.title = originalTitle;
                }, 100);
            }, 1500); // Jeda diperpanjang sedikit
        }
    </script>
    {{-- <script src="{{ asset('flowbite/flowbite.min.js') }}"></script>
    <script src="{{ asset('flowbite/flowbite.js') }}"></script> --}}
    <script src="{{ asset('flowbite/dist/flowbite.min.js') }}"></script>
    <script src="{{ asset('flowbite/dist/flowbite.js') }}"></script>
</body>

</html>
