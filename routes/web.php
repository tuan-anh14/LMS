<?php

use Illuminate\Support\Facades\Route;


/*Route::get('/', 'WelcomeController@index')->name('welcome');*/
// Route::get('/home', 'HomeController@index')->name('home');

//index
Route::get('/', 'WebController@index')->name('/');

//courses
Route::get('/courses', 'WebController@courses')->name('courses');

//single course
Route::get('/course/{id}', 'WebController@single_course')->name('course.show');

//about-us
Route::get('/about-us', 'WebController@about_us')->name('about-us');

//contact-us
Route::get('/contact-us', 'WebController@contact_us')->name('contact-us');

//contact-us
Route::get('/visuals', 'WebController@visuals')->name('visuals');

//inquiries
Route::post('/contact', 'WebController@inquiries')->name('contact.post');

Auth::routes();

