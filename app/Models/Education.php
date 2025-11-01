<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'educations'; // Explicitly set the table name

    protected $fillable = [
        'uuid',
        'lawyer_id',
        'degree',
        'institution',
        'graduation_year',
        'description',
        'order'
    ];

    protected $casts = [
        'graduation_year' => 'integer',
    ];

    // Relationships
    public function lawyer()
    {
        return $this->belongsTo(Lawyer::class);
    }
}
