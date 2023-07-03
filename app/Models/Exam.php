<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'date',
        'id_pasien',
        'id_polyclinic',
        'golda',
        'hb',
        'hiv',
        'shipi',
        'hbsag',
        'gdp',
        'gds',
        'chol',
        'au',
        'ns1',
        'igg_dengue',
        'igm_dengue',
        'widal',
        'ag19',
        'ddr',
        'plano',
        'prot_urine',
        'reduksi',
        'btas',
        'btap',
        'tcm',
        'pcr',
        'leukosit_hema',
        'eritrosit',
        'hematokrit',
        'mcv',
        'mch',
        'mchc',
        'trombosit',
        'rdw',
        'neutrofil',
        'limfosit',
        'mxd',
        'apusan_malaria',
        'rdt_malaria',
        'skin_smear_bta',
        'warna',
        'kekeruhan',
        'ph',
        'berat_jenis',
        'keton',
        'bilirubin',
        'urobilinogen',
        'nitrit',
        'leukosit_urin',
        'darah',
        'epitel',
        'hialin',
        'berbutir',
        'lain_lain',
        'leukosit_urin_mikro',
        'eritrosit_urin',
        'kristal',
        'bakteri',
        'diagnosis',
        'updated_by',
        'created_by',
    ];
}
