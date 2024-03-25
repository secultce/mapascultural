<?php

declare(strict_types=1);

namespace Documentation;

use MapasCulturais\App;
use MapasCulturais\Themes\BaseV2\Theme;

class Module extends \MapasCulturais\Module
{
    function __construct(array $config = [])
    {
        $app = App::i();
        if ($app->view instanceof Theme) {
            parent::__construct($config);
        }
    }

    function _init()
    {
    }

    function register(): void
    {
        $app = App::i();
        $controllers = $app->getRegisteredControllers();
        if (!isset($controllers['documentationModule'])) {
            $app->registerController('documentationModule', Controller::class);
        }
    }
}
