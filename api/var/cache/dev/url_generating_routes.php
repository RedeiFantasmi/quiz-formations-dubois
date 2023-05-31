<?php

// This file has been auto-generated by the Symfony Routing Component.

return [
    '_preview_error' => [['code', '_format'], ['_controller' => 'error_controller::preview', '_format' => 'html'], ['code' => '\\d+'], [['variable', '.', '[^/]++', '_format', true], ['variable', '/', '\\d+', 'code', true], ['text', '/_error']], [], [], []],
    '_wdt' => [['token'], ['_controller' => 'web_profiler.controller.profiler::toolbarAction'], [], [['variable', '/', '[^/]++', 'token', true], ['text', '/_wdt']], [], [], []],
    '_profiler_home' => [[], ['_controller' => 'web_profiler.controller.profiler::homeAction'], [], [['text', '/_profiler/']], [], [], []],
    '_profiler_search' => [[], ['_controller' => 'web_profiler.controller.profiler::searchAction'], [], [['text', '/_profiler/search']], [], [], []],
    '_profiler_search_bar' => [[], ['_controller' => 'web_profiler.controller.profiler::searchBarAction'], [], [['text', '/_profiler/search_bar']], [], [], []],
    '_profiler_phpinfo' => [[], ['_controller' => 'web_profiler.controller.profiler::phpinfoAction'], [], [['text', '/_profiler/phpinfo']], [], [], []],
    '_profiler_xdebug' => [[], ['_controller' => 'web_profiler.controller.profiler::xdebugAction'], [], [['text', '/_profiler/xdebug']], [], [], []],
    '_profiler_search_results' => [['token'], ['_controller' => 'web_profiler.controller.profiler::searchResultsAction'], [], [['text', '/search/results'], ['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], [], []],
    '_profiler_open_file' => [[], ['_controller' => 'web_profiler.controller.profiler::openAction'], [], [['text', '/_profiler/open']], [], [], []],
    '_profiler' => [['token'], ['_controller' => 'web_profiler.controller.profiler::panelAction'], [], [['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], [], []],
    '_profiler_router' => [['token'], ['_controller' => 'web_profiler.controller.router::panelAction'], [], [['text', '/router'], ['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], [], []],
    '_profiler_exception' => [['token'], ['_controller' => 'web_profiler.controller.exception_panel::body'], [], [['text', '/exception'], ['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], [], []],
    '_profiler_exception_css' => [['token'], ['_controller' => 'web_profiler.controller.exception_panel::stylesheet'], [], [['text', '/exception.css'], ['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], [], []],
    'app_copie' => [[], ['_controller' => 'App\\Controller\\CopieController::index'], [], [['text', '/copie']], [], [], []],
    'app_copie_create' => [[], ['_controller' => 'App\\Controller\\CopieController::createCopie'], [], [['text', '/copie/create']], [], [], []],
    'app_reponse_create' => [['id'], ['_controller' => 'App\\Controller\\CopieController::reponse'], [], [['text', '/reponse/add'], ['variable', '/', '[^/]++', 'id', true], ['text', '/copie']], [], [], []],
    'app_evaluation' => [[], ['_controller' => 'App\\Controller\\EvaluationController::index'], [], [['text', '/evaluation']], [], [], []],
    'app_evaluation_data' => [['id'], ['_controller' => 'App\\Controller\\EvaluationController::getEvaluationData'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/evaluation']], [], [], []],
    'app_evaluation_create' => [[], ['_controller' => 'App\\Controller\\EvaluationController::createEvaluation'], [], [['text', '/evaluation/create']], [], [], []],
    'app_evaluation_edit' => [['id'], ['_controller' => 'App\\Controller\\EvaluationController::editEvaluation'], [], [['text', '/edit'], ['variable', '/', '[^/]++', 'id', true], ['text', '/evaluation']], [], [], []],
    'app_evaluation_delete' => [['id'], ['_controller' => 'App\\Controller\\EvaluationController::deleteEvaluation'], [], [['text', '/delete'], ['variable', '/', '[^/]++', 'id', true], ['text', '/evaluation']], [], [], []],
    'app_login' => [[], ['_controller' => 'App\\Controller\\LoginController::index'], [], [['text', '/login']], [], [], []],
    'app_logout' => [[], ['_controller' => 'App\\Controller\\LoginController::logout'], [], [['text', '/logout']], [], [], []],
    'app_question' => [[], ['_controller' => 'App\\Controller\\QuestionController::index'], [], [['text', '/question']], [], [], []],
    'app_question_create' => [[], ['_controller' => 'App\\Controller\\QuestionController::createQuestion'], [], [['text', '/question/create']], [], [], []],
    'app_question_edit' => [['id'], ['_controller' => 'App\\Controller\\QuestionController::editQuestion'], [], [['text', '/edit'], ['variable', '/', '[^/]++', 'id', true], ['text', '/question']], [], [], []],
    'app_question_delete' => [['id'], ['_controller' => 'App\\Controller\\QuestionController::deleteQuestion'], [], [['text', '/delete'], ['variable', '/', '[^/]++', 'id', true], ['text', '/question']], [], [], []],
    'app_quiz' => [[], ['_controller' => 'App\\Controller\\QuizController::index'], [], [['text', '/quiz']], [], [], []],
    'app_quiz_create' => [[], ['_controller' => 'App\\Controller\\QuizController::createQuiz'], [], [['text', '/quiz/create']], [], [], []],
    'app_quiz_info' => [['id'], ['_controller' => 'App\\Controller\\QuizController::getQuizData'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/quiz']], [], [], []],
    'app_quiz_edit' => [['id'], ['_controller' => 'App\\Controller\\QuizController::editQuiz'], [], [['text', '/edit'], ['variable', '/', '[^/]++', 'id', true], ['text', '/quiz']], [], [], []],
    'app_quiz_delete' => [['id'], ['_controller' => 'App\\Controller\\QuizController::deleteQuiz'], [], [['text', '/delete'], ['variable', '/', '[^/]++', 'id', true], ['text', '/quiz']], [], [], []],
    'app_user' => [[], ['_controller' => 'App\\Controller\\UserController::index'], [], [['text', '/user']], [], [], []],
    'app_user_get' => [[], ['_controller' => 'App\\Controller\\UserController::fetchUsers'], [], [['text', '/user/get']], [], [], []],
    'app_user_create' => [[], ['_controller' => 'App\\Controller\\UserController::addUser'], [], [['text', '/user/create']], [], [], []],
    'app_user_edit' => [['id'], ['_controller' => 'App\\Controller\\UserController::editUser'], [], [['text', '/edit'], ['variable', '/', '[^/]++', 'id', true], ['text', '/user']], [], [], []],
    'app_user_delete' => [['id'], ['_controller' => 'App\\Controller\\UserController::deleteUser'], [], [['text', '/delete'], ['variable', '/', '[^/]++', 'id', true], ['text', '/user']], [], [], []],
];
