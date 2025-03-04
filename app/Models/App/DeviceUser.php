<?php

namespace App\Models\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectRequest;

class DeviceUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_type', 'device_token', 'device_name', 'device_os',
        'device_version', 'device_browser', 'device_browser_version',
        'device_ip', 'is_mobile', 'is_tablet', 'is_desktop',
        'is_bot', 'request_id'
    ];

    public function projectRequest()
    {
        return $this->hasOne(ProjectRequest::class, 'id', 'request_id');
    }
}
