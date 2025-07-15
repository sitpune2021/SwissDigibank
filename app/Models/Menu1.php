<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    protected $table = 'menu';

    public $timestamps = true;

    protected $fillable = [
        'menu',   
        'submenu',
        'link',
        'position',
        'active',
    ];

	public static function distinctMenus()
	{
		return $menus = DB::table('menu')
		->select('menu')
		->distinct()
		->get();
	}
	public static function subMenus($menu)
	{
		return DB::table('menu')
			->where('menu', $menu)
			->select('submenu','link')
			->get();
	}
}
