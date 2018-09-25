<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function(){
    return redirect('http://fhuiguide.com/');
});

// Login
$router->post('/login', 'UserController@login');
$router->post('/check-token', 'UserController@checkToken');

// Info Tugas
$router->get('/homeworks/{id}', 'HomeworkController@show');
$router->get('/homeworks', 'HomeworkController@index');

// Advografis
$router->get('/advografis/{id}', 'AdvografisController@show');
$router->get('/advografis', 'AdvografisController@index');

// Info BOP
$router->get('/bops/{id}', 'BopController@show');
$router->get('/bops', 'BopController@index');

// Info Beasiswa
$router->get('/scholarships/{id}', 'ScholarshipController@show');
$router->get('/scholarships', 'ScholarshipController@index');

// Info Lowongan Kerja
$router->get('/jobs/{id}', 'JobController@show');
$router->get('/jobs', 'JobController@index');

// Info Magang
$router->get('/internships/{id}', 'InternshipController@show');
$router->get('/internships', 'InternshipController@index');

// Company Profile
$router->get('/companies/{id}', 'CompanyController@show');
$router->get('/companies', 'CompanyController@index');

// Pengkarpedia
$router->get('/pengkarpedias/{id}', 'PengkarpediaController@show');
$router->get('/pengkarpedias', 'PengkarpediaController@index');

// Lapor
$router->post('/report', 'MailController@send');

// CV
$router->get('/cvs', 'CvController@index');
$router->post('/cvs', 'CvController@store');

// Fasilitator Lomba
$router->get('/competitions/{id}', 'CompetitionController@show');
$router->get('/competitions', 'CompetitionController@index');

// PKM Guide
$router->get('/pkms/{id}', 'PkmController@show');
$router->get('/pkms', 'PkmController@index');

// Rancangan Kuliah
$router->get('/course_plans/{id}/courses', 'CoursePlanController@showCourses');
$router->get('/course_plans/{id}', 'CoursePlanController@show');
$router->get('/course_plans', 'CoursePlanController@index');

// Mata Kuliah
$router->get('/courses/{id}', 'CourseController@show');
$router->get('/courses', 'CourseController@index');

// Materi Kuliah
$router->get('/course_materials/{id}', 'CourseMaterialController@show');
$router->get('/course_materials', 'CourseMaterialController@index');

// Bank Soal
$router->get('/course_problems/{id}', 'CourseProblemController@show');
$router->get('/course_problems', 'CourseProblemController@index');

// Latest Info
$router->get('/info', 'LatestInfoController@index');

// Lapor Advo
$router->post('/advo_reports', 'AdvoReportController@store');
$router->get('/advo_reports', 'AdvoReportController@index');


// Need login
$router->group(['middleware' => 'auth'], function () use ($router) {
  $router->delete('/advo_reports/{id}', 'AdvoReportController@destroy');

  $router->put('/info', 'LatestInfoController@update');

    $router->post('/course_problems', 'CourseProblemController@store');
    $router->put('/course_problems/{id}', 'CourseProblemController@update');
    $router->delete('/course_problems/{id}', 'CourseProblemController@destroy');

    $router->post('/course_materials', 'CourseMaterialController@store');
    $router->put('/course_materials/{id}', 'CourseMaterialController@update');
    $router->delete('/course_materials/{id}', 'CourseMaterialController@destroy');

    $router->post('/courses', 'CourseController@store');
    $router->put('/courses/{id}', 'CourseController@update');
    $router->delete('/courses/{id}', 'CourseController@destroy');

    $router->post('/course_plans', 'CoursePlanController@store');
    $router->put('/course_plans/{id}', 'CoursePlanController@update');
    $router->delete('/course_plans/{id}', 'CoursePlanController@destroy');

    $router->post('/pkms', 'PkmController@store');
    $router->put('/pkms/{id}', 'PkmController@update');
    $router->delete('/pkms/{id}', 'PkmController@destroy');

    $router->post('/competitions', 'CompetitionController@store');
    $router->put('/competitions/{id}', 'CompetitionController@update');
    $router->delete('/competitions/{id}', 'CompetitionController@destroy');

    $router->delete('/cvs/{id}', 'CvController@destroy');

    $router->post('/homeworks', 'HomeworkController@store');
    $router->put('/homeworks/{id}', 'HomeworkController@update');
    $router->delete('/homeworks/{id}', 'HomeworkController@destroy');

    $router->post('/advografis', 'AdvografisController@store');
    $router->put('/advografis/{id}', 'AdvografisController@update');
    $router->delete('/advografis/{id}', 'AdvografisController@destroy');

    $router->post('/bops', 'BopController@store');
    $router->put('/bops/{id}', 'BopController@update');
    $router->delete('/bops/{id}', 'BopController@destroy');

    $router->post('/scholarships', 'ScholarshipController@store');
    $router->put('/scholarships/{id}', 'ScholarshipController@update');
    $router->delete('/scholarships/{id}', 'ScholarshipController@destroy');

    $router->post('/jobs', 'JobController@store');
    $router->put('/jobs/{id}', 'JobController@update');
    $router->delete('/jobs/{id}', 'JobController@destroy');

    $router->post('/internships', 'InternshipController@store');
    $router->put('/internships/{id}', 'InternshipController@update');
    $router->delete('/internships/{id}', 'InternshipController@destroy');

    $router->post('/companies', 'CompanyController@store');
    $router->put('/companies/{id}', 'CompanyController@update');
    $router->delete('/companies/{id}', 'CompanyController@destroy');

    $router->post('/pengkarpedias', 'PengkarpediaController@store');
    $router->put('/pengkarpedias/{id}', 'PengkarpediaController@update');
    $router->delete('/pengkarpedias/{id}', 'PengkarpediaController@destroy');
});
