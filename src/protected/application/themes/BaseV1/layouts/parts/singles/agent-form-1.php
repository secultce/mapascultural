<div class="ficha-spcultura"> 
    <h3><?php \MapasCulturais\i::_e("Dados Pessoais");?></h3>
    
    <?php $this->applyTemplateHook('tab-about-service','before'); ?><!--. hook tab-about-service:before -->

    <div class="servico">
        <?php $this->applyTemplateHook('tab-about-service','begin'); ?><!--. hook tab-about-service:begin -->
        <?php if($this->isEditable()): ?>
            <!-- Campo Nome Completo -->
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label"><?php \MapasCulturais\i::_e("Nome Completo");?>:</span>
                <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"nomeCompleto") && $editEntity? 'required': '');?>" data-edit="nomeCompleto" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Nome Completo ou Razão Social");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Informe seu nome completo ou razão social");?>">
                    <?php echo $entity->nomeCompleto; ?>
                </span>
            </p>
       
        <?php if($this->isEditable()): ?>
            <!-- Campo CPF -->
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label"><?php \MapasCulturais\i::_e("CPF");?>:</span>
                <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"documento") && $editEntity? 'required': '');?>" data-edit="documento" data-original-title="<?php \MapasCulturais\i::esc_attr_e("CPF");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Informe seu CPF  com pontos, hífens e barras");?>">
                    <?php echo $entity->documento; ?>
                </span>
            </p>
        <? endif; ?>
            <?php if($this->isEditable()): ?>
                <!-- E-mail privado-->
                <p class="privado"><span class="icon icon-private-info"></span>
                    <span class="label"><?php \MapasCulturais\i::_e("Email Privado");?>:</span>
                    <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"emailPrivado") && $editEntity? 'required': '');?>" data-edit="emailPrivado" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Email Privado");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira um email que não será exibido publicamente");?>">
                        <?php echo $entity->emailPrivado; ?>
                    </span>
                </p>
            <? endif; ?>
        <?php endif; ?>
                
        <!-- Email Público -->
        <?php if($this->isEditable() || $entity->emailPublico): ?>
            <p><span class="label"><?php \MapasCulturais\i::_e("E-mail");?>:</span>
                <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"emailPublico") && $this->isEditable()? 'required': '');?>" data-edit="emailPublico" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Email Público");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira um email que será exibido publicamente");?>">
                    <?php echo $entity->emailPublico; ?>
                </span>
            </p>
        <?php endif; ?>
        
        <!-- Telefone Público -->
        <?php if($this->isEditable() || $entity->telefonePublico): ?>
            <p><span class="label"><?php \MapasCulturais\i::_e("Telefone Público");?>:</span>
                <span class="js-editable js-mask-phone <?php echo ($entity->isPropertyRequired($entity,"telefonePublico") && $this->isEditable()? 'required': '');?>" data-edit="telefonePublico" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Telefone Público");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira um telefone que será exibido publicamente");?>">
                    <?php echo $entity->telefonePublico; ?>
                </span>
            </p>
        <?php endif; ?>
        <?php if($this->isEditable()): ?>
            <!-- Telefone Privado 1 -->
            <p class="privado"><span class="icon icon-private-info"></span>
                <span class="label"><?php \MapasCulturais\i::_e("Telefone 1");?>:</span>
                <span class="js-editable js-mask-phone <?php echo ($entity->isPropertyRequired($entity,"telefone1") && $this->isEditable()? 'required': '');?>" data-edit="telefone1" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Telefone Privado");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira um telefone que não será exibido publicamente");?>">
                    <?php echo $entity->telefone1; ?>
                </span>
            </p>
            <!-- Telefone Privado 2 -->
            <p class="privado"><span class="icon icon-private-info"></span>
                <span class="label"><?php \MapasCulturais\i::_e("Telefone 2");?>:</span>
                <span class="js-editable js-mask-phone <?php echo ($entity->isPropertyRequired($entity,"telefone2") && $this->isEditable()? 'required': '');?>" data-edit="telefone2" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Telefone Privado");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira um telefone que não será exibido publicamente");?>">
                    <?php echo $entity->telefone2; ?>
                </span>
            </p>

        <?php endif; ?>
        
        <?php $this->part('singles/location', ['entity' => $entity, 'has_private_location' => true]); ?><!--.part/singles/location.php -->
        <?php $this->applyTemplateHook('tab-about-service','end'); ?><!--. hook tab-about-service:end -->
    
    </div><!--.servico -->

    <?php $this->applyTemplateHook('tab-about-service','after'); ?><!--. hook tab-about-service:after -->

</div>
<div class="ficha-spcultura"> 
    <h3><?php \MapasCulturais\i::_e("Dados Pessoais Sensíveis");?></h3>
    <div class="servico">
    <!-- Campo Data de Nascimento  -->
    <p class="privado">
        <span class="icon icon-private-info"></span>
        <span class="label"><?php \MapasCulturais\i::_e("Data de Nascimento");?>:</span>
        <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"dataDeNascimento") && $this->isEditable()? 'required': '');?>" <?php echo $entity->dataDeNascimento ? "data-value='".$entity->dataDeNascimento . "'" : ''?>  data-type="date" data-edit="dataDeNascimento" data-viewformat="dd/mm/yyyy" data-showbuttons="false" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Data de Nascimento");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Insira a data de nascimento");?>">
        <?php $dtN = (new DateTime)->createFromFormat('Y-m-d', $entity->dataDeNascimento); echo $dtN ? $dtN->format('d/m/Y') : ''; ?>
        </span>
    </p>
    <!-- Gênero -->
    <p class="privado">
        <span class="icon icon-private-info"></span>
        <span class="label"><?php \MapasCulturais\i::_e("Gênero");?>:</span>
        <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"genero") && $editEntity? 'required': '');?>" data-edit="genero" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Gênero");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Selecione o gênero se for pessoa física");?>">
            <?php echo $entity->genero; ?>
        </span>
    </p>
    <!-- Orientação Sexual -->
    <p class="privado"><span class="icon icon-private-info"></span>
        <span class="label"><?php \MapasCulturais\i::_e("Orientação Sexual");?>:</span>
        <span class="js-editable <?php echo ($entity->isPropertyRequired($entity,"orientacaoSexual") && $editEntity? 'required': '');?>" data-edit="orientacaoSexual" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Orientação Sexual");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Selecione uma orientação sexual se for pessoa física");?>">
            <?php echo $entity->orientacaoSexual; ?>
        </span>
    </p> 
        <!-- Raça/Cor -->
        <p class="privado"><span class="icon icon-private-info"></span>
        <span class="label"><?php \MapasCulturais\i::_e("Raça/Cor");?>:</span>
        <span class="js-editable  <?php echo ($entity->isPropertyRequired($entity,"raca") && $editEntity? 'required': '');?>" data-edit="raca" data-original-title="<?php \MapasCulturais\i::esc_attr_e("Raça/cor");?>" data-emptytext="<?php \MapasCulturais\i::esc_attr_e("Selecione a raça/cor se for pessoa física");?>">
            <?php echo $entity->raca; ?>
        </span>
        </p>
        </div>
</div>