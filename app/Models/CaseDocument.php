<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_id',
        'uploaded_by',
        'title',
        'file_path',
        'file_type',
        'file_size',
        'is_visible_to_client',
    ];

    protected $casts = [
        'is_visible_to_client' => 'boolean',
        'file_size' => 'integer',
    ];

    // Relationships
    public function legalCase()
    {
        return $this->belongsTo(LegalCase::class, 'case_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Accessors
    public function getFileUrlAttribute()
    {
        return asset('website/' . $this->file_path);
    }

    public function getHumanFileSizeAttribute()
    {
        $bytes = (int) $this->file_size;
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 1) . ' MB';
        }
        if ($bytes >= 1024) {
            return round($bytes / 1024, 1) . ' KB';
        }
        return $bytes . ' B';
    }

    // Scopes
    public function scopeVisibleToClient($query)
    {
        return $query->where('is_visible_to_client', true);
    }
}
