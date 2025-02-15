<?php

namespace MapasCulturais;

$app = App::i();
$agent_fields = $app->modules['RegistrationFieldTypes']->getAgentFields();
$definitions = [];
foreach (Entities\Agent::getPropertiesMetadata() as $key => $def) {
    if (in_array($key, $agent_fields)) {
        $def = (object) $def;
        if (empty($def->field_type)) {
            if (in_array($key, ['shortDescription', 'longDescription'])) {
                $def->field_type = 'textarea';
            } else {
                $def->field_type = 'text';
            }
        }

        if($def->field_type === "socialMedia"){
            $def->field_type = "url";
        }

        $definitions[$key] = $def;
    }
}
?>
<div ng-class="field.error ? 'invalidField': '' " ng-if="::field.fieldType === 'agent-owner-field'" id="field_{{::field.id}}">
    <span class="label">
        <i class="icon icon-agent"></i> 
        {{::field.title}}
        <div ng-if="requiredField(field)" class="field-required"><span class="description"><?php i::_e('obrigatório') ?></span><span class="icon-required">*</span></div>
    </span>
    
    <em class="relation-field-info">(<?php i::_e('Este campo será salvo no agente responsável pela inscrição') ?>)</em>

    <div ng-if="::field.description" class="attachment-description">{{::field.description}}</div>

    <?php $this->applyTemplateHook('registrationFieldTypes--agent-owner-field','before'); ?>
    <div ng-if="::field.config.entityField == '@location'">
        <?php $this->part('registration-field-types/fields/_location') ?>
    </div>
    <div ng-if="::field.config.entityField == '@links'">
        <?php $this->part('registration-field-types/fields/links') ?>
    </div>
    <div ng-if="::field.config.entityField == '@terms:area'">
        <?php $this->part('registration-field-types/fields/checkboxes') ?>
    </div>
    <div ng-if="::field.config.entityField == '@bankFields'">
        <?php $this->part('registration-field-types/fields/bankFields') ?>
    </div>
    <?php $this->applyTemplateHook('registrationFieldTypes--agent-owner-field','after'); ?>
    
    <?php foreach ($definitions as $key => $def) :  ?>
        <?php $type = $key == 'documento' ? 'cpf' : $def->field_type;  ?>
        <div ng-if="::field.config.entityField == '<?= $key ?>'">
            <?php $this->part('registration-field-types/fields/' . $type) ?>
        </div>
    <?php endforeach; ?>

</div>