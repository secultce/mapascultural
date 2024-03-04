<?php 
namespace ButtonRecourse\Controllers;
use MapasCulturais\App;

class ButtonRecourse extends \MapasCulturais\Controller {
   
    function GET_index() {
      $app = App::i();
      // echo "index";
      $entity = $app->repo('Agent')->find(1);
      // $opportunity = $this->requestedEntity;
     
       $this->render('index', ['entity' => $entity]);
    }
 }

