describe('Api V2 Documentation Page Test', () => {
    beforeEach(() => {
        cy.visit("/mapas/docs/v2");
    });

    it('should load the documentation page without errors', () => {
        cy.get('.errors-wrapper').should('not.exist');

        cy.contains('API Mapas Culturais V2 - OpenAPI 3.0').should('be.visible');
        cy.get('#operations-Agentes-get_agents > .opblock-summary > .opblock-summary-control').should('be.visible');
        cy.get('#operations-Agentes-post_agents > .opblock-summary > .opblock-summary-control').should('be.visible');
        cy.get('#operations-Agentes-get_agents__id_ > .opblock-summary > .opblock-summary-control').should('be.visible');
        cy.get('#operations-Agentes-patch_agents__id_ > .opblock-summary > .opblock-summary-control').should('be.visible');
        cy.get('#operations-Agentes-delete_agents__id_ > .opblock-summary > .opblock-summary-control').should('be.visible');
    });
});
