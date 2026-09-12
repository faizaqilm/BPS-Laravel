function validate06C(){
    let pesan = "";

    let nomor   = document.getElementById('nomor').value.trim();
    let judul   = document.getElementById('Judul').value.trim(); 
    let tanggal = document.getElementById('tgl_rilis').value;

    if (nomor == ""){
        pesan += "Nomor tidak boleh kosong<br>";
    }
    else if (/[^0-9]/.test(nomor)){
        pesan += "Mohon masukkan nomor dengan angka<br>";
    }

    if (judul == ""){
        pesan += "Judul tidak boleh kosong. <br>";
    }
    else if (/[^a-zA-Z0-9 \:\-]/.test(judul)){
        pesan += "Terdapat karakter yang tidak valid pada judul.<br>";
    }
    
    if (tanggal == ""){
        pesan += "Tanggal tidak boleh kosong<br>";
    }

    let kotakError = document.getElementById('pesanError');

    if (pesan != ""){
        kotakError.innerHTML = pesan;
        kotakError.style.display = 'block';
        return false;
    }
    else{
        kotakError.style.display = 'none';
        return true;
    }

}