<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;
    const STATUS = [
        1 => [ 'label' => '未着手', 'class' => 'label-danger' ],
        2 => [ 'label' => '着手中', 'class' => 'label-info' ],
        3 => [ 'label' => '完了', 'class' => '' ],
    ];
    const EMERGENCY = [
        1 => [ 'emergency' => '★☆☆' ],
        2 => [ 'emergency' => '★★☆' ],
        3 => [ 'emergency' => '★★★' ],
    ];

    /**
     * 状態のラベル
     * @return string
     */
    public function getStatusClassAttribute()
    {
        // 状態値
        $status = $this->attributes['status'];

        // 定義されていなければ空文字を返す
        if (!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['class'];
    }
    public function getStatusLabelAttribute()
    {
        // 状態値
        $status = $this->attributes['status'];

        // 定義されていなければ空文字を返す
        if (!isset(self::STATUS[$status])) {
            return '';
        }

        return self::STATUS[$status]['label'];
    }

    public function getFormattedDueDateAttribute()
    {
        return Carbon::createFromFormat('Y-m-d', $this->attributes['due_date'])
            ->format('Y/m/d');
    }

    protected $fillable = ['title','due_date','user_id','updated_at', 'created_at']; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getEmergencyAttribute()
    {
        // 状態値
        $emergency = $this->attributes['emergency'];

        // 定義されていなければ空文字を返す
        if (!isset(self::EMERGENCY[$emergency])) {
            return '';
        }

        return self::EMERGENCY[$emergency]['emergency'];
    }

    
}
