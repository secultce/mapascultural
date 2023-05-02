app.component('opportunity-phases-config', {
    template: $TEMPLATES['opportunity-phases-config'],
    
    // define os eventos que este componente emite
    emits: ['newPhase', 'newDataCollectionPhase', 'newEvaluationPhase'],

    props: {
        entity: {
            type: Entity,
            required: true
        },
    },

    setup() { 
        // os textos estão localizados no arquivo texts.php deste componente 
        const text = Utils.getTexts('opportunity-phases-config')
        return { text }
    },

    async created() {
        if($MAPAS.opportunityPhases && $MAPAS.opportunityPhases.length > 0) {
            this.phases = $MAPAS.opportunityPhases;
        } else {
            const api = new OpportunitiesAPI();
            this.phases = await api.getPhases(this.entity.id);
        }
    },

    data() {
        return {
            phases: [],
            evaluationMethods: $MAPAS.config.evaluationMethods,
            evaluationTypes: $DESCRIPTIONS.evaluationmethodconfiguration.type.options
        }
    },
    methods: {
        addInPhases (phase) {
            this.phases.splice(this.phases.length - 1, 0, phase);
        },
        showPublishTimestamp(phase) {
            const previousPhase = this.getPreviousPhase(phase);
            const nextPhase = this.getNextPhase(phase);

            if (phase.isLastPhase) {
                return true;
            } else if (phase.__objectType == 'opportunity' && nextPhase.__objectType != 'evaluationmethodconfiguration' && phase.publishTimestamp) {
                return true;
            } else if (phase.__objectType == 'evaluationmethodconfiguration' && previousPhase.__objectType == 'opportunity' && previousPhase.publishTimestamp) {
                return true;
            } else {
                return false;
            }
        },
        publishTimestamp(phase) {
            if (phase.__objectType == 'opportunity') {
                return phase.publishTimestamp;
            } 
            
            if (phase.__objectType == 'evaluationmethodconfiguration') {
                return phase.opportunity.publishTimestamp;
            }
        },

        getPreviousPhase(phase) {
            const index = this.phases.indexOf(phase);
            return this.phases[index - 1];
        },

        getNextPhase(phase) {
            const index = this.phases.indexOf(phase);
            return this.phases[index + 1];
        }
    },
});
