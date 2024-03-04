/**
 * Vue Lifecycle
 * 1. setup
 * 2. beforeCreate
 * 3. created
 * 4. beforeMount
 * 5. mounted
 * 
 * // sempre que há modificação nos dados
 *  - beforeUpdate
 *  - updated
 * 
 * 6. beforeUnmount
 * 7. unmounted                  
 */

app.component('btn-recourse', {
    template: $TEMPLATES['btn-recourse'],
    
    // define os eventos que este componente emite
    props: {
        entity: {
            type: Entity,
            required: true
        },
    },
    
    setup(props, { slots }) {
        console.log(props.entity.name)
        const hasSlot = name => !!slots[name];
        // os textos estão localizados no arquivo texts.php deste componente 
        const text = Utils.getTexts('btn-recourse')
        return { text, hasSlot }
    },

    beforeCreate() { },
    created() { },

    beforeMount() { },
    mounted() { 
       
    },

    beforeUpdate() { },
    updated() { },

    beforeUnmount() {},
    unmounted() {},

    data() {
        return {
            displayName: 'Junior Oliveira',
           
        }
    },
    
    methods: {
        defineSertao () {
          console.log('teste')
        }
    },
});
