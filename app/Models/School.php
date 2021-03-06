<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
  public $timestamps = false;
  use HasFactory;
  protected $fillable = ['name', 'gender', 'date', 'class_id'];
}
