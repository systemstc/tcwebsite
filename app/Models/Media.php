<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $fillable = [
        'name',
        'file_name',
        'disk_path',
        'url',
        'file_type',
        'mime_type',
        'extension',
        'size_bytes',
        'size_formatted',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isImage(): bool
    {
        return $this->file_type === 'image' || in_array(strtolower($this->extension), ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']);
    }

    public function isDocument(): bool
    {
        return $this->file_type === 'document' || in_array(strtolower($this->extension), ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv']);
    }

    public function getIconAttribute(): string
    {
        $ext = strtolower($this->extension);
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'])) {
            return 'image';
        }
        if ($ext === 'pdf') {
            return 'picture_as_pdf';
        }
        if (in_array($ext, ['doc', 'docx'])) {
            return 'description';
        }
        if (in_array($ext, ['xls', 'xlsx', 'csv'])) {
            return 'table_chart';
        }
        if (in_array($ext, ['zip', 'rar', 'tar', 'gz', '7z'])) {
            return 'folder_zip';
        }
        if (in_array($ext, ['mp4', 'mov', 'avi', 'mkv', 'webm'])) {
            return 'video_file';
        }
        if (in_array($ext, ['mp3', 'wav', 'ogg'])) {
            return 'audio_file';
        }
        return 'draft';
    }
}
