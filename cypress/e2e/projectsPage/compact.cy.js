const { acessProject } = require("./index.cy");

describe("Homepage compactada", () => {
  beforeEach(() => {
    cy.viewport(1000, 768);
    cy.visit("/");
  });

  it("acessa \"Projetos\" no navbar", () => {
    cy.get(".mc-header-menu__btn-mobile").click();
    cy.contains(".mc-header-menu__itens a", "Projetos").click();
    cy.url().should("include", "/projetos/");
  });
});

describe("Pagina de Projetos", () => {
  beforeEach(() => {
    cy.viewport(1000, 768);
    cy.visit("/projetos/#list");
  });

  acessProject();
});
