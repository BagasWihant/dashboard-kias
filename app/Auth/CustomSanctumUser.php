<?php
namespace App\Auth;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class CustomSanctumUser extends Model implements AuthenticatableContract
{
    use HasApiTokens, Authenticatable;

    protected $table = 'gm_user';  
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['id', 'nik', 'nama'];

    public function toArray()
    {
        return [
            'id' => $this->id,
            'nik' => $this->nik,
            'role_id' => $this->role_id,
            'nama' => $this->nama, // kolom gak enek nama
        ];
    }
}
