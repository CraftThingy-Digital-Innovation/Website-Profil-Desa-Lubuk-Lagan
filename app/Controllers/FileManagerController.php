<?php

namespace App\Controllers;

use App\Models\FileManagerModel;

class FileManagerController extends BaseAdminController
{
    public function index()
    {
        $fileModel = new FileManagerModel();
        $data['files'] = $fileModel->orderBy('created_at', 'DESC')->findAll();
        return view('admin/file_manager/index', $data);
    }

    /**
     * API endpoint untuk modal file picker di blog editor.
     * GET /admin/file-manager/api/list
     */
    public function api_list()
    {
        $fileModel = new FileManagerModel();
        $files     = $fileModel->orderBy('created_at', 'DESC')->findAll();

        $result = array_map(fn($f) => [
            'id'            => $f->id,
            'original_name' => $f->original_name,
            'file_type'     => $f->file_type,
            'file_size'     => $f->file_size,
            'url'           => base_url($f->file_path),
        ], $files);

        return $this->response->setJSON(['files' => $result]);
    }

    /**
     * Upload file dengan kompresi server-side:
     * - Gambar → GD/Imagick konversi ke WebP, maks 1MB
     * - Video  → FFmpeg compress ke MP4 H.264, maks 100MB
     */
    public function upload()
    {
        $file = $this->request->getFile('file');

        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'File tidak valid.']);
        }

        $uploadDir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $mime = $file->getClientMimeType();

        // ============================================================
        // GAMBAR — Konversi ke WebP & kompresi max 1MB
        // ============================================================
        if (strpos($mime, 'image/') === 0) {
            $tmpPath = $file->getTempName();
            $newName = pathinfo($file->getClientName(), PATHINFO_FILENAME) . '_' . uniqid() . '.webp';
            $destPath = $uploadDir . $newName;

            // Coba GD dulu
            if (extension_loaded('gd')) {
                $image = null;
                if ($mime === 'image/jpeg') $image = imagecreatefromjpeg($tmpPath);
                elseif ($mime === 'image/png') $image = imagecreatefrompng($tmpPath);
                elseif ($mime === 'image/gif') $image = imagecreatefromgif($tmpPath);
                elseif ($mime === 'image/webp') $image = imagecreatefromwebp($tmpPath);

                if ($image) {
                    // Scale down jika > 1920px
                    $w = imagesx($image); $h = imagesy($image);
                    if ($w > 1920) {
                        $ratio = 1920 / $w;
                        $nw = 1920; $nh = (int)($h * $ratio);
                        $resized = imagescale($image, $nw, $nh);
                        imagedestroy($image);
                        $image = $resized;
                    }
                    // WebP quality 80
                    imagewebp($image, $destPath, 80);
                    imagedestroy($image);
                } else {
                    // Fallback: copy langsung
                    move_uploaded_file($tmpPath, $destPath);
                }
            } else {
                move_uploaded_file($tmpPath, $destPath);
            }

            $finalSize = file_exists($destPath) ? filesize($destPath) : 0;
            $filePath  = 'uploads/' . $newName;

        // ============================================================
        // VIDEO — FFmpeg server-side compress ke MP4, maks 100MB
        // ============================================================
        } elseif (strpos($mime, 'video/') === 0) {
            $tmpPath  = $file->getTempName();
            $origSize = $file->getSize();
            $newName  = pathinfo($file->getClientName(), PATHINFO_FILENAME) . '_' . uniqid() . '.mp4';
            $destPath = $uploadDir . $newName;

            $ffmpegSuccess = false;

            // Cek apakah shell_exec tersedia (sering di-disable di shared hosting)
            if (is_callable('shell_exec') && false === stripos(ini_get('disable_functions'), 'shell_exec')) {
                // Cek apakah FFmpeg tersedia
                $ffmpegPath = trim(shell_exec('which ffmpeg 2>/dev/null') ?: shell_exec('where ffmpeg 2>nul'));
                if (!$ffmpegPath) $ffmpegPath = 'ffmpeg'; // fallback ke PATH

                $tmpMp4 = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'upload_' . uniqid() . '.mp4';
                $cmd    = escapeshellcmd($ffmpegPath)
                    . ' -i ' . escapeshellarg($tmpPath)
                    . ' -vcodec libx264 -crf 28 -preset fast'
                    . ' -c:a aac -b:a 128k -movflags +faststart'
                    . ' -y ' . escapeshellarg($tmpMp4) . ' 2>&1';

                $ffOutput = shell_exec($cmd);

                if (file_exists($tmpMp4) && filesize($tmpMp4) > 0) {
                    rename($tmpMp4, $destPath);
                    $ffmpegSuccess = true;
                }
            }

            if (!$ffmpegSuccess) {
                // FFmpeg gagal atau disable — simpan as-is dengan cek ukuran
                if ($origSize > 100 * 1024 * 1024) {
                    return $this->response->setJSON(['status' => 'error', 'message' => 'Video melebihi 100MB dan server tidak mendukung kompresi video.']);
                }
                $file->move($uploadDir, $newName);
            }

            $finalSize = file_exists($destPath) ? filesize($destPath) : $origSize;
            if ($finalSize > 100 * 1024 * 1024) {
                @unlink($destPath);
                return $this->response->setJSON(['status' => 'error', 'message' => 'Video masih melebihi 100MB setelah kompresi.']);
            }
            $filePath = 'uploads/' . $newName;

        // ============================================================
        // FILE LAIN — Simpan langsung
        // ============================================================
        } else {
            $newName   = $file->getRandomName();
            $file->move($uploadDir, $newName);
            $finalSize = filesize($uploadDir . $newName);
            $filePath  = 'uploads/' . $newName;
        }

        // Simpan ke database
        $fileModel = new FileManagerModel();
        $fileModel->insert([
            'filename'      => $newName,
            'original_name' => $file->getClientName(),
            'file_type'     => $mime,
            'file_size'     => $finalSize,
            'file_path'     => $filePath,
            'uploaded_by'   => auth()->id() ?? null,
        ]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'File berhasil diproses dan diunggah.',
            'url'     => base_url($filePath),
        ]);
    }

    public function delete($id)
    {
        $fileModel = new FileManagerModel();
        $file      = $fileModel->find($id);

        if ($file) {
            $filePath = FCPATH . $file->file_path;
            if (file_exists($filePath)) @unlink($filePath);
            $fileModel->delete($id);
            return $this->response->setJSON(['status' => 'success', 'message' => 'File dihapus.']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'File tidak ditemukan.']);
    }
}
