const { clearAllFilters } = require("../../commands/clearAllFilters");
const { searchBar } = require("../../commands/searchBar");
describe("Pagina de Agentes", () => {
  beforeEach(() => {
    cy.viewport(1920, 1080);
    cy.visit("/agentes");
  });

  it("Garante que a página de agentes funciona", () => {
    cy.url().should("include", "agentes");

    cy.get("h1").contains("Agentes");

    cy.contains("Mais recentes primeiro");
    cy.contains("Agentes encontrados");
    cy.contains("Filtros de agente");
    cy.contains("Status do agente");
    cy.contains("Tipo");
    cy.contains("Área de atuação");
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
    cy.get(":nth-child(2) > select").select("Agente Individual");
    cy.get(":nth-child(2) > select").should("have.value", 1);

    cy.contains("1 Agentes encontrados");
    cy.contains("Admin@local");
  });

  it("Garante que o botão limpar filtros da página de agentes funcionam", () => {
    clearAllFilters([
      ".verified > input",
      ":nth-child(2) > select",
      ".mc-multiselect--input",
      ":nth-child(1) > .item > .text"
    ], "6 Agentes encontrados");
  });

  it("Garante que o usuário consiga usar o campo de pesquisa", () => {
    searchBar("Talyson", "1 Agentes encontrados", "Talyson Soares");
  });

  it("Garante que os filtros de agentes funcionam quando não existem resultados pra busca textual", () => {
    searchBar("Primo", "0 Agentes encontrados");
  });

  it("clica em \"Acessar\" e entra na pagina do agente selecionado", () => {
    cy.get(":nth-child(7) > .entity-card__footer > .entity-card__footer--action > .button").click();
    cy.url().should("include", "agente/6/#info");
    cy.contains("Talyson Soares");
  });
});
