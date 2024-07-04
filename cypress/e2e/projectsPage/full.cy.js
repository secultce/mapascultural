const { clearAllFilters } = require("../../commands/clearAllFilters");
const { acessProject } = require("./index.cy");

describe("Pagina de Projetos", () => {
  beforeEach(() => {
    cy.viewport(1920, 1080);
    cy.visit("/projetos");
  });

  acessProject();

  it("Garante que o botão limpar filtros na pagina de projetos funciona", () => {
    clearAllFilters([
      ".verified",
      ".mc-multiselect--input",
      ":nth-child(1) > .item > .text"
    ], "Projetos encontrados");
  });
});
