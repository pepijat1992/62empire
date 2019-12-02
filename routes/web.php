<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('lang/{locale}', 'VerifyController@lang')->name('lang');
Route::get('/verify', 'VerifyController@show')->name('verify');
Route::post('/login_verify', 'VerifyController@login_verify')->name('login_verify');
Route::post('/register_verify', 'VerifyController@register_verify')->name('register_verify');

Route::get('/check_passcode', 'VerifyController@check_passcode')->name('check_passcode');
Route::post('/post_check_passcode', 'VerifyController@post_check_passcode')->name('post_check_passcode');

Route::get('/', 'HomeController@index')->name('home');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('login_verification', 'Auth\LoginController@showLoginVerificationForm')->name('login_verification');
Route::post('login', ['as'=>'login','uses'=>'Auth\LoginController@login']);
Route::get('register', 'Auth\RegisterController@showRegisterForm')->name('register');
Route::post('register', ['as'=>'register','uses'=>'Auth\RegisterController@register']);
Route::get('logout', ['as' => 'logout','uses' => 'Auth\LoginController@logout']);

Route::group(['prefix' => 'm', 'namespace' => 'Wap', 'middleware' => 'passcode'],function ($router){
    $router->get('/', function(){config(['site.wap_footer' => 'game']); return view('wap.index');})->name('wap.index');
    $router->get('home', 'IndexController@home')->name('wap.home');
    $router->get('game/{id}', 'IndexController@game')->name('wap.game');
    $router->get('wallet', function(){return view('wap.wallet');})->name('wap.wallet');
    $router->get('online_deposit', 'IndexController@online_deposit')->name('wap.online_deposit');
    $router->post('online_deposit', 'IndexController@post_online_deposit')->name('wap.post_online_deposit');
    $router->get('online_withdraw', 'IndexController@online_withdraw')->name('wap.online_withdraw');
    $router->post('online_withdraw', 'IndexController@post_online_withdraw')->name('wap.post_online_withdraw');
    $router->get('bank_account', 'IndexController@bank_account')->name('wap.bank_account.index');
    $router->post('bank_account/create', 'IndexController@create_bank_account')->name('wap.bank_account.create');
    $router->post('bank_account/edit', 'IndexController@edit_bank_account')->name('wap.bank_account.edit');
    $router->get('bank_account/delete/{id}', 'IndexController@delete_bank_account')->name('wap.bank_account.delete');
    $router->get('setting', function(){config(['site.wap_footer' => 'me']); return view('wap.setting.index');})->name('wap.setting');
    $router->post('change_password', 'IndexController@change_password')->name('wap.change_password');
    $router->post('change_passcode', 'IndexController@change_passcode')->name('wap.change_passcode');
    $router->post('change_name', 'IndexController@change_name')->name('wap.change_name');
    $router->get('memo', 'IndexController@memo')->name('wap.memo');

    $router->post('transfer_credit', 'IndexController@transfer_credit')->name('wap.transfer_credit');
    $router->get('read_bonus', 'IndexController@read_bonus');
});

Route::group(['namespace' => 'Web'],function ($router){
    $router->get('home', 'IndexController@index')->name('web.index');
    $router->get('profile', 'IndexController@profile')->name('web.profile');
    $router->post('change_password', 'IndexController@change_password')->name('web.change_password');
    $router->get('memo', 'IndexController@memo')->name('web.memo');
    $router->post('save_memo', 'IndexController@save_memo')->name('web.save_memo');
    $router->any('wallet', 'IndexController@wallet')->name('web.wallet');
    $router->get('deposit', 'IndexController@deposit')->name('web.deposit');
    $router->get('withdraw', 'IndexController@withdraw')->name('web.withdraw');
    $router->get('transfer', 'IndexController@transfer')->name('web.transfer');
    $router->get('bank_account', 'IndexController@bank_account')->name('web.bank_account');
    $router->get('casino', 'GameController@casino')->name('web.casino');
    $router->get('hot_game', 'GameController@hot_game')->name('web.hot_game');
    $router->get('lottery', 'GameController@lottery')->name('web.lottery');
    $router->get('promotion', 'GameController@promotion')->name('web.promotion');
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function ($router){
    $router->get('/', 'LoginController@showLoginForm')->name('admin.index');

    $router->get('login', 'LoginController@showLoginForm')->name('admin.login');
    $router->post('login', ['as'=>'admin.login','uses'=>'LoginController@login']);
    $router->get('logout', ['as' => 'admin.logout','uses' => 'LoginController@logout']);

    $router->get('dashboard', 'AdminController@index')->name('admin.home');
    $router->get('change_password', function(){return view('admin.change_password');})->name('admin.change_password');
    $router->post('change_password', 'AdminController@change_password')->name('admin.change_password');

    $router->any('user/index', 'UserController@index')->name('admin.user.index');
    $router->post('agent/create', 'UserController@create_agent')->name('admin.agent.create');
    $router->post('agent/edit', 'UserController@edit_agent')->name('admin.agent.edit');
    $router->get('agent/delete/{id}', 'UserController@delete_agent')->name('admin.agent.delete');    
    $router->post('player/create', 'UserController@create_user')->name('admin.user.create');
    $router->post('player/edit', 'UserController@edit_user')->name('admin.user.edit');
    $router->get('player/delete/{id}', 'UserController@delete_user')->name('admin.user.delete');
    $router->any('set_score/{role}/{id}', 'UserController@set_score')->name('admin.set_score');
    $router->post('save_score', 'UserController@save_score')->name('admin.save_score');
    
    $router->any('deposit/index', 'DepositController@index')->name('admin.deposit.index');
    $router->post('deposit/create', 'DepositController@crate')->name('admin.deposit.create');
    $router->post('deposit/confirm', 'DepositController@confirm')->name('admin.deposit.confirm');
    $router->post('deposit/fail', 'DepositController@fail')->name('admin.deposit.fail');
    $router->get('deposit/delete/{id}', 'DepositController@delete')->name('admin.deposit.delete');

    $router->any('withdraw/index', 'WithdrawController@index')->name('admin.withdraw.index');
    $router->post('withdraw/create', 'WithdrawController@crate')->name('admin.withdraw.create');
    $router->post('withdraw/confirm', 'WithdrawController@confirm')->name('admin.withdraw.confirm');
    $router->post('withdraw/fail', 'WithdrawController@fail')->name('admin.withdraw.fail');
    $router->get('withdraw/delete/{id}', 'WithdrawController@delete')->name('admin.withdraw.delete');
    
    $router->any('bank/index', 'BankController@index')->name('admin.bank.index');
    $router->post('bank/create', 'BankController@create')->name('admin.bank.create');
    $router->post('bank/edit', 'BankController@edit')->name('admin.bank.edit');
    $router->get('bank/delete/{id}', 'BankController@delete')->name('admin.bank.delete'); 
    
    $router->any('game/index', 'GameController@index')->name('admin.game.index');
    $router->post('game/create', 'GameController@create')->name('admin.game.create');
    $router->post('game/edit', 'GameController@edit')->name('admin.game.edit');
    $router->get('game/delete/{id}', 'GameController@delete')->name('admin.game.delete'); 

    $router->resource('promotion', 'PromotionController');
    
    $router->any('credit_transaction/index', 'AdminController@credit_transaction')->name('admin.credit_transaction.index');

    $router->any('game_transaction', 'AdminController@game_transaction')->name('admin.game_transaction');
    $router->any('activity/index', 'AdminController@activity')->name('admin.activity');

    $router->get('bonus', 'AdminController@bonus')->name('admin.bonus');
    $router->post('set_bonus', 'AdminController@set_bonus')->name('admin.set_bonus');

    $router->any('game_account/index', 'AdminController@game_account1')->name('admin.game_account.index');
    $router->any('report/total/{id?}', 'ReportController@total_report')->name('admin.report.total');
    $router->any('report/agent/{id}', 'ReportController@agent_report')->name('admin.report.agent');
    $router->any('report/user/{id}', 'ReportController@user_report')->name('admin.report.user');

    $router->post('setting/withdraw_flag', 'SettingController@withdraw_flag')->name('admin.setting.withdraw_flag');
    $router->post('setting/deposit_flag', 'SettingController@deposit_flag')->name('admin.setting.deposit_flag');
    $router->get('setting', 'SettingController@index')->name('admin.setting');
    $router->post('save_setting', 'SettingController@save_setting')->name('admin.save_setting');

});


$router->get('agent/check_passcode', 'Agent\LoginController@check_passcode')->name('agent.check_passcode');
$router->post('agent/post_check_passcode', 'Agent\LoginController@post_check_passcode')->name('agent.post_check_passcode');

Route::group(['prefix' => 'agent','namespace' => 'Agent', 'middleware' => 'agent_passcode'],function ($router){
    $router->get('login', 'LoginController@showLoginForm')->name('agent.login');
    $router->post('login', ['as'=>'agent.login','uses'=>'LoginController@login']);
    $router->get('logout', ['as' => 'agent.logout','uses' => 'LoginController@logout']);

    $router->post('agent/save_passcode', 'AgentController@save_passcode')->name('agent.save_passcode');
    
    $router->get('/', 'LoginController@check_passcode')->name('agent.index');

    $router->any('wap/index', 'WapController@index')->name('agent.wap.index');
    $router->any('wap/player_transfer/{id}', 'WapController@player_transfer')->name('agent.wap.player_transfer');
    $router->any('wap/set_player/{id}', 'WapController@set_player')->name('agent.wap.set_player');

    $router->get('dashboard', 'AgentController@index')->name('agent.home');
    $router->get('change_password', function(){return view('agent.change_password');})->name('agent.change_password');
    $router->post('change_password', 'AgentController@change_password')->name('agent.change_password');

    $router->any('user/index', 'UserController@index')->name('agent.user.index');
    $router->post('agent/create', 'UserController@create_agent')->name('agent.agent.create');
    $router->post('agent/edit', 'UserController@edit_agent')->name('agent.agent.edit');
    $router->get('agent/delete/{id}', 'UserController@delete_agent')->name('agent.agent.delete');    
    $router->post('player/create', 'UserController@create_user')->name('agent.user.create');
    $router->post('player/edit', 'UserController@edit_user')->name('agent.user.edit');
    $router->get('player/delete/{id}', 'UserController@delete_user')->name('agent.user.delete');
    $router->post('send_credit_down', 'UserController@send_credit_down')->name('agent.send_credit_down');
    $router->post('send_credit_top', 'UserController@send_credit_top')->name('agent.send_credit_top');
    $router->any('set_score/{role}/{id}', 'UserController@set_score')->name('agent.set_score');
    $router->post('save_score', 'UserController@save_score')->name('agent.save_score');
    
    $router->any('deposit/index', 'DepositController@index')->name('agent.deposit.index');
    $router->post('deposit/create', 'DepositController@crate')->name('agent.deposit.create');
    $router->post('deposit/confirm', 'DepositController@confirm')->name('agent.deposit.confirm');
    $router->post('deposit/fail', 'DepositController@fail')->name('agent.deposit.fail');
    $router->get('deposit/delete/{id}', 'DepositController@delete')->name('agent.deposit.delete');

    $router->any('withdraw/index', 'WithdrawController@index')->name('agent.withdraw.index');
    $router->post('withdraw/create', 'WithdrawController@crate')->name('agent.withdraw.create');
    $router->post('withdraw/confirm', 'WithdrawController@confirm')->name('agent.withdraw.confirm');
    $router->post('withdraw/fail', 'WithdrawController@fail')->name('agent.withdraw.fail');
    $router->get('withdraw/delete/{id}', 'WithdrawController@delete')->name('agent.withdraw.delete');

    $router->any('credit_transaction/index', 'AgentController@credit_transaction')->name('agent.credit_transaction.index');
    $router->any('game_transaction', 'AgentController@game_transaction')->name('agent.game_transaction');
    $router->any('game_account/index', 'AgentController@game_account1')->name('agent.game_account.index');
    $router->any('activity/index', 'AgentController@activity')->name('agent.activity');

    $router->any('report/agent/{id}', 'ReportController@agent_report')->name('agent.report.agent');
    $router->any('report/user/{id}', 'ReportController@user_report')->name('agent.report.user');
    $router->get('memo', 'AgentController@memo')->name('agent.memo');   
    $router->post('save_memo', 'AgentController@save_memo')->name('agent.save_memo');   

});

Route::group(['prefix' => 'game', 'namespace' => 'Game'],function ($router){
    $router->get('open/{id}', 'GameController@open')->name('game.open');
    $router->post('deposit', 'GameController@deposit')->name('game.deposit');
    $router->post('withdraw', 'GameController@withdraw')->name('game.withdraw');
    $router->post('total_withdraw', 'GameController@total_withdraw')->name('game.total_withdraw');
    $router->any('play/{id}', 'GameController@play')->name('game.play');
    $router->post('balance_refresh', 'GameController@balance_refresh')->name('game.balance_refresh');
    $router->any('game_transaction_history/{id}', 'GameController@transaction_history')->name('game.transaction_history');

    $router->get('xe88', 'GameController@xe88')->name('game.xe88.index');
    $router->get('xe88_play', 'GameController@xe88_play')->name('game.xe88.play');
    $router->any('mega/callback', 'GameController@mega888_callback')->name('game.mega.callback');
    $router->get('mega888', 'GameController@mega888')->name('game.mega.index');
    $router->get('mega888_play', 'GameController@mega888_play')->name('game.mega888.play');
    $router->get('mega888_player_info', 'GameController@mega888_player_info')->name('game.mega888.player.info');
    $router->get('gi998', 'GameController@gi998')->name('game.gi998.index');
    $router->get('gi998_play', 'GameController@gi998_play')->name('game.gi998.play');
    $router->get('goldenf', 'GameController@godenf')->name('game.goldenf.index');
    $router->get('goldenf_list', 'GameController@goldenf_list')->name('game.goldenf.list');
    $router->get('goldenf_play', 'GameController@goldenf_play')->name('game.goldenf.play');
    $router->get('scr2_update', 'GameController@scr2_update_player_info')->name('game.scr2.update_player_info');
    $router->get('playtech_play', 'GameController@playtech_play')->name('game.playtech.play');
    $router->get('joker_play', 'GameController@joker_play')->name('game.joker.play');
});

Route::any('api/mega/callback', 'Game\GameController@mega888_callback');
