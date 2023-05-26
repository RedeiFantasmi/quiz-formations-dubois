<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/xdebug' => [[['_route' => '_profiler_xdebug', '_controller' => 'web_profiler.controller.profiler::xdebugAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
        '/copie' => [[['_route' => 'app_copie', '_controller' => 'App\\Controller\\CopieController::index'], null, null, null, false, false, null]],
        '/copie/create' => [[['_route' => 'app_copie_create', '_controller' => 'App\\Controller\\CopieController::createCopie'], null, ['POST' => 0], null, false, false, null]],
        '/evaluation' => [[['_route' => 'app_evaluation', '_controller' => 'App\\Controller\\EvaluationController::index'], null, null, null, false, false, null]],
        '/evaluation/create' => [[['_route' => 'app_evaluation_create', '_controller' => 'App\\Controller\\EvaluationController::createEvaluation'], null, ['POST' => 0], null, false, false, null]],
        '/login' => [[['_route' => 'app_login', '_controller' => 'App\\Controller\\LoginController::index'], null, ['POST' => 0], null, false, false, null]],
        '/logout' => [[['_route' => 'app_logout', '_controller' => 'App\\Controller\\LoginController::logout'], null, null, null, false, false, null]],
        '/question' => [[['_route' => 'app_question', '_controller' => 'App\\Controller\\QuestionController::index'], null, null, null, false, false, null]],
        '/question/create' => [[['_route' => 'app_question_create', '_controller' => 'App\\Controller\\QuestionController::createQuestion'], null, ['POST' => 0], null, false, false, null]],
        '/quiz' => [[['_route' => 'app_quiz', '_controller' => 'App\\Controller\\QuizController::index'], null, null, null, false, false, null]],
        '/quiz/create' => [[['_route' => 'app_quiz_create', '_controller' => 'App\\Controller\\QuizController::createQuiz'], null, ['POST' => 0], null, false, false, null]],
        '/user' => [[['_route' => 'app_user', '_controller' => 'App\\Controller\\UserController::index'], null, null, null, false, false, null]],
        '/user/get' => [[['_route' => 'app_user_get', '_controller' => 'App\\Controller\\UserController::fetchUsers'], null, ['GET' => 0], null, false, false, null]],
        '/user/create' => [[['_route' => 'app_user_create', '_controller' => 'App\\Controller\\UserController::addUser'], null, ['POST' => 0], null, false, false, null]],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/([^/]++)(?'
                        .'|/(?'
                            .'|search/results(*:102)'
                            .'|router(*:116)'
                            .'|exception(?'
                                .'|(*:136)'
                                .'|\\.css(*:149)'
                            .')'
                        .')'
                        .'|(*:159)'
                    .')'
                .')'
                .'|/evaluation/([^/]++)/(?'
                    .'|edit(*:197)'
                    .'|delete(*:211)'
                .')'
                .'|/qu(?'
                    .'|estion/([^/]++)/(?'
                        .'|edit(*:249)'
                        .'|delete(*:263)'
                    .')'
                    .'|iz/([^/]++)/(?'
                        .'|edit(*:291)'
                        .'|delete(*:305)'
                    .')'
                .')'
                .'|/user/([^/]++)/(?'
                    .'|edit(*:337)'
                    .'|delete(*:351)'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        102 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        116 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        136 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        149 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        159 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        197 => [[['_route' => 'app_evaluation_edit', '_controller' => 'App\\Controller\\EvaluationController::editEvaluation'], ['id'], ['POST' => 0], null, false, false, null]],
        211 => [[['_route' => 'app_evaluation_delete', '_controller' => 'App\\Controller\\EvaluationController::deleteEvaluation'], ['id'], ['DELETE' => 0], null, false, false, null]],
        249 => [[['_route' => 'app_question_edit', '_controller' => 'App\\Controller\\QuestionController::editQuestion'], ['id'], ['POST' => 0], null, false, false, null]],
        263 => [[['_route' => 'app_question_delete', '_controller' => 'App\\Controller\\QuestionController::deleteQuestion'], ['id'], ['DELETE' => 0], null, false, false, null]],
        291 => [[['_route' => 'app_quiz_edit', '_controller' => 'App\\Controller\\QuizController::editQuiz'], ['id'], ['POST' => 0], null, false, false, null]],
        305 => [[['_route' => 'app_quiz_delete', '_controller' => 'App\\Controller\\QuizController::deleteQuiz'], ['id'], ['DELETE' => 0], null, false, false, null]],
        337 => [[['_route' => 'app_user_edit', '_controller' => 'App\\Controller\\UserController::editUser'], ['id'], ['PUT' => 0], null, false, false, null]],
        351 => [
            [['_route' => 'app_user_delete', '_controller' => 'App\\Controller\\UserController::deleteUser'], ['id'], ['DELETE' => 0], null, false, false, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
