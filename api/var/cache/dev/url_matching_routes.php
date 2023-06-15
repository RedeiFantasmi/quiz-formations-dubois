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
        '/evaluation' => [[['_route' => 'app_evaluation', '_controller' => 'App\\Controller\\EvaluationController::index'], null, null, null, false, false, null]],
        '/evaluation/create' => [[['_route' => 'app_evaluation_create', '_controller' => 'App\\Controller\\EvaluationController::createEvaluation'], null, ['POST' => 0], null, false, false, null]],
        '/formation' => [[['_route' => 'app_formation', '_controller' => 'App\\Controller\\FormationController::index'], null, null, null, false, false, null]],
        '/accueil' => [[['_route' => 'app_home', '_controller' => 'App\\Controller\\HomeController::index'], null, null, null, false, false, null]],
        '/login' => [[['_route' => 'app_login', '_controller' => 'App\\Controller\\LoginController::index'], null, ['POST' => 0], null, false, false, null]],
        '/logout' => [[['_route' => 'app_logout', '_controller' => 'App\\Controller\\LoginController::logout'], null, null, null, false, false, null]],
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
                .'|/copie/([^/]++)(?'
                    .'|(*:187)'
                    .'|/(?'
                        .'|correct(*:206)'
                        .'|lock(*:218)'
                        .'|reponse/add(*:237)'
                    .')'
                .')'
                .'|/evaluation/([^/]++)/(?'
                    .'|edit(*:275)'
                    .'|delete(*:289)'
                    .'|lock(*:301)'
                    .'|copie/create(*:321)'
                .')'
                .'|/formation/([^/]++)/eleves(*:356)'
                .'|/qu(?'
                    .'|estion/([^/]++)/(?'
                        .'|edit(*:393)'
                        .'|delete(*:407)'
                    .')'
                    .'|iz/([^/]++)/(?'
                        .'|edit(*:435)'
                        .'|delete(*:449)'
                    .')'
                .')'
                .'|/user/([^/]++)/(?'
                    .'|edit(*:481)'
                    .'|delete(*:495)'
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
        187 => [[['_route' => 'app_copie_get_data', '_controller' => 'App\\Controller\\CopieController::index'], ['id'], null, null, false, true, null]],
        206 => [[['_route' => 'app_copie_correctcopie', '_controller' => 'App\\Controller\\CopieController::correctCopie'], ['id'], null, null, false, false, null]],
        218 => [[['_route' => 'app_copie_copielock', '_controller' => 'App\\Controller\\CopieController::copieLock'], ['id'], null, null, false, false, null]],
        237 => [[['_route' => 'app_reponse_create', '_controller' => 'App\\Controller\\CopieController::reponse'], ['id'], ['POST' => 0], null, false, false, null]],
        275 => [[['_route' => 'app_evaluation_edit', '_controller' => 'App\\Controller\\EvaluationController::editEvaluation'], ['id'], ['POST' => 0], null, false, false, null]],
        289 => [[['_route' => 'app_evaluation_delete', '_controller' => 'App\\Controller\\EvaluationController::deleteEvaluation'], ['id'], ['DELETE' => 0], null, false, false, null]],
        301 => [[['_route' => 'app_evaluation_lock', '_controller' => 'App\\Controller\\EvaluationController::lockEvaluation'], ['id'], ['POST' => 0], null, false, false, null]],
        321 => [[['_route' => 'app_evaluation_create_copie', '_controller' => 'App\\Controller\\EvaluationController::createCopie'], ['id'], ['POST' => 0], null, false, false, null]],
        356 => [[['_route' => 'app_formation_getformationeleves', '_controller' => 'App\\Controller\\FormationController::getFormationEleves'], ['id'], null, null, false, false, null]],
        393 => [[['_route' => 'app_question_edit', '_controller' => 'App\\Controller\\QuestionController::editQuestion'], ['id'], ['POST' => 0], null, false, false, null]],
        407 => [[['_route' => 'app_question_delete', '_controller' => 'App\\Controller\\QuestionController::deleteQuestion'], ['id'], ['DELETE' => 0], null, false, false, null]],
        435 => [[['_route' => 'app_quiz_edit', '_controller' => 'App\\Controller\\QuizController::editQuiz'], ['id'], ['POST' => 0], null, false, false, null]],
        449 => [[['_route' => 'app_quiz_delete', '_controller' => 'App\\Controller\\QuizController::deleteQuiz'], ['id'], ['DELETE' => 0], null, false, false, null]],
        481 => [[['_route' => 'app_user_edit', '_controller' => 'App\\Controller\\UserController::editUser'], ['id'], ['PUT' => 0], null, false, false, null]],
        495 => [
            [['_route' => 'app_user_delete', '_controller' => 'App\\Controller\\UserController::deleteUser'], ['id'], ['DELETE' => 0], null, false, false, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
