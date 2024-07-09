describe("NavbarCompact", () => {
  beforeEach(() => {
    cy.viewport(1000, 768);
    cy.visit("/");
  });

  it("Garante o funcionamento da navbar compacta", () => {
    cy.get(".mc-header-menu__btn-mobile").click();
    cy.contains(".mc-header-menu__itens a", "Home").click();
    cy.url().should("include", "");

    cy.get(".mc-header-menu__btn-mobile").click();
    cy.contains(".mc-header-menu__itens a", "Oportunidades").click();
    cy.url().should("include", "oportunidades");

    cy.get(".mc-header-menu__btn-mobile").click();
    cy.contains(".mc-header-menu__itens a", "Agentes").click();
    cy.url().should("include", "agentes");

    cy.get(".mc-header-menu__btn-mobile").click();
    cy.contains(".mc-header-menu__itens a", "Eventos").click();
    cy.url().should("include", "eventos");

    cy.get(".mc-header-menu__btn-mobile").click();
    cy.contains(".mc-header-menu__itens a", "Espaços").click();
    cy.url().should("include", "espacos");

    cy.get(".mc-header-menu__btn-mobile").click();
    cy.contains(".mc-header-menu__itens a", "Projetos").click();
    cy.url().should("include", "projetos");
  });
});
