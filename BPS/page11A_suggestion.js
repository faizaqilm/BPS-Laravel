function showHint(str) {
    // Code 4a: jika textfield kosong, kosongkan saran dan keluar dari fungsi
    if (str.length == 0) {
        document.getElementById("txtHint").innerHTML = "";
        return;
    }

    xhttp = new XMLHttpRequest();

    // Code 4b: fungsi yang dijalankan saat respons server sudah siap
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // responseText berupa JSON, konversi menjadi array/object JS
            let data = JSON.parse(this.responseText);
            let hasil = "";

            for (let i = 0; i < data.length; i++) {
                if (data[i].Judul === "no suggestion") {
                    hasil = "Tidak ada saran";
                    break;
                }
                hasil += (hasil === "" ? "" : ", ") + data[i].Judul;
            }

            document.getElementById("txtHint").innerHTML = hasil;
        } else if (this.readyState == 4) {
            document.getElementById("txtHint").innerHTML = "Gagal memuat saran (status " + this.status + ")";
        }
    };

    xhttp.open("GET", "page11A_gethint.php?keyword=" + str, true);
    xhttp.send();
}