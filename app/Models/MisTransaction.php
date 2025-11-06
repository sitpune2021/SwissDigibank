<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class MisTransaction extends Model
{
     use HasFactory;
 
    protected $fillable = [
        'misaccount_id',
        'amount',
        'interst',
        'tds',
        'net_interest',
        'pay_mode',
        'bank_id',
        'cheque_no',
        'transfer_date',
        'utr_no',
        'transfer_mode',
        'credited',
        'saving_account_id',
        'transaction_type',
        'transaction_no',
        'transaction_date',
        'due_date',
        'cheque_bank_name',
        'cheque_date',
        'approve_status',
        'amount_received',
        'remark',
        'accounted',
        'status',
        'processed',
        'paid_on',
        'print_flag',
    ];
 
    public function misaccount()
    {
        return $this->belongsTo(MisAccount::class);
    }
 
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
 
    public function savingAccount()
    {
         return $this->belongsTo(Account::class);
    }
}