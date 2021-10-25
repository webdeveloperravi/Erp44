<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Store\Ledger;
use App\Model\Guard\UserStore;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class StoreChecker
{
    public function handle($request, Closure $next)
    {

        $account = request()->getHttpHost();

        $store  = UserStore::select(['id', 'name'])->where(['sub_domain' => $account])->whereIn('type', ['org', 'lab'])->firstOrFail();

        Session::put('store', $store);
        Session::put('account_id', $store->id);
        return $next($request);
    }
}
