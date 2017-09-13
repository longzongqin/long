<?php
//前台
Route::group(['namespace' => 'App','middleware' => 'user'],function (){
    Route::get('/','IndexController@index');
    Route::get('/index','IndexController@index');
    Route::get('/list/{id}','IndexController@list')->where(['id' => '[0-9]+']);
    Route::get('/listArticle/{id}','IndexController@listArticle')->where(['id' => '[0-9]+']);
    Route::get('/article/{id}','IndexController@article')->where(['id' => '[0-9]+']);
    Route::get('/search','IndexController@search');
    Route::post('/doSearch','IndexController@doSearch');
    Route::post('/addLog','IndexController@addLog');
});

//后台管理
Route::group(['namespace' => 'Admin','middleware' => 'admin'],function (){
    Route::get('/admin','AdminController@index');
    Route::get('/admin/category','AdminController@category');
    Route::get('/admin/article','AdminController@article');
    Route::get('/admin/addArticle','AdminController@addArticle');
    Route::post('/admin/addCategory','AdminController@addCategory');
    Route::post('/admin/moveCategory','AdminController@moveCategory');
    Route::post('/admin/modifyCategory','AdminController@modifyCategory');
    Route::post('/admin/delCategory','AdminController@delCategory');
    Route::get('/admin/createHtml','AdminController@createHtml');
    Route::get('/admin/param','AdminController@param');
    Route::post('/admin/saveParam','AdminController@saveParam');
    Route::post('/admin/delParam','AdminController@delParam');
    Route::post('/admin/updateStyle','AdminController@updateStyle');
    Route::post('/admin/doAddArticle','AdminController@doAddArticle');
    Route::post('/admin/loadArticle','AdminController@loadArticle');
    Route::post('/admin/delArticle','AdminController@delArticle');
    Route::get('/admin/categoryArticle/{id}','AdminController@categoryArticle')->where(['id' => '[0-9]+']);
    Route::post('/admin/saveCategoryArticle','AdminController@saveCategoryArticle');
    Route::post('/admin/doCreateHtml','AdminController@doCreateHtml');
});
//后台登陆
Route::group(['namespace' => 'Admin'],function (){
    Route::get('/admin/login','LoginController@index')->name("login");
    Route::post('/admin/doLogin','LoginController@doLogin');
});
Route::group(['namespace' => 'Common'],function (){
    Route::get('/error','CommonController@error')->name("error");
    Route::get('/common/getOssConfig','CommonController@getOssConfig');
    Route::post('/common/saveVideoUrl','CommonController@saveVideoUrl');
    Route::any('/async/updateArticleHtml','AsyncController@updateArticleHtml');
    Route::any('/async/addLog','AsyncController@addLog');
    Route::any('/async/addSiteMap','AsyncController@addSiteMap');

});



