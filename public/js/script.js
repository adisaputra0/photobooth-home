// const tanggal = document.querySelector("#tanggal");
// const time = document.querySelector(".time");

// tanggal.addEventListener("input", () => {
//     time.classList.remove("d-none");
// });

function sendWhatsApp() {
    const nama = document.getElementById("nama").value;
    const tanggal = document.getElementById("tanggal").value;
    const waktu = document.querySelector("input[name='waktu']:checked").value;
    const background = document.querySelector("input[name='background']:checked").value

    var message = "Nama : " + nama + "\nTanggal : " + tanggal + "\nWaktu : " + waktu + "\nBackground : " + background;

    var whatsappLink = "https://wa.me/6283847406524?text=" + encodeURIComponent(message);
    window.open(whatsappLink, "_blank");
}