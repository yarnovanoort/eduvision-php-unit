<?php

// register routes
$router->map('GET', '/register', 'Phpunittest\Controllers\RegisterController@getShowRegisterPage', 'register');
$router->map('POST', '/register', 'Phpunittest\Controllers\RegisterController@postShowRegisterPage', 'register_post');
$router->map('GET', '/verify-account', 'Phpunittest\Controllers\RegisterController@getVerifyAccount', 'verify_account');

// testimonial routes
$router->map('GET', '/testimonials', 'Phpunittest\Controllers\TestimonialController@getShowTestimonials', 'testimonials');

// logged in user routes
if (Phpunittest\auth\LoggedIn::user()) {
    $router->map('GET', '/add-testimonial', 'Phpunittest\Controllers\TestimonialController@getShowAdd', 'add_testimonial');
    $router->map('POST', '/add-testimonial', 'Phpunittest\Controllers\TestimonialController@postShowAdd', 'add_testimonial_post');
}

// login/logout routes
$router->map('GET', '/login', 'Phpunittest\Controllers\AuthenticationController@getShowLoginPage', 'login');
$router->map('POST', '/login', 'Phpunittest\Controllers\AuthenticationController@postShowLoginPage', 'login_post');
$router->map('GET', '/logout', 'Phpunittest\Controllers\AuthenticationController@getLogout', 'logout');

// admin routes
if ((Phpunittest\auth\LoggedIn::user()) && (Phpunittest\auth\LoggedIn::user()->access_level == 2)) {
    $router->map('POST', '/admin/page/edit', 'Phpunittest\Controllers\AdminController@postSavePage', 'save_page');
    $router->map('GET', '/admin/page/add', 'Phpunittest\Controllers\AdminController@getAddPage', 'add_page');
}

// page routes
$router->map('GET', '/test', 'Phpunittest\Controllers\PageController@getTest', 'test');
$router->map('GET', '/', 'Phpunittest\Controllers\PageController@getShowHomePage', 'home');
$router->map('GET', '/page-not-found', 'Phpunittest\Controllers\PageController@getShow404', '404');
$router->map('GET', '/[*]', 'Phpunittest\Controllers\PageController@getShowPage', 'generic_page');
