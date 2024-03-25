<?php

declare(strict_types=1);

namespace MapasCulturais\Controllers;

use MapasCulturais\App;
use MapasCulturais\i;
use MapasCulturais\Traits;

class Documentation extends \MapasCulturais\Controller {
    use \MapasCulturais\Traits\ControllerAPI;
    
    function GET_index(): void
    {
        $this->_layout = 'empty';
        $this->render('documentation');
    }
}
