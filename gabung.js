const fs = require('fs');
const path = require('path');

// ─── PENGATURAN ───
const targetFolder = './'; 
const outputFile = 'semua_kode_website.txt';
const allowedExtensions = ['.js', '.jsx', '.css', '.html', '.php']; // Ekstensi file yang mau diambil

// Folder yang WAJIB diabaikan agar file tidak bengkak
const ignoredFolders = ['node_modules', '.git', 'build', 'dist', 'public']; 

function mergeFiles(dir) {
  const files = fs.readdirSync(dir);

  files.forEach(file => {
    const fullPath = path.join(dir, file);
    const stat = fs.statSync(fullPath);

    if (stat.isDirectory()) {
      // Rekursif: masuk ke subfolder jika tidak ada di daftar abaikan
      if (!ignoredFolders.includes(file)) {
        mergeFiles(fullPath);
      }
    } else {
      // Gabungkan isi file jika ekstensinya sesuai
      if (allowedExtensions.includes(path.extname(file))) {
        const content = fs.readFileSync(fullPath, 'utf-8');
        // Tambahkan header penanda nama file agar mudah dibaca
        const separator = `\n\n/* ════════════════════════════════════════\n   FILE: ${fullPath.replace(/\\/g, '/')}\n   ════════════════════════════════════════ */\n\n`;
        fs.appendFileSync(outputFile, separator + content);
      }
    }
  });
}

// Bersihkan output file lama jika sudah pernah dijalankan
if (fs.existsSync(outputFile)) fs.unlinkSync(outputFile);

console.log('⏳ Sedang memproses dan menggabungkan kode...');
mergeFiles(targetFolder);
console.log(`✅ Berhasil! Semua kode telah disalin ke: ${outputFile}`);