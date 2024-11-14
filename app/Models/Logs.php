<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;
    protected $table = 'LOGS';

    // Définit la clé primaire (id_log)
    protected $primaryKey = 'idlog';

    // Attributs modifiables en masse
    protected $fillable = [
        'idequipe',
        'description',
    ];

    /**
     * Relation avec le modèle Equipe (Un log appartient à une équipe)
     */
    public function equipe()
    {
        return $this->belongsTo(Equipe::class, 'idequipe');
    }
}
