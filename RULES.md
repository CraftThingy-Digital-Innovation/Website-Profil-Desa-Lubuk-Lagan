# Aturan Pengembangan Proyek (RULES.md)

Penting: AI Agent dan Developer harus mengikuti semua aturan ini tanpa pengecualian.

## 1. Aturan Modifikasi Database & Migrasi (CRITICAL)
- **DILARANG KERAS** memodifikasi file migration yang sudah dibuat dan sudah pernah dijalankan atau di-commit.
- Jika ada perubahan struktur tabel, penambahan kolom, perubahan tipe data, atau modifikasi database lainnya, **HANYA** boleh dilakukan dengan membuat file migration baru (`php spark make:migration NamaPerubahan`).
- Database disetting untuk menjalankan auto-migrate dan auto-seed pada saat aplikasi berjalan di mode `development`. Oleh karena itu, file migrasi lama tidak boleh disentuh agar tidak menyebabkan inkonsistensi.

## 2. Aturan Data Seeding
- Seeder harus ditulis dengan prinsip *idempotent* (aman dijalankan berkali-kali).
- Selalu cek ketersediaan data di database sebelum melakukan `insert` (`if ($model->where(...)->countAllResults() == 0)`). Jika data sudah ada, lewati proses insert untuk mencegah duplikasi data akibat fungsi auto-seed.

## 3. Standar CodeIgniter 4
- Selalu gunakan perlindungan Entity dan Model (definisikan `allowedFields`, `useTimestamps`).
- Hindari penulisan raw SQL query jika framework menyediakan Query Builder atau Model yang lebih aman (mencegah SQL Injection).

## 4. Keamanan & Efisiensi Client-side
- Sesuai dengan instruksi utama, kompresi file (Gambar Max 1MB, Video Max 100MB) **harus** dilakukan di client-side sebelum diunggah ke server untuk menghemat bandwidth server.
- Fitur autosave tidak boleh mengirim request yang terlalu sering. Gunakan mekanisme *debounce* pada AJAX.
