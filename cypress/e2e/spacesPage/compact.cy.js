const { searchBar } = require("../../commands/searchBar");
const { clearAllFilters } = require("../../commands/clearAllFilters");
describe("Pagina de Espaços", () => {
  beforeEach(() => {
    cy.viewport(500, 768);
    cy.visit("/espacos/#list");
  });

  it("Garante que o usuário possa ver todos os espaços disponíveis", () => {
    const texts = [
      "3 Espaços encontrados",
      "Secretaria da Cultura do Estado do Ceará - SECULT",
      "Biblioteca Municipal Pedro Maia Rocha",
      "Centro Cultural Carnaubeira"
    ];

    texts.forEach(text => {
      cy.contains(text);
    });
  });

  it("Clica em \"Acessar\" e entra na pagina no espaço selecionado", () => {
    cy.get(":nth-child(2) > .entity-card__footer > .entity-card__footer--action > .button").click();
    cy.url().should("include", "/espaco/1/#info");
    cy.contains("Secretaria da Cultura do Estado do Ceará - SECULT");
  });

  it("Garante que os filtros na página de espaços funcionam", () => {
    cy.get(".search-filter__actions > .search-filter__actions--formBtn").click();
    cy.get(":nth-child(2) > .mc-multiselect > :nth-child(1) > .mc-multiselect--input").click();
    cy.get(":nth-child(18) > .item > .text").click({ multiple: true, force: true });
    cy.wait(1000);
    cy.contains("1 Espaços encontrado");
    cy.contains("Biblioteca Municipal Pedro Maia Rocha");
  });

  it("Garante que o usuário consiga usar o campo de pesquisa", () => {
    searchBar("Carnaubeira", "1 Espaços encontrados", "Centro Cultural Carnaubeira");
  });

  it("Garante que o botão limpar filtros na página de espaços funcionam", () => {
    clearAllFilters([
      ".search-filter__actions > .search-filter__actions--formBtn",
      ".form > :nth-child(1) > :nth-child(2)",
      ".verified",
      ":nth-child(2) > .mc-multiselect > :nth-child(1) > .mc-multiselect--input",
      ":nth-child(1) > .item > .text",
      ".modal__close",
      ":nth-child(3) > .mc-multiselect > div > .mc-multiselect--input",
      ":nth-child(1) > .item > .text",
      ".modal__close"
    ], "3 Espaços encontrados");
  });
});
