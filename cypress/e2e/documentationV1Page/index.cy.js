describe('Api V1 Documentation Page Test', () => {
    beforeEach(() => {
        cy.visit("/mapas/docs/v1");
    });

    it('should load the documentation page without errors', () => {
        cy.get('.errors-wrapper').should('not.exist');

        cy.contains('API Mapas Culturais - OpenAPI 3.0').should('be.visible');
        cy.get('#operations-Agentes-patch_agente__id_ > .opblock-summary').should('be.visible');
        cy.get('#operations-Agentes-delete_agente__id_ > .opblock-summary').should('be.visible');
        cy.get('#operations-Agentes-post_agent_index > .opblock-summary').should('be.visible');
        cy.get('#operations-Agentes-get_api_agent_find > .opblock-summary').should('be.visible');
    });
});
