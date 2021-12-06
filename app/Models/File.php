<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class File extends Model
{
    use HasFactory;
    use Sortable;

    protected $guarded = [];

    public $sortable = ['name' ,'updated_at'];

    public function user() {
        $this->belongsTo(User::class);
    }
}
