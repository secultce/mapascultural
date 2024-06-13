describe('Swagger Documentation Page Test', () => {
    beforeEach(() => {
        cy.visit("/mapas/docs/v2");
    });

    it('should load the documentation page without errors', () => {
        cy.visit(url);

        cy.get('.errors-wrapper').should('not.exist');

        cy.contains('API Mapas Culturais V2 - OpenAPI 3.0').should('be.visible');
        cy.contains('GET /agents').should('be.visible');
        cy.contains('POST /agents').should('be.visible');
        cy.contains('GET /agents/{id}').should('be.visible');
        cy.contains('PATCH /agents/{id}').should('be.visible');
        cy.contains('DELETE /agents/{id}').should('be.visible');
    });
});
