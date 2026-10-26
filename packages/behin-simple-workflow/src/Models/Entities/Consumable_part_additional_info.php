<?php 
namespace Behin\SimpleWorkflow\Models\Entities; 
use Behin\SimpleWorkflow\Controllers\Core\VariableController; use Illuminate\Database\Eloquent\Factories\HasFactory; use Illuminate\Database\Eloquent\Model; use Illuminate\Support\Str; use Illuminate\Database\Eloquent\SoftDeletes;
 class Consumable_part_additional_info extends Model 
{ 
    use SoftDeletes; 
    public $incrementing = false; 
    protected $keyType = 'string'; 
    public $table = 'wf_entity_consumable_part_additional_info'; 
    protected $fillable = ['case_id', 'case_number', 'consumable_parts_id', 'order_date', 'receipt_date', 'unit_price', 'currency', 'order_date_alt', 'receipt_date_alt',  'created_by', 'updated_by', 'contributers', ]; 
protected static function boot()
        {
            parent::boot();

            static::creating(function ($model) {
                $model->id = $model->id ?? substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 10);
            });
        }
    public function consumable_parts(){
        return $this->belongsTo(Consumable_parts::class, 'consumable_parts_id');
    }
    public function currencyLabel(){
        $currencies = config('simpleWorkflowReport.consumable_parts.currencies', []);
        foreach($currencies as $currency){
            if(($currency['key'] ?? null) == $this->currency){
                return $currency['label'] ?? $this->currency;
            }
        }
        return $this->currency;
    }
}
