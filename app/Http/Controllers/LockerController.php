<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LockerController extends Controller
{
       public function locker_list_index()
    {
        return view('lockers.locker-list.index');
    }
      public function locker_list_add()
    {
        return view('lockers.locker-list.add');
    }
     public function locker_list_view()
    {
        return view('lockers.locker-list.view');
    }
    
     public function assign_locker()
    {
        return view('lockers.locker-list.assign-locker');
    }
      public function release_locker()
    {
        return view('lockers.locker-list.release-locker');
    }
      public function member_locker_index()
    {
        return view('lockers.member-locker.index');
    }
     public function member_locker_view()
    {
        return view('lockers.member-locker.view');
    }
}
