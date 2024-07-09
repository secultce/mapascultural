const { clearAllFilters } = require("../../commands/clearAllFilters");
const { searchBar } = require("../../commands/searchBar");

describe("Pagina de Agentes", () => {
  beforeEach(() => {
    cy.viewport(500, 768);
    cy.visit("/agentes");
  });

  it("Garante que o usuário possa ver os agentes existentes", () => {
    const texts = [
      "6 Agentes encontrados",
      "Admin@local",
      "Alessandro Feitoza",
      "Henrique Lima",
      "Anna Kelly Moura",
      "Sara Camilo",
      "Talyson Soares"
    ];

    texts.forEach(text => {
      cy.contains(text);
    });
  });

  it("Garante que os filtros na página de agentes funcionam", () => {
    cy.get(".search-filter__actions--formBtn").click({ force: true });
    cy.get(":nth-child(2) > select").select("Agente Individual");
    cy.get(":nth-child(2) > select").should("have.value", "1");
    cy.get(".search-filter__filter--close").click();

    cy.contains("1 Agentes encontrados");
    cy.contains("Admin@local");
  });

  it("Garante que o botão limpar filtros da página de agentes funcionam", () => {
    clearAllFilters([
      ".search-filter__actions--formBtn",
      ".verified > input",
      ":nth-child(2) > select",
      ".mc-multiselect--input",
      ":nth-child(1) > .item > .text",
      ".modal__close"
    ], "6 Agentes encontrados");
  });

  it("Garante que o usuário consiga usar o campo de pesquisa", () => {
    searchBar("Talyson", "1 Agentes encontrados", "Talyson Soares");
  });

  it("clica em \"Acessar\" e entra na pagina do agente selecionado", () => {
    cy.get(":nth-child(7) > .entity-card__footer > .entity-card__footer--action > .button").click();
    cy.url().should("include", "agente/6/#info");
    cy.contains("Talyson Soares");
  });
});
