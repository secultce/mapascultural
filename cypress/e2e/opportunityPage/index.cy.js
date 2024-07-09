const { clearAllFilters } = require("../../commands/clearAllFilters");

describe("Oportunidade", () => {
  beforeEach(() => {
    cy.viewport(1920, 1080);
    cy.visit("/oportunidades");
  });

  it("Acessar página de Oportunidades e verificar elementos principais", () => {
    cy.get("h1").contains("Oportunidades");
    cy.contains("Mais recentes primeiro");
    cy.contains("Oportunidades encontradas");
    cy.contains("Filtros de oportunidades");
    cy.contains("Status das oportunidades");
    cy.contains("Tipo de oportunidade");
    cy.contains("Área de interesse");

    cy.get(".opportunity").should("have.length.greaterThan", 0);
    cy.wait(1000);
  });

  it("Aplicar filtro de texto sem resultados", () => {
    cy.wait(1000);
    cy.get(".search-filter__actions--form-input").type("Edital 03/18");
    cy.wait(5000);
    cy.get("p").contains("Nenhuma entidade encontrada").should("be.visible");
    cy.wait(500);
  });

  it("Aplicar filtro de texto com resultados", () => {
    cy.get(".search-filter__actions--form-input").type("Teste");
    cy.wait(1000);
    cy.contains("2 Oportunidades encontradas").should("be.visible");
    cy.wait(500);
  });

  it("Aplicar filtro por status das oportunidades", () => {
    cy.wait(1000);
    cy.get("label").contains("Status das oportunidades").should("be.visible");
    cy.get(":nth-child(2) > input[type=\"radio\"]").click();
    cy.wait(1000);
    cy.contains("Inscrições abertas").should("be.visible");
    cy.get(":nth-child(3) > input[type=\"radio\"]").click();
    cy.wait(1000);
    cy.get("p").contains("Nenhuma entidade encontrada").should("be.visible");
    cy.wait(500);
  });

  it("Aplicar filtro de editais oficiais", () => {
    cy.wait(1000);
    cy.contains("Status das oportunidades");
    cy.get(".verified > input").click();
    cy.wait(1000);
    cy.get("p").contains("Nenhuma entidade encontrada").should("be.visible");
    cy.wait(500);
  });

  it("Aplicar filtro por tipo de oportunidade", () => {
    cy.wait(1000);
    cy.get("label").contains("Tipo de oportunidade");
    cy.get(":nth-child(2) > .mc-multiselect > :nth-child(1) > .v-popper > .mc-multiselect--input").click();
    cy.wait(1000);
    cy.get("label").contains("Concurso").click();
    cy.wait(1000);
    cy.get("p").contains("Nenhuma entidade encontrada").should("be.visible");
  });

  it("Aplicar filtro por área de interesse", () => {
    cy.wait(1000);
    cy.contains("Área de interesse");
    cy.get(":nth-child(3) > .mc-multiselect > :nth-child(1) > .v-popper > .mc-multiselect--input").click();
    cy.get(":nth-child(2) > .item > .text").click();
    cy.wait(1000);
    cy.get("p").contains("Nenhuma entidade encontrada").should("be.visible");
    cy.wait(500);
  });

  it("Limpar todos os filtros na página de oportunidades", () => {
    cy.visit("/oportunidades");
    cy.wait(1000);
    cy.on("uncaught:exception", (err, runnable) => {
      return false;
    });
    clearAllFilters([
      ".form > :nth-child(1) > :nth-child(2)",
      ".verified > input",
      ":nth-child(2) > .mc-multiselect > :nth-child(1) > .v-popper > .mc-multiselect--input",
      ":nth-child(1) > .item > .text",
      ":nth-child(3) > .mc-multiselect > :nth-child(1) > .v-popper > .mc-multiselect--input",
      ":nth-child(2) > .item > .text"
    ], "Limpar todos os filtros");
  });
});
