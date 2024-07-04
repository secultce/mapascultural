function acessProject () {
  it("clica em \"Acessar\" e entra na pagina no projeto selecionado", () => {
    cy.contains("h2", "Projeto de Cultura").should("exist");
    cy.get("a[href=\"http://localhost/projeto/1/\"]").contains("Acessar").click();
    cy.url().should("include", "/projeto/1");
    cy.contains("h1", "Projeto de Cultura").should("exist");
    cy.get(".metadata__id").should("exist");
    cy.get(".metadata > :nth-child(2)").should("exist");
    cy.get(".tabs-component__panels").should("exist");
  });
}

module.exports = { acessProject };

describe("Pagina de Projetos", () => {
  beforeEach(() => {
    cy.visit("/projetos");
  });

  acessProject();
});
