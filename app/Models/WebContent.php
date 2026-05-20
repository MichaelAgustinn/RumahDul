<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebContent extends Model
{
    protected $fillable = ['site_title', 'footer_address', 'footer_phone', 'footer_email'];
}
