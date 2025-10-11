<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IGNOS STUDIO - SELF PHOTO STUDIO</title>
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body class="light-blue">

    <main class="w-100 d-flex justify-content-center align-items-center min-vh-100">
        <div class="container bg-white pb-3 px-0">
            <div class="py-3 w-100 dark-blue text-center text-white">
                <h1>IGNOS STUDIO</h1>
                <p>Booking sesi photo studio</p>
            </div>
            <form class="p-5" action="{{ route('storeBookings') }}" method="POST">
                @csrf
                @method("POST")
                @if($errors->any())
                <div class="mb-3 alert alert-danger w-100">
                    Gagal memesan !
                </div>
                @endif
                <div class="mb-3">
                    <label for="nama" class="form-label"><b>Nama</b></label>
                    @error('nama')
                    <span class="text-danger">
                        ({{ $message }})
                    </span>
                    @enderror
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama anda"
                        value="{{ old('nama') }}" required>
                </div>
                <div class="mb-3">
                    <label for="jumlah_orang" class="form-label"><b>Masukkan Jumlah Orang</b></label>
                    @error('jumlah_orang')
                    <span class="text-danger">
                        ({{ $message }})
                    </span>
                    @enderror
                    <input type="number" min="1" max="6" value="1" class="form-control" id="jumlah_orang"
                        name="jumlah_orang" placeholder="Masukkan jumlah orang" value="{{ old('jumlah_orang') }}"
                        required>
                </div>
                <div class="mb-3">
                    <label for="tanggal" class="form-label"><b>Tanggal</b></label>
                    @error('tanggal')
                    <span class="text-danger">
                        ({{ $message }})
                    </span>
                    @enderror
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal') }}"
                        oninput="dateAction()" required>
                </div>
                <div class="mb-3 time">
                    <label for="waktu" class="form-label"><b>Waktu</b></label>
                    @error('waktu')
                    <span class="text-danger">
                        ({{ $message }})
                    </span>
                    @enderror

                    <div id="main_time" class="d-flex flex-wrap gap-3">
                        @for($i = 8; $i <= 22; $i++) <?php $nama = $i ?> @if($i < 10) <?php $nama = "0" . $i ?> @endif
                            <?php $nama = $nama . ":00"?> <?php $i2 = $i + 1 ?> <?php $nama2 = $i2 ?> @if($i2 < 10)
                            <?php $nama2 = "0" . $i2 ?> @endif <?php $nama2 = $nama2 . ":00"?>
                            <?php $nama_range = $nama . "-" . $nama2 ?> <div>
                            <input class="form-check-input" type="radio" name="waktu" id="{{ $i }}"
                                value="{{ $nama_range }}" required>
                            <label class="form-check-label" for="{{ $i }}">
                                {{ $nama_range }}
                            </label>
                    </div>
                    @endfor
                </div>

        </div>
        <div class="mb-3">
            <label for="package" class="form-label"><b>Pilih package</b></label>
            @error('package')
            <span class="text-danger">
                ({{ $message }})
            </span>
            @enderror
            <br>
            <div class="d-flex gap-3 flex-wrap">
                <div>
                    <input class="form-check-input" type="radio" name="package" id="basic" value="basic"
                        {{ old('package') == 'basic' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="basic">
                        Basic
                    </label>
                </div>
                <div>
                    <input class="form-check-input" type="radio" name="package" id="spotlight"
                        {{ old('package') == 'spotlight' ? 'checked' : '' }} value="spotlight">
                    <label class="form-check-label" for="spotlight">
                        Spotlight
                    </label>
                </div>
                <div>
                    <input class="form-check-input" type="radio" name="package"
                        id="projector {{ old('package') == 'projector' ? 'checked' : '' }}" value="projector">
                    <label class="form-check-label" for="projector">
                        Projector
                    </label>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label for="background" class="form-label"><b>Pilih background</b></label>
            @error('background')
            <span class="text-danger">
                ({{ $message }})
            </span>
            @enderror
            <br>
            <div class="d-flex gap-3 flex-wrap">
                <div>
                    <input class="form-check-input" type="radio" name="background" id="wall" value="wall"
                        {{ old('background') == 'wall' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="wall">
                        Wall
                    </label>
                </div>

                <div>
                    <input class="form-check-input" type="radio" name="background" id="white" value="white"
                        {{ old('background') == 'white' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="white">
                        White
                    </label>
                </div>

                <div>
                    <input class="form-check-input" type="radio" name="background" id="orange" value="orange"
                        {{ old('background') == 'orange' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="orange">
                        Orange
                    </label>
                </div>

                <div>
                    <input class="form-check-input" type="radio" name="background" id="grey" value="grey"
                        {{ old('background') == 'grey' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="grey">
                        Grey
                    </label>
                </div>

                <div>
                    <input class="form-check-input" type="radio" name="background" id="peach" value="peach"
                        {{ old('background') == 'peach' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="peach">
                        Peach
                    </label>
                </div>

            </div>
        </div>
        <button class="btn btn-primary" type="submit">Submit</button>
        </form>
        </div>
    </main>

    <!-- Bootstrap -->
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        const time = document.querySelector(".time");
        dateAction();

        function dateAction() {
            const dateElement = document.querySelector("#tanggal");
            const tanggal = dateElement.value;
            if (tanggal) {
                document.querySelector("#main_time").classList.add("d-none");
                const url = "{{ route('timeBookings', ['date' => ':date']) }}".replace(':date', tanggal);
                $.ajax({
                    url: url,
                    success: function (result) {
                        $("#main_time").html(result);
                        document.querySelector("#main_time").classList.remove("d-none");
                    }
                });
            }
        }

    </script>

</body>

</html>
